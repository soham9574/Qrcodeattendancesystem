<?php
session_start();
include 'connection.php';

if (!isset($_SESSION["orgid"])) {
    die("Organization ID not set in session");
}

$orgid = $_SESSION["orgid"];
$table_name = "teacher_" . $orgid;

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $department = $_POST['department'];
    $mobile_no = $_POST['mobile-no'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $address = $_POST['address'];
    $qualification = $_POST['qualification'];
    $domain_subject = $_POST['domain-subject'];
    $time = time();
    $rand = rand(pow(10, 4-1), pow(10, 4)-1);
    $id = $department . $time . $rand;

    $sql = "INSERT INTO $table_name (id, name, department, mobile_no, email, password, address, qualification, domain_subject)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $connection->prepare($sql);

    if ($stmt === false) {
        die("Error preparing statement: " . $connection->error);
    }

    $stmt->bind_param("sssssssss", $id, $name, $department, $mobile_no, $email, $password, $address, $qualification, $domain_subject);

    if ($stmt->execute()) {
        echo "Organization Id: $orgid <br> Your Id: $id <br> Password: $password <br> Take a screenshot of this, this is very important <br> 
        <a href='emplogin.php'>Login</a>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
$connection->close();
?>
