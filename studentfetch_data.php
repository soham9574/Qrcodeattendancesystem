<?php
session_start();
include('connection.php');

$orgid = $_SESSION['org_id'];
$enroll = $_SESSION['student_pass'];

$query = "SELECT Enrollmentno, Subjectcode, Teacherid, Date, Time, PeriodNo, Stream, Year, Section 
          FROM periodwisestudent_$orgid 
          WHERE Enrollmentno = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param("s", $enroll);
$stmt->execute();
$result = $stmt->get_result();

$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

$stmt->close();
$connection->close();

header('Content-Type: application/json');
echo json_encode($data);
?>
