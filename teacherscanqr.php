<?php
session_start();

$id=$_SESSION['id'] ;
$subjectCode=$_SESSION['subjectcode'] ;
$periodNo=$_SESSION['periodNo'];
$stream=$_SESSION['stream']  ;
$year=$_SESSION['year'] ;
$section=$_SESSION['section'] ;

include('connection.php');
$orgid = $_SESSION['orgid'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Scanner</title>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/3.3.3/adapter.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.min.js"></script>
    <script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f5f5f5;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            padding: 30px;
            max-height: 80vh;
            overflow: hidden;
        }

        #preview {
            width: 100%;
            border: 3px solid #007bff;
            border-radius: 10px;
            margin-top: 10px;
        }

        label {
            font-size: 20px;
            font-weight: bold;
            color: #333;
        }

        .form-control {
            font-size: 18px;
            border-radius: 5px;
        }

        button[type="button"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 8px 20px;
            font-size: 20px;
            cursor: pointer;
            margin-top: 10px;
            transition: background-color 0.3s;
        }

        button[type="button"]:hover {
            background-color: #0056b3;
        }

        .result-text {
            font-size: 18px;
            font-weight: bold;
            margin-top: 2px;
        }

        .row {
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="margin col-md-6">
                <video id="preview"></video>
            </div>
            <div class="margin col-md-6">
                <form id="qrForm" action="newinsert.php" method="post" class="form-horizontal">
                    <input value="" id="text" type="text" name="text" readonly placeholder="Scanning..." class="form-control">
                </form>
                <p class="result-text"><?php echo $_SESSION['text']; ?></p>
                <button type="button" onclick="goBack()">Back</button>
            </div>
        </div>
    </div>

    <script>
        if (typeof Instascan !== 'undefined') {
            let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
            Instascan.Camera.getCameras().then(function (cameras) {
                if (cameras.length > 0) {
                    scanner.start(cameras[0]);
                } else {
                    alert('No cameras found');
                }
            }).catch(function (e) {
                console.error(e);
            });

            scanner.addListener('scan', function (c) {
                console.log('Scanned QR Code:', c);
                document.getElementById('text').value = c;
                document.getElementById('qrForm').submit();
            });
        } else {
            alert('Instascan library is not loaded.');
        }

        function goBack() {
            // $_SESSION['adminsuc']=$orgid;
            window.location.href = 'teacherdashboard.php';
        }
    </script>
</body>
</html>


