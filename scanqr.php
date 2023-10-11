<?php
session_start();
if($_SESSION['$empsuc']==""){
    header("Location: emplogin.php");
}

if (!isset($_SESSION["text"])) {
    $_SESSION["text"] = "Scan the QR and Mark the attendance";
}

include('connection.php');
$currentDateTime = date('Y-m-d H:i:s');
if (isset($_POST['submit'])) {
    $c = $_POST['text'];

    $update_sql = "UPDATE studentdetails SET Attendancecount = Attendancecount + 1 WHERE Enrollment = '$c'";
    if (mysqli_query($connection, $update_sql)) {
        $_SESSION["text"] = "Attendance recorded for $c on $currentDateTime";

        header("Location: scanqr.php");
        exit(); 
    } else {
        $_SESSION["text"] = "Error updating attendance: " . mysqli_error($connection);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/3.3.3/adapter.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.min.js"></script>
    <script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<style>
        body {
            background-color: #f0f0f0;
            font-family: Arial, sans-serif;
        }

        .container {
            margin-top: 30px;
            background-color: #ffffff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
        }

        #preview {
            width: 100%;
        }

        label {
            font-size: 18px;
        }

        .form-control {
            font-size: 16px;
            border-radius: 5px;
        }

        button[type="submit"] {
            background-color: #007bff;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 18px;
            cursor: pointer;
            margin-top: 10px;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }

        .result-text {
            font-size: 18px;
            font-weight: bold;
            margin-top: 10px;
        }

        
        @media (max-width: 768px) {
            .container {
                margin-top: 10px;
            }

            .col-md-6 {
                margin-top: 10px;
            }
        }
    </style>
</head>
<body>
<form method="post" action="">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <video id="preview"></video>
            </div>
            <div class="col-md-6">
                <label>SCAN QR CODE</label>
                <input value="" id="text" type="text" name="text" readonly="" placeholder="Scan QR Code" class="form-control">
                <button name="submit" type="submit">Mark</button>
                <p class="result-text"><?php echo $_SESSION["text"]; ?></p>
            </div>
        </div>
    </div>
</form>

<script>
    if (typeof Instascan !== 'undefined') {
        let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
        Instascan.Camera.getCameras().then(function(cameras) {
            if (cameras.length > 0) {
                scanner.start(cameras[0]);
            } else {
                alert('No cameras found');
            }
        }).catch(function(e) {
            console.error(e);
        });

        scanner.addListener('scan', function(c) {
            console.log('Scanned QR Code:', c);

       
            document.getElementById('text').value = c;
        });
    } else {
        alert('Instascan library is not loaded.');
    }
</script>
</body>
</html>
