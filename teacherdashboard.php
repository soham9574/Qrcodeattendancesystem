<?php
session_start();

$orgid = $_SESSION['orgid'];
$username = $_SESSION['empsuc'];

$newusername = htmlspecialchars($username);

if ($orgid == NULL || $username == NULL) {
    header("Location: emplogin.php");
    exit();
}

include 'connection.php';

$table_name = "teacher_" . $orgid;
$orgid = $connection->real_escape_string($orgid);
$usernamenew = $connection->real_escape_string($username);
$sql = "SELECT * FROM $table_name WHERE id = '$newusername'";

$result = $connection->query($sql);

if (!$result) {
    echo "SQL Error: " . htmlspecialchars($connection->error) . "<br>";
}

if ($result && $result->num_rows > 0) {
    $teacher = $result->fetch_assoc();
} else {
    $teacher = null;
    echo "No data found for the logged-in user.<br>";
}

if (isset($_POST['qrscan'])) {
    
    $id = $_POST['id'];
    $subjectCode = $_POST['subjectCode'];
    $periodNo = $_POST['periodNo'];
    $stream = $_POST['stream'];
    $year = $_POST['year'];
    $section = $_POST['section'];

    $myQuery = "UPDATE TABLE subjects_$orgid SET Totalclass = Totalclass+1 WHERE Subjectcode = '$subjectCode'";
    $execute = $connection->query($myQuery);


    $_SESSION['id'] = $id;
    $_SESSION['adminsuc'] = $id;

    $_SESSION['subjectcode'] = $subjectCode;
    $_SESSION['periodNo'] = $periodNo;
    $_SESSION['stream'] = $stream;
    $_SESSION['year'] = $year;
    $_SESSION['section'] = $section;

    header('Location: teacherscanqr.php');
    exit();
}

$connection->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .dashboard-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
            box-sizing: border-box;
        }
        .dashboard-container h2 {
            margin-bottom: 20px;
            text-align: center;
        }
        .teacher-details {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .teacher-details div {
            display: flex;
            justify-content: space-between;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        .teacher-details div:last-child {
            border-bottom: none;
        }
        .teacher-details span {
            font-weight: bold;
        }
        .button-8 {
            background-color: #e1ecf4;
            border-radius: 3px;
            border: 1px solid #7aa7c7;
            box-shadow: rgba(255, 255, 255, .7) 0 1px 0 0 inset;
            box-sizing: border-box;
            color: #39739d;
            cursor: pointer;
            display: inline-block;
            font-family: -apple-system,system-ui,"Segoe UI","Liberation Sans",sans-serif;
            font-size: 13px;
            font-weight: 400;
            line-height: 1.15385;
            margin: 0;
            outline: none;
            padding: 8px .8em;
            position: relative;
            text-align: center;
            text-decoration: none;
            user-select: none;
            -webkit-user-select: none;
            touch-action: manipulation;
            vertical-align: baseline;
            white-space: nowrap;
        }
        .button-8:hover,
        .button-8:focus {
            background-color: #b3d3ea;
            color: #2c5777;
        }
        .button-8:focus {
            box-shadow: 0 0 0 4px rgba(0, 149, 255, .15);
        }
        .button-8:active {
            background-color: #a0c7e4;
            box-shadow: none;
            color: #2c5777;
        }
        #popupForm {
            display: none;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1000;
        }
        #overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }
    </style>
</head>
<body>
    <div class="dashboard-container" id="dashboardContainer">
        <h2>Teacher Dashboard</h2>
        <?php if ($teacher): ?>
        <div class="teacher-details">
            <div><span>ID:</span> <?php echo htmlspecialchars($teacher['id']); ?></div>
            <div><span>Name:</span> <?php echo htmlspecialchars($teacher['name']); ?></div>
            <div><span>Department:</span> <?php echo htmlspecialchars($teacher['department']); ?></div>
            <div><span>Qualification:</span> <?php echo htmlspecialchars($teacher['qualification']); ?></div>
            <div><span>Domain Subject:</span> <?php echo htmlspecialchars($teacher['domain_subject']); ?></div>
        </div>
        <?php else: ?>
        <p>No data found for the logged-in user.</p>
        <?php endif; ?>
        
        <button name="scan" class="button-8" role="button" type="button" onclick="openPopup()">Scan Qr</button>
        <button onclick="location.replace('studentbyteacher.php')" class="button-8" role="button" type="button">Check Student Details</button>

    </div>

    <div id="overlay"></div>

    <!-- Popup form -->
    <div id="popupForm">
    <h3>Scan QR</h3>
    <form method="POST">
        <label for="id">ID:</label>
        <input type="text" id="id" name="id" value="<?php echo $newusername; ?>" readonly><br><br>
        <label for="subjectCode">Subject Code:</label>
        <input required type="text" id="subjectCode" name="subjectCode"><br><br>
        <label for="periodNo">Period No:</label>
        <input required type="text" id="periodNo" name="periodNo"><br><br>
        <label for="stream">Stream:</label>
        <select id="stream" name="stream">
            <option value="CSE">CSE</option>
            <option value="IT">IT</option>
            <option value="ECE">ECE</option>
            <option value="ME">ME</option>
            <option value="EE">EE</option>
            <option value="CSE - AIML">CSE - AIML</option>
        </select><br><br>
        <label for="year">Semester:</label>
        <select id="year" name="year">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
        </select><br><br>
        <label for="section">Section:</label>
        <select id="section" name="section">
            <option value="A">A</option>
            <option value="B">B</option>
            <option value="C">C</option>
            <option value="D">D</option>
            <option value="E">E</option>
        </select><br><br>
        <button name="qrscan" class="button-8" type="submit">Scan Now</button>
        <button onClick="closePopup()" class="button-8" type="button">Back</button>
    </form>
</div>

    <script>
        function openPopup() {
            document.getElementById("popupForm").style.display = "block";
            document.getElementById("overlay").style.display = "block";
            document.getElementById("dashboardContainer").style.display = "none";
        }

        function closePopup() {
            document.getElementById("popupForm").style.display = "none";
            document.getElementById("overlay").style.display = "none";
            document.getElementById("dashboardContainer").style.display = "block";
        }
    </script>
</body>
</html>
