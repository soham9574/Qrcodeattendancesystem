<?php
session_start();
include('connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $orgid = $_POST['orgid'];
    $email = $_POST['email'];
    $enrollment = $_POST['password']; // Assuming Enrollment is the password
    $_SESSION['org_id'] = $orgid;
    $_SESSION['student_email'] = $email;
    $_SESSION['student_pass']=$enrollment;

    // Check if the email and password match in the database
    $query = "SELECT ID, Stdname FROM studentdetails_$orgid WHERE Emailid = ? AND Enrollment = ?";
    $stmt = $connection->prepare($query);
    
    // Check if the query preparation was successful
    if ($stmt) {
        $stmt->bind_param("ss", $email, $enrollment);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            // Login successful
            $row = $result->fetch_assoc();
            header("Location: studentdashboard.php");
            exit();
        } else {
            // Login failed
            ?>
            <script>
              alert('Wrong Student Credentials or Student is not valid');
            </script>

            <?php
            header("Location: studentlogin.php");
            exit();
        }
    } else {
        // Error in preparing the query
        echo "Error in preparing the query: " . $connection->error;
    }
} else {
    header("Location: studentlogin.php");
    exit();
}
?>
