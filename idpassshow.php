<?php
session_start();

$orgid= $_SESSION["orgid"] ;
$pass=$_SESSION["pass"];

?>
<!DOCTYPE html>
<html lang="en">
<head>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Interface</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f0f0;
        }

        .container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
        }

        .box {
            margin-bottom: 20px;
            padding: 15px;
            border: 2px solid #007bff;
            border-radius: 5px;
        }

        label {
            font-size: 18px;
            font-weight: bold;
            display: block;
            margin-bottom: 10px;
        }

        span {
            font-size: 16px;
            color: #333333;
        }

        button {
            background-color: #007bff;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="box">
            <label>Your organization ID is:</label>
            <span><?php echo  $orgid ?></span>
        </div>
        <div class="box">
            <label>Your login password is:</label>
            <span><?php echo  $pass ?></span>
        </div>
        <button onclick="changeLocation()">Log In</button>
        <button onclick="takeScreenshot()">Take Screenshot</button>
    </div>

<script>
function takeScreenshot() {
    const width = window.innerWidth;
    const height = window.innerHeight;

    html2canvas(document.body).then(canvas => {
        const dataURL = canvas.toDataURL('image/jpeg');

        const link = document.createElement('a');
        link.href = dataURL;
        link.download = 'credential.jpg';

        document.body.appendChild(link);
        link.click();

        document.body.removeChild(link);
    });
}

  function changeLocation() {
              alert("Take the screenshot of this page while leaving this page as this credentials are required on login");

            window.location.href = 'adminlogin.php';
     
        }
    
</script>
    
</body>
</html>