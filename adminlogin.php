<?php
session_start();

// $orgid= $_SESSION["orgid"] ;
// $pass=$_SESSION["pass"];
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
    <h2>Admin Login</h2>
    <form method="post">
        <label for="adminUsername">Organization Id:</label>
        <input type="text" id="adminUsername" name="adminUsername" required>
        <label for="adminPassword">Password:</label>
        <input type="password" id="adminPassword" name="adminPassword" required>
        <button type="submit" name="loginButton">Login as Admin</button>
    </form>
</div>

<?php
if (isset($_POST['loginButton'])) {
    include('connection.php');
    
    $username = $_POST['adminUsername'];
    $password = $_POST['adminPassword'];
    
    $sql = "SELECT * FROM organisationdetails WHERE orgid = '$username' AND pass = '$password'";
    $result = $connection->query($sql);

    if ($result === false) {
        die('Error executing the query: ' . $connection->error);
    }
    
    if ($result->num_rows > 0) {
        session_start();
        $_SESSION['adminsuc'] = $username;
        header("Location: admindashboard.php");
        exit();
    } else {
        echo '<script>alert("Wrong username or password");</script>';
    }
    
    $connection->close();

}
?>
</body>
</html>
