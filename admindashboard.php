<?php
session_start();
include('connection.php');
$orgid = $_SESSION['adminsuc'] ;
$text = "Scan the Qr Code for attendance";
$_SESSION['text']= $text; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        header {
            background-color: #333;
            color: white;
            padding: 2px;
            text-align: center;
            
        }

        .container {
            max-width: 900px;
            height: 570px;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            
        }
        .container :hover{
            cursor:pointer;
        }

        .greetings {
            margin-bottom: 20px;
            font-size: 24px;
            text-align: center;
            color: #333;
        }

        .options-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            justify-content: center;
        }

        .dashboard-option {
            width: 85%;
            height: 80px;
            padding: 15px;
            display:flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            background-color: #008F7A;
            color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: background-color 0.3s;
            font-size: 16px;
            margin-bottom: 20px; /* Adjusted margin between buttons */
        }

        .dashboard-option:hover {
            background-color: #45a049;
        }
        button{
            height:39px;
            width: 100%;
            background-color:blue;
            margin-top: 10px;
            margin-bottom:15px;
            background-color: #051937;
           color: white;
           border-radius:10px;
        }
        .datetime {
            text-align: center;
            margin-top: 20px;
            height: 20px;
            font-size: 18px;
            color: #555;
            background-color: #f9f9f9;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .datetime{
          background-color: #051937;
          color:white;
        }
    </style>
</head>
<body>

<header>
    <h1>Admin Dashboard</h1>
</header>

<div class="container">
    <div class="greetings" id="greetings"></div>

    <div class="options-container">
        <div class="dashboard-option" onclick="navigate('fetchtable.php')">Student Details</div>
        <div class="dashboard-option" onclick="navigate('settings.php')">Organization Settings</div>
        <div class="dashboard-option" onclick="navigate('displayattende.php')">Detail Attendance</div>
        <div class="dashboard-option" onclick="navigate('createteacher.php')">Add Teachers</div>
        <div class="dashboard-option" onclick="navigate('studreg.php')">Add Students</div>

        <div type="submit" name="scanqr" class="dashboard-option" onclick="navigate('scanqr.php')">Scan QR</div>

    </div>

    <div class="datetime" id="datetime"></div>
    <div class="logout">
         <button class="logout" onclick="logout()" >Logout</button>
    </div>
</div>

<script>
    function navigate(page) {
        window.location.href = page;
    }

    function updateDateTime() {
        var greetings = document.getElementById('greetings');
        var datetime = document.getElementById('datetime');
        var currentTime = new Date();
        var hours = currentTime.getHours();

        if (hours < 12) {
            greetings.innerHTML = 'Good Morning, Admin!';
        } else if (hours < 17) {
            greetings.innerHTML = 'Good Afternoon, Admin!';
        } else if (hours < 20) {
            greetings.innerHTML = 'Good Evening, Admin!';
        } else {
            greetings.innerHTML = 'Good Night, Admin!';
        }
        datetime.innerHTML = currentTime.toLocaleString();
    }
    window.onload = function() {
        updateDateTime();
        setInterval(updateDateTime, 1000);
    };

    const logout=()=>{
        window.location.href = 'index.php';
    }
</script>
<?php


    

?>
</body>
</html>
