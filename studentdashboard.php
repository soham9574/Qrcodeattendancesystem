<?php
session_start();
include('connection.php');

// Check if the student email session variable is set
if (!isset($_SESSION['student_email'])) {
    header('location:studentlogin.php');
    exit();
}

$email = $_SESSION['student_email'];
$orgid = $_SESSION['org_id'];
$enrollment = $_SESSION['student_pass'];

// Fetch student details from the database
$query = "SELECT Stdname, Emailid, Section, Rollno, Enrollment, Stdyear, Branch, Qrcode FROM studentdetails_$orgid WHERE Emailid = ?";
$stmt = $connection->prepare($query);
if (!$stmt) {
    die("Prepare failed: (" . $connection->errno . ") " . $connection->error);
}
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
if (!$result) {
    die("Error fetching data: " . $connection->error);
}
$studentData = $result->fetch_assoc();
$stmt->close();

if (!$studentData) {
    die("No student data found.");
}

// Fetch subjects for the student's semester and branch
$semester = $studentData['Stdyear'];
$branch = $studentData['Branch'];
$newQuery = "SELECT Subjectcode, Subjectname FROM subjects_$orgid WHERE Semester = ? AND Stream = ?";
$stmt = $connection->prepare($newQuery);
if (!$stmt) {
    die("Prepare failed: (" . $connection->errno . ") " . $connection->error);
}
$stmt->bind_param("is", $semester, $branch);
$stmt->execute();
$subjectResult = $stmt->get_result();
$subjects = $subjectResult->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Fetch attendance data for each subject
$attendanceData = [];
$totalClassesAttended = 0;
$totalClassesOccurred = 0;
foreach ($subjects as $subject) {
    $subjectCode = $subject['Subjectcode'];
    $attendanceQuery = "SELECT COUNT(*) AS total_classes, 
                        (SELECT COUNT(*) FROM periodwisestudent_$orgid WHERE Enrollmentno = ? AND Subjectcode = ?) AS attended_classes 
                        FROM periodwisestudent_$orgid WHERE Subjectcode = ?";
    $stmt = $connection->prepare($attendanceQuery);
    if (!$stmt) {
        die("Prepare failed: (" . $connection->errno . ") " . $connection->error);
    }
    $stmt->bind_param("sss", $enrollment, $subjectCode, $subjectCode);
    $stmt->execute();
    $attendanceResult = $stmt->get_result();
    $attendance = $attendanceResult->fetch_assoc();
    $attendanceData[$subjectCode] = $attendance;
    $totalClassesAttended += $attendance['attended_classes'];
    $totalClassesOccurred += $attendance['total_classes'];
    $stmt->close();
}

$overallAttendancePercentage = $totalClassesOccurred > 0 ? ($totalClassesAttended / $totalClassesOccurred) * 100 : 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
/* CSS for larger screens */
body {
    background-color: #f8f9fa;
    font-family: 'Arial', sans-serif;
}

.container {
    background-color: #ffffff;
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    padding: 20px;
    margin-top: 20px;
}

