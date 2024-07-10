<?php
include("connection.php");
session_start();
$orgid = $_SESSION['adminsuc'];
// error_reporting(E_ALL);
// ini_set('display_errors', 1);




$streamfilter=$_SESSION['streamfilter'];
$yearfilter=$_SESSION['yearfilter'];
$attendancefilter=$_SESSION['attendancefilter'];
$sectionfilter=$_SESSION['sectionfilter'];




$query = "SELECT * FROM studentdetails_$orgid Stdyear";

$result = mysqli_query($connection, $query);
$array = array();
$filename = 'AttendanceRecord-'.date('Y-m-d').'.csv';
$file = fopen($filename,"w");
$array= array("Stdname","Section","Rollno","Branch","Enrollment","Attendancecountper");

fputcsv($file, $array);

while ($row = mysqli_fetch_array($result)) {

  $Stdname = $row['Stdname'];
  $Section = $row['Section'];
  $Rollno = $row['Rollno'];
  $Branch = $row['Branch'];
  $Enrollment = $row['Enrollment'];
  $Attendancecountper = $row['Attendancecountper'];

  $array = array($Stdname,$Section,$Rollno,$Branch,$Enrollment,$Attendancecountper) ;

  fputcsv($file, $array);

 }

 fclose($file);
 header("Content-Description: File Transfer");
 header("Content-Disposition: Attachment; filename=$filename");
 header("Content-type: text/csv");
 readfile($filename);
 unlink($filename);
 exit();

?>