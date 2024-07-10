<?php
session_start();
include('connection.php');

// $orgid = 202405231637298741;

$orgid = $_SESSION['adminsuc'];

$query = "SELECT Enrollmentno, Subjectcode, Teacherid, Date, Time, PeriodNo, Stream, Year, Section FROM periodwisestudent_$orgid";
$result = $connection->query($query);

$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

$connection->close();

header('Content-Type: application/json');
echo json_encode($data);
?>
