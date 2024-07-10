<?php
session_start();

$_SESSION["text"] = "Scan the Qr Code for attendance";

if (isset($_POST['submit'])) {
    include('connection.php');

    $orgid = $_POST['orgId'];
    $username = $_POST['empUsername'];
    $password = $_POST['empPassword'];
    $_SESSION['orgid'] = $orgid;
    $_SESSION['empsuc'] = $username;

    // Prepared statement to prevent SQL injection
    $sql = "SELECT * FROM teacher_$orgid WHERE id = ? AND password = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    // Debugging
    if ($result) {
        echo "Query executed successfully.<br>";
    } else {
        echo "Error executing query: " . $stmt->error . "<br>";
    }

    if ($result->num_rows > 0) {
        // Debugging
        echo "User found. Redirecting...<br>";
        header("teacherdashboard.php");

        ?>
        <script>
            location.replace('teacherdashboard.php');
        </script>
        <?php
    } else {
        echo '<script>alert("Wrong username or password"); window.location.href="emplogin.php";</script>';
    }

    $stmt->close();
    $connection->close();
}
?>
