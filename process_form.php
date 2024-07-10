<?php
session_start();
include 'connection.php';

$pass = random_int(10000000, 99999999);
$total = 60;

$query = "CREATE TABLE IF NOT EXISTS Organisationdetails (
    id INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(255),
    Phone VARCHAR(15) UNIQUE,
    Email VARCHAR(255) UNIQUE,
    Orgid VARCHAR(255) UNIQUE,
    Orgname VARCHAR(255),
    Pass VARCHAR(8),
    Orgaddress VARCHAR(255),
    Entryin TIME,
    Entryout TIME,
    Exitin TIME,
    Exitout TIME,
    Total INT(15)
)";
$result = mysqli_query($connection, $query);

if ($result) {
    echo "Table Created";
} else {
    echo "Error creating table: " . mysqli_error($connection);
}

///INSERTING THE VALUES INTO ORGANISATION DETAIL

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $orgid = $_POST["orgid"];
    $orgname = $_POST["orgname"];
    $address = $_POST["orgaddress"];
    $entryTime = '09:00:00';
    $entryClose = '09:35:00';
    $exitTime = '16:10:00';
    $exitClose = '16:50:00';

    $query = "INSERT INTO Organisationdetails (Name, Phone, Email, Orgname, Orgid, Orgaddress, Pass,Entryin,Entryout,Exitin,Exitout,Total) VALUES ('$name', '$phone', '$email', '$orgname', '$orgid', '$address', '$pass',' $entryTime','$entryClose','$exitTime','$exitClose' ,'$total')";

    $result = mysqli_query($connection, $query);

    if ($result) {
        $_SESSION["orgid"] = $orgid;
        $_SESSION["pass"]=$pass;

    } else {
        echo "Error inserting data: " . mysqli_error($connection);
    }
}

/////Creating Student table 

$sql = "
CREATE TABLE studentdetails_$orgid (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Stdname VARCHAR(255),
    Emailid VARCHAR(255),
    Section VARCHAR(50),
    Rollno VARCHAR(20),
    Enrollment VARCHAR(50),
    Stdyear VARCHAR(10),
    Branch VARCHAR(50),
    Attendancecount INT,
    Attendancecountper INT,
    Qrcode BLOB,
    EntryTime TIME,
    ExitTime TIME
    
)";

if ($connection->query($sql) === TRUE) {
    echo "Table studentdetails created successfully";
    ?>
    <?php

} else {
    echo "Error creating table: " . $connection->error;

}

////Creating the fetch table 
$sqlfetch = "
CREATE TABLE fetchtable_$orgid (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Enrollment VARCHAR(50),
    Date DATE,
    Timein TIME,
    Timeout TIME

)";

if ($connection->query($sqlfetch) === TRUE) {
    echo "Table 'attendance' created successfully";
} else {
    echo "Error creating table: " . $connection->error;
}

// Create Employee Table
// $sqlemployee = "
// CREATE TABLE employee_$orgid (
//     id INT AUTO_INCREMENT PRIMARY KEY,
//     username VARCHAR(50),
//     password VARCHAR(50)
// )";

// if ($connection->query($sqlemployee) === TRUE) {

//     window.location="idpassshow.php";
//    </script>

//    <?php
// } else {
//     echo "Error creating table: " . $connection->error;
// }

$table_name = "teacher_" . $orgid;

// SQL statement to create the table
$sqlteacher = "CREATE TABLE $table_name (
    id VARCHAR(255)PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    department VARCHAR(100) NOT NULL,
    mobile_no VARCHAR(15) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    address TEXT NOT NULL,
    qualification VARCHAR(100) NOT NULL,
    domain_subject VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

// Execute the query
if ($connection->query($sqlteacher) === TRUE) {
    echo "Table $table_name created successfully";
} else {
    echo "Error creating table: " . $connection->error;
}
$sqlclasswise = "CREATE TABLE periodwisestudent_$orgid (
    Enrollmentno VARCHAR(50) NOT NULL,
    Subjectcode VARCHAR(50) NOT NULL,
    Teacherid VARCHAR(50) NOT NULL,
    Date DATE NOT NULL,
    Time TIME NOT NULL,
    PeriodNo INT NOT NULL,
    Stream VARCHAR(50) NOT NULL,
    Year INT NOT NULL,
    Section VARCHAR(10) NOT NULL,

)";

if ($connection->query($sqlclasswise) === TRUE) {
    echo "Table periodwisestudent_202405231637298741 created successfully";
} else {
    echo "Error creating table: " . $connection->error;
}

//Create subject table
$sqlcreatesubject = "CREATE TABLE subjects_202405231637298741 (
    id INT AUTO_INCREMENT PRIMARY KEY,
    Semester VARCHAR(50) NOT NULL,
    Stream VARCHAR(50) NOT NULL,
    Subjectcode VARCHAR(50) NOT NULL,
    Subjectname VARCHAR(100) NOT NULL,
    Totalclass INT NOT NULL
)";

if ($connection->query($sqlcreatesubject) === TRUE) {
    echo "Table subjects_202405231637298741 created successfully";
} else {
    echo "Error creating table: " . $connection->error;
} 



mysqli_close($connection);

?>