.student-details {
    position: relative;
    padding-bottom: 0px;
    padding-top: 10px;
    margin-bottom: 30px;
    display: flex;
    flex-wrap: wrap;
    background-image: linear-gradient(to right top, #d16ba5, #c777b9, #ba83ca, #aa8fd8, #9a9ae1, #8aa7ec, #79b3f4, #69bff8, #52cffe, #41dfff, #46eefa, #5ffbf1);
}

.student-details img {
    width: 100%;
    max-width: 275px;
    height: auto;
    position: absolute;
    top: 20px;
    right: 20px;
}

.subjects-container {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    margin-top: 20px;
}

.subject-box {
    background-color: #e9ecef;
    border-radius: 8px;
    padding: 20px;
    flex: 1 1 calc(33.333% - 20px);
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.subject-box h5 {
    margin-bottom: 10px;
    font-size: 18px;
}

.subject-box p {
    margin-bottom: 20px;
    font-size: 16px;
}

.btn-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    margin-top: 20px;
}

.btn-container .btn {
    width: 100%;
    max-width: 48%;
    margin-bottom: 10px;
}

.attendance-summary {
    text-align: center;
    margin-top: 40px;
    margin-bottom: 40px;
    color: black;
    padding: 30px;
    border-radius: 8px;
    background-image: linear-gradient(to left top, #15da7e, #00c8b4, #00b0de, #0093ec, #006fd6, #0070d6, #0070d5, #0071d5, #0098ec, #00bbf5, #00dcf5, #5ffbf1);
}

.attendance-summary h4 {
    margin-bottom: 10px;
    font-size: 24px;
}

.attendance-summary p {
    font-size: 18px;
}

/* CSS for smaller screens */
@media (max-width: 768px) {
    .student-details {
        justify-content: center;
        align-items:center;
        height:86vh;
    }

    .student-details img {
        position: static;
        width: 112%;
        max-width: 300px;
        /* margin-top: -10px; */
        margin-bottom: 25px;
    }

    .subject-box {
        flex: 1 1 calc(50% - 20px);
    }

    .btn-container .btn {
        max-width: 100%;
    }
}


@media (max-width: 576px) {
    .subject-box {
        flex: 1 1 calc(100% - 20px);
    }
}



    </style>
</head>

<body>


    <div class="container">
        <h2 class="text-center mb-4">Student Dashboard</h2>
        <div class="card student-details">
            <div class="card-body">
                <h5 class="card-title">Student Details</h5>
                <p><strong>Name:</strong> <?php echo htmlspecialchars($studentData['Stdname']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($studentData['Emailid']); ?></p>
                <p><strong>Section:</strong> <?php echo htmlspecialchars($studentData['Section']); ?></p>
                <p><strong>Roll No:</strong> <?php echo htmlspecialchars($studentData['Rollno']); ?></p>
                <p><strong>Enrollment:</strong> <?php echo htmlspecialchars($studentData['Enrollment']); ?></p>
                <p><strong>Year:</strong> <?php echo htmlspecialchars($studentData['Stdyear']); ?></p>
                <p><strong>Branch:</strong> <?php echo htmlspecialchars($studentData['Branch']); ?></p>
            </div>
            <div class="image">
            <img src="images/<?php echo htmlspecialchars($studentData['Qrcode']); ?>" alt="QR Code">
            </div>
        </div>



        <div class="attendance-summary">
            <h4>Overall Attendance Summary</h4>
            <p><strong>Total Classes Attended:</strong> <?php echo $totalClassesAttended; ?></p>
            <p><strong>Total Classes Occurred:</strong> <?php echo $totalClassesOccurred; ?></p>
            <p><strong>Attendance Percentage:</strong> <?php echo round($overallAttendancePercentage, 2); ?>%</p>
        </div>

        <div class="subjects-container">
            <?php foreach ($subjects as $subject): 
                $subjectCode = $subject['Subjectcode'];
                $totalClasses = $attendanceData[$subjectCode]['total_classes'] ?? 0;
                $attendedClasses = $attendanceData[$subjectCode]['attended_classes'] ?? 0;
                $attendancePercentage = $totalClasses > 0 ? ($attendedClasses / $totalClasses) * 100 : 0;
            ?>
                <div class="subject-box">
                    <h5><?php echo htmlspecialchars($subject['Subjectcode']); ?></h5>
                    <p><?php echo htmlspecialchars($subject['Subjectname']); ?></p>
                    <button class="btn btn-info" data-toggle="modal" data-target="#attendanceModal" 
                            data-subjectcode="<?php echo htmlspecialchars($subject['Subjectcode']); ?>"
                            data-subjectname="<?php echo htmlspecialchars($subject['Subjectname']); ?>"
                            data-totalclasses="<?php echo $totalClasses; ?>"
                            data-attendedclasses="<?php echo $attendedClasses; ?>"
                            data-attendancepercentage="<?php echo round($attendancePercentage, 2); ?>">
                        View Details
                    </button>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="btn-container">
            <a href="studcheckatd.php" class="btn btn-primary">Check Attendance</a>
            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#logoutModal">Logout</button>
        </div>
    </div>

    <!-- Attendance Modal -->
    <div class="center modal fade" id="attendanceModal" tabindex="-1" aria-labelledby="attendanceModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="attendanceModalLabel">Attendance Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><strong>Subject Code:</strong> <span id="modalSubjectCode"></span></p>
                    <p><strong>Subject Name:</strong> <span id="modalSubjectName"></span></p>
                    <p><strong>Total Classes:</strong> <span id="modalTotalClasses"></span></p>
                    <p><strong>Attended Classes:</strong> <span id="modalAttendedClasses"></span></p>
                    <p><strong>Attendance Percentage:</strong> <span id="modalAttendancePercentage"></span>%</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Logout Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutModalLabel">Confirm Logout</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to log out?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <a href="studentlogin.php" class="btn btn-danger">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $('#attendanceModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var subjectCode = button.data('subjectcode');
            var subjectName = button.data('subjectname');
            var totalClasses = button.data('totalclasses');
            var attendedClasses = button.data('attendedclasses');
            var attendancePercentage = button.data('attendancepercentage');

            var modal = $(this);
            modal.find('#modalSubjectCode').text(subjectCode);
            modal.find('#modalSubjectName').text(subjectName);
            modal.find('#modalTotalClasses').text(totalClasses);
            modal.find('#modalAttendedClasses').text(attendedClasses);
            modal.find('#modalAttendancePercentage').text(attendancePercentage.toFixed(2));
        });
    </script>
</body>

</html>
