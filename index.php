<?php
session_abort();
$currentDate = date("Ymd");
$currentTime = date("His");
$randomDigits = str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);
$randomNumber = $currentDate . $currentTime . $randomDigits;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organization Details Form</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: url('background.jpg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #333;
        }

        form {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
            width: 350px;
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            text-align: left;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        button, a {
            display: block;
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            font-size: 16px;
            text-align: center;
            text-decoration: none;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            background-color: #4caf50;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        a {
            background-color: #f1f1f1;
            color: #333;
            border: 1px solid #ccc;
        }

        a:hover {
            background-color: #ddd;
        }

        .link-group {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
        }
    </style>
</head>
<body>
<form action="process_form.php" method="post">
    <br>
    <br>
    <h2>Register Organization</h2>
    <label for="name">Name:</label>
    <input type="text" name="name" required>

    <label for="phone">Phone:</label>
    <input type="text" name="phone" required>

    <label for="email">Email:</label>
    <input type="email" name="email" required>

    <!-- <label  for="orgid">Organization Id:</label> -->
    <input  readonly value="<?php echo $randomNumber ?>" type="hidden" name="orgid" required>

    <label for="orgname">Organization Name:</label>
    <input type="text" name="orgname" required>

    <label for="orgaddress">Organization Address:</label>
    <input type="text" name="orgaddress" required>

    <button type="submit" name="Submit">Register</button>

    <div class="link-group">
        <a href="adminlogin.php">Login as Admin</a>
        <a href="emplogin.php">Login as Teacher</a>
        <a href="studentlogin.php">Login as Student</a>
    </div>
    
</form>
</body>
</html>
