<!DOCTYPE html>
<html>
<head>
    <title>Registration Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        header {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 20px 0;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333;
        }

        form {
            margin-top: 20px;
        }

        label {
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .btn {
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .qr-code {
            text-align: center;
            margin-top: 20px;
        }

        img {
            max-width: 100%;
            height: auto;
            margin-top: 10px;
        }

        a {
            text-decoration: none;
            color: blue;
        }
    </style>
</head>
<body>
   
    <div class="container">
        <?php
           
            if (isset($_POST['submit'])) {
                include('connection.php');
                require_once 'phpqrcode/qrlib.php';
            
                $path = 'images/';
                $qrimage = time() . ".png";
                
                $Organisationid = $_POST["orgid"];
                $studentName = $_POST["studentName"];
                $stream = $_POST["stream"];
                $email = $_POST["email"];
                $section = $_POST["section"];
                $rollNo = $_POST["rollNo"];
                $enrollmentNo = $_POST["enrollmentNo"];
                $year = $_POST["year"];
                $qrtext = $_POST['enrollmentNo'];
            
                // Add single quotes around $enrollmentNo in the query
                $enroll_search = "SELECT * FROM `studentdetails_$Organisationid` WHERE Enrollment = '$enrollmentNo'";
                $query = mysqli_query($connection, $enroll_search);

                if ($query) {
                    $enroll_count = mysqli_num_rows($query);
                } else {
                    echo "Error executing query: " . mysqli_error($connection);
                    exit();
                }

                if ($enroll_count == 0) {
                    $sql = "INSERT INTO studentdetails_$Organisationid (Stdname, Emailid, Section, Rollno, Enrollment, Stdyear, Branch, Attendancecount, Attendancecountper, Qrcode) 
    VALUES ('$studentName', '$email', '$section', '$rollNo', '$qrtext', '$year', '$stream', 0, 0, '$qrimage')";
            
                    if (mysqli_query($connection, $sql)) {
                        
                        $qrcode = $path . $qrimage;
                        QRcode::png($qrtext, $qrcode, 'H', 4, 4);
            
                        
                        echo "<h2>Registration successful!</h2>";
                        echo "<img src='" . $qrcode . "' alt='QR Code'>";
                        echo "<br>";
                        echo "<a href='" . $qrcode . "' download>Download QR Code</a>";
                        echo"</br>";
                        echo"</br>";
                        exit();
                    } else {
                        echo "Error: " . mysqli_error($connection);
                    }
                } else {
                    echo "Already registered";
                    echo"</br>";
                }
            }
        ?>
    </div>
</body>
</html>
