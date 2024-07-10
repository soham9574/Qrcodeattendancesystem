

<?php
session_start();
include('connection.php');
?>


<?php
$orgid = $_SESSION['adminsuc'];
$query_settings = "SELECT * FROM organisationdetails WHERE Orgid = '$orgid'";
$result_set = mysqli_query($connection, $query_settings);

if ($row = mysqli_fetch_assoc($result_set)) {
    // $name = $_row['Name'];
    $entryTime = $row['Entryin'];
    $entryClose = $row['Entryout'];
    $exitTime = $row['Exitin'];
    $exitClose = $row['Exitout'];
    $total = $row['Total'];
} else {
    echo "No data found!";
}

$_SESSION["text"] = "Scan the Qr Code for attendance";

date_default_timezone_set('Asia/Kolkata');

$currentDate = date('Y-m-d');
$currentTime = date('H:i:s');

$entryTime = strtotime($entryTime);
$entryClose = strtotime($entryClose);
$exitTime = strtotime($exitTime);
$exitClose = strtotime($exitClose);






$isEntryTime = 0;
$isExitTime = 0;

if (strtotime($currentTime) >= $entryTime && strtotime($currentTime) <= $entryClose) {
    $isEntryTime = 1;
}
if (strtotime($currentTime) >= $exitTime && strtotime($currentTime) <= $exitClose) {
    $isExitTime = 1;
}

if (isset($_POST['text'])) {
    $text = $_POST['text'];

    // Find the Attendancecount from the database
    $findquery = "SELECT Attendancecount FROM studentdetails_$orgid WHERE Enrollment = ?";
    $stmt = mysqli_prepare($connection, $findquery);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $text);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $findRow = mysqli_fetch_array($result);

        if ($findRow) {
            $myatd = $findRow['Attendancecount'];

            // Ensure $total is defined and not zero to avoid division by zero errors.
            if ($total != 0) {
                $myAtdPer = (($myatd + 1) / $total) * 100;
            } else {
                // Handle the case where $total is zero (to avoid division by zero).
                $myAtdPer = 0;
            }
        } else {
            $myAtdPer = 0; 
        }

        mysqli_stmt_close($stmt);
    } else {
        die("Error in preparing statement: " . mysqli_error($connection));
    }

    $checkExitQuery = "SELECT ExitTime FROM studentdetails_$orgid WHERE Enrollment = '$text'";
    $resultExit = mysqli_query($connection, $checkExitQuery);
    $rowExit = mysqli_fetch_assoc($resultExit);

    $checkEntryQuery = "SELECT EntryTime FROM studentdetails_$orgid WHERE Enrollment = '$text'";
    $resultEntry = mysqli_query($connection, $checkEntryQuery);
    $rowEntry = mysqli_fetch_assoc($resultEntry);

    if ($isEntryTime) {
        if ($rowEntry['EntryTime'] === NULL) {
            $sqlentry = "UPDATE studentdetails_$orgid SET EntryTime = '$currentTime' WHERE Enrollment = '$text'";
            if ($connection->query($sqlentry) === TRUE) {
                $_SESSION['text'] = "Entry recorded";
            } else {
                $_SESSION['text'] = "Failed: " . $sqlentry . "<br>" . $connection->error;
            }
        } else {
            $_SESSION['text'] = "Entry is already recorded.";
        }
    } elseif ($isExitTime) {
        if ($rowEntry['EntryTime'] !== NULL) {
            if ($rowExit['ExitTime'] === NULL) {
    
                $sqlexit = "UPDATE studentdetails_$orgid SET ExitTime = '$currentTime' WHERE Enrollment = '$text' ";
                if ($connection->query($sqlexit) === TRUE) {
                    $_SESSION['text'] = "Attendance recorded for today! Thank You";
                } else {
                    $_SESSION['text'] = "Failed: " . $sqlexit . "<br>" . $connection->error;
                }

                $sqlupdate = "UPDATE studentdetails_$orgid SET Attendancecount = (Attendancecount + 1), Attendancecountper = ? WHERE Enrollment = ?";
                $stmt = mysqli_prepare($connection, $sqlupdate);

                if ($stmt) {
                    mysqli_stmt_bind_param($stmt, "ds", $myAtdPer, $text);

                    if (mysqli_stmt_execute($stmt)) {
                        $_SESSION['text'] = "Attendance recorded for today! Thank You";
                    } else {
                        $_SESSION['text'] = "Attendance not marked for the day: " . $sqlupdate . "<br>" . mysqli_error($connection);
                    }

                    mysqli_stmt_close($stmt); 
                } else {
                    die("Error in preparing statement: " . mysqli_error($connection));
                }

                $_SESSION['Timein'] = $rowEntry['EntryTime'];

                $updateAttendanceQuery = "UPDATE studentdetails_$orgid SET EntryTime = NULL, ExitTime = NULL WHERE Enrollment = $text";
                if ($connection->query($updateAttendanceQuery) === TRUE) {
                    // speakGreeting();
                    $_SESSION['text'] = "Attendance recorded";
                } else {
                    $_SESSION['text'] = "Failed to update EntryTime and ExitTime";
                }

                $Timein = $_SESSION['Timein'];

                $insertquery = "INSERT INTO `dailyattendance`(`Enrollment`, `Date`, `Timein`, `Timeout`) VALUES ('$text', '$currentDate', '$Timein', '$currentTime')";
                $insertcheck = mysqli_query($connection, $insertquery);
            } else {
                $_SESSION['text'] = "Exit is already recorded.";
            }
        } else {
            $_SESSION['text'] = "Entry time is missing.";
        }
    } else {
        $_SESSION['text'] = "Not a valid Time or user has not taken entry.";
    }
}

header('location: scanqr.php');
$connection->close();
?>
<script>
    // function speakGreeting() {
    // var currentTime = new Date();
    // var currentHour = currentTime.getHours();
    // var greeting = "";

    // if (currentHour >= 0 && currentHour < 12) {
    //     greeting = "Good Morning  ,your attendance has been taken ! Thank you ";
    // } else if (currentHour >= 12 && currentHour < 18) {
    //     greeting = "Good Afternoon  ,your attendance has been taken ! Thank you ";
    // } else {
    //     greeting = "Good Evening  ,your attendance has been taken ! Thank you ";
    // }

    // var utterance = new SpeechSynthesisUtterance(greeting);
    
    // // Select a female voice
    // var voices = window.speechSynthesis.getVoices();
    // var femaleVoice = voices.find(voice => voice.name === 'Google UK English Female');
    // utterance.voice = femaleVoice;

    // window.speechSynthesis.speak(utterance);
// }
</script>