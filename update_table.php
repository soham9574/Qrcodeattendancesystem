<?php
session_start();
include('connection.php');
$orgid = $_SESSION['adminsuc'];


$selectedStream = "All";
$selectedYear = "All";
$selectedAttendance = "All";
$selectedSection = "All";

if (isset($_POST['stream'])) {
    $selectedStream = $_POST['stream'];
}
if (isset($_POST['year'])) {
    $selectedYear = $_POST['year'];
}
if (isset($_POST['attendance'])) {
    $selectedAttendance = $_POST['attendance'];
}
if (isset($_POST['section'])) {
    $selectedSection = $_POST['section'];
}

$_SESSION['streamfilter'] = $selectedStream;
$_SESSION['yearfilter'] = $selectedYear;
$_SESSION['attendancefilter'] = $selectedAttendance;
$_SESSION['sectionfilter'] = $selectedSection;

// Construct your SQL query based on filter values
$query = "SELECT * FROM studentdetails_$orgid WHERE 1";
if ($selectedStream !== "All") {
    $query .= " AND Branch = '$selectedStream'";
}
if ($selectedYear !== "All") {
    $query .= " AND Stdyear = '$selectedYear'";
}
if ($selectedAttendance !== "All") {
    $operator = substr($selectedAttendance, 0, 2);
    $percentage = substr($selectedAttendance, 2);
    $query .= " AND (Attendancecountper $operator $percentage)";
}
if ($selectedSection !== "All") {
    $query .= " AND Section = '$selectedSection'";
}

// Execute the query
$result = mysqli_query($connection, $query);

// Create an HTML table to display the data
echo '<table>
    <tr>
        <th>Stdname</th>
        <th>Emailid</th>
        <th>Section</th>
        <th>Rollno</th>
        <th>Enrollment</th>
        <th>Stdyear</th>
        <th>Stream</th>
        <th>Attendancecount</th>
        <th>Attendancecountper</th>
    </tr>';
while ($row = mysqli_fetch_assoc($result)) {
    echo '<tr>';
    echo '<td>' . $row["Stdname"] . '</td>';
    echo '<td>' . $row["Emailid"] . '</td>';
    echo '<td>' . $row["Section"] . '</td>';
    echo '<td>' . $row["Rollno"] . '</td>';
    echo '<td>' . $row["Enrollment"] . '</td>';
    echo '<td>' . $row["Stdyear"] . '</td>';
    echo '<td>' . $row["Branch"] . '</td>';
    echo '<td>' . $row["Attendancecount"] . '</td>';
    echo '<td>' . $row["Attendancecountper"] . " %" . '</td>';
    echo '</tr>';
}
echo '</table>';
?>
