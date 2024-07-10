<?php
session_start();
include('connection.php');

$orgid = 202405231637298741;

$id = $_SESSION['id'];
$subjectCode = $_SESSION['subjectcode'];
$periodNo = $_SESSION['periodNo'];
$stream = $_SESSION['stream'];
$year = $_SESSION['year'];
$section = $_SESSION['section'];
$enrollmentNo = $_POST['text'];

$date = date("Y-m-d");
$time = date("H:i:s");

// Check if the student belongs to the specified stream, year, and section
$query_check_student = "SELECT COUNT(*) AS count FROM studentdetails_$orgid WHERE Enrollment = ? AND Branch = ? AND Stdyear = ? AND Section = ?";
$stmt_check_student = $connection->prepare($query_check_student);
$stmt_check_student->bind_param("ssss", $enrollmentNo, $stream, $year, $section);
$stmt_check_student->execute();
$stmt_check_student->bind_result($student_count);
$stmt_check_student->fetch();
$stmt_check_student->close();

if ($student_count > 0) {
    // Check if the attendance entry already exists for the same date, enrollment number, and period number
    $query_check_attendance = "SELECT COUNT(*) AS count FROM periodwisestudent_$orgid WHERE Date = ? AND Enrollmentno = ? AND PeriodNo = ?";
    $stmt_check_attendance = $connection->prepare($query_check_attendance);
    $stmt_check_attendance->bind_param("sss", $date, $enrollmentNo, $periodNo);
    $stmt_check_attendance->execute();
    $stmt_check_attendance->bind_result($attendance_count);
    $stmt_check_attendance->fetch();
    $stmt_check_attendance->close();

    if ($attendance_count > 0) {
        ?>
        <script>
            alert('Student attendance already done for this period');
            window.location.href = 'teacherscanqr.php';
        </script>
        <?php
    } else {
        // Proceed with insertion
        $query_insert = "INSERT INTO periodwisestudent_$orgid (Enrollmentno, Subjectcode, Teacherid, Date, Time, PeriodNo, Stream, Year, Section) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt_insert = $connection->prepare($query_insert);

        if (!$stmt_insert) {
            echo "Prepare failed: (" . $connection->errno . ") " . $connection->error;
        } else {
            $stmt_insert->bind_param("sssssssss", $enrollmentNo, $subjectCode, $id, $date, $time, $periodNo, $stream, $year, $section);

            if ($stmt_insert->execute()) {
                // echo "Data inserted successfully! $enrollmentNo";
                ?>
                <script>
                    alert('Inserted Successfully');
                    window.location.href = 'teacherscanqr.php';
                </script>
                <?php
            } else {
                ?>
                <script>
                    alert('Insertion error');
                </script>
                <?php
            }

            $stmt_insert->close();
        }
    }
} else {
    ?>
    <script>
        alert('Student not belong to the specified stream , Section or Year');
        window.location.href = 'teacherscanqr.php';
    </script>
    <?php
}

$connection->close();
?>
