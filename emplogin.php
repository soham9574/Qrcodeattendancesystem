<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            padding: 20px;
            width: 300px;
        }

        h2 {
            text-align: center;
            color: #007BFF;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            font-weight: bold;
            color: #333;
        }

        input[type="text"], input[type="password"] {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 3px;
            font-size: 16px;
        }

        button[type="submit"] {
            background-color: #007BFF;
            color: #fff;
            padding: 12px;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
    <div class="container">
        <h2>Employee Login</h2>
        <form action="" method="post">
            <label for="studentUsername">Username:</label>
            <input type="text" id="studentUsername" name="empUsername" required>
            <label for="studentPassword">Password:</label>
            <input type="password" id="studentPassword" name="empPassword" required>
            <button type="submit">Login as Employee</button>
        </form>
    </div>



    <?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include('connection.php');
    
    $username = $_POST['empUsername'];
    $password = $_POST['empPassword'];
    
    $sql = "SELECT * FROM employee WHERE username = '$username' AND password = '$password'";
    $result = $connection->query($sql);
    
    if ($result->num_rows > 0) {
        header("Location: scanqr.php");
        $_SESSION['$empsuc']=$username;
        exit();
    } else {
        ?>
        <script>
        alert ("Wrong username or password");
        header("Location: emplogin.php");

        </script>
        <?php

    }
    
    $connection->close();
}
?>

</body>
</html>
