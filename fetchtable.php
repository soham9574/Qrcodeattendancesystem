<?php
session_start();
if($_SESSION['$adminsuc']==""){
    header("Location: adminlogin.php");
}


include('connection.php');


$sql = "SELECT * FROM studentdetails";
$result = mysqli_query($connection, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "<!DOCTYPE html>";
    echo "<html lang='en'>";
    echo "<head>";
    echo "<meta charset='UTF-8'>";
    echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
    echo "<title>Student Details</title>";
    echo "<style>";
    echo "table {";
    echo "    font-family: Arial, sans-serif;";
    echo "    border-collapse: collapse;";
    echo "    width: 100%;";
    echo "}";

    echo "table, th, td {";
    echo "    border: 1px solid #ccc;";
    echo "}";

    echo "th, td {";
    echo "    padding: 10px;";
    echo "    text-align: left;";
    echo "}";

    echo "th {";
    echo "    background-color: #007BFF;";
    echo "    color: white;";
    echo "}";
    
    echo "img {";
    echo "    max-width: 100px;";
    echo "    max-height: 100px;";
    echo "}";

    echo "</style>";
    echo "</head>";
    echo "<body>";
    echo "<h2>Student Details</h2>";
    echo "<table>";
    echo "<tr><th>Stdname</th><th>Emailid</th><th>Section</th><th>Rollno</th><th>Enrollment</th><th>Stdyear</th><th>Attendancecount</th><th>Attendancecountper</th><th>Qrcode</th></tr>";

  
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row["Stdname"] . "</td>";
        echo "<td>" . $row["Emailid"] . "</td>";
        echo "<td>" . $row["Section"] . "</td>";
        echo "<td>" . $row["Rollno"] . "</td>";
        echo "<td>" . $row["Enrollment"] . "</td>";
        echo "<td>" . $row["Stdyear"] . "</td>";
        echo "<td>" . $row["Attendancecount"] . "</td>";
        echo "<td>" . $row["Attendancecountper"] . "</td>";
        echo "<td><img src='images/" . $row["Qrcode"] . "' alt='QR Code'></td>";
        echo "</tr>";
    }

    echo "</table>";
    echo "</body>";
    echo "</html>";
} else {
    echo "No records found in the studentdetails table.";
}

mysqli_close($connection);
?>
