<?php
session_start();
include('connection.php');

$orgid = 202405231637298741;
$totalClassesPerSubject = [
    'SUB001' => 50,
    'SUB002' => 45,
    'SUB003' => 60,
    'SUB004' => 45,
    'SUB005' => 55,
    'SUB006' => 40,
    'SUB007' => 35
    // Add all subjects here with their total number of classes
];

// Fetch total attendance per student per subject
$query = "SELECT Enrollmentno, Subjectcode, COUNT(*) as PresentDays FROM periodwisestudent_$orgid GROUP BY Enrollmentno, Subjectcode";
$result = $connection->query($query);
$attendance = [];

while ($row = $result->fetch_assoc()) {
    $enrollmentNo = $row['Enrollmentno'];
    $subjectCode = $row['Subjectcode'];
    $presentDays = $row['PresentDays'];

    if (!isset($attendance[$enrollmentNo])) {
        $attendance[$enrollmentNo] = [];
    }

    $attendance[$enrollmentNo][$subjectCode] = $presentDays;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Summary</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f5f5f5;
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        .container {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            padding: 30px;
        }
        .table-responsive {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center">Attendance Summary</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Enrollment No</th>
                        <th>Subject Code</th>
                        <th>Total Days Present</th>
                        <th>Total Classes</th>
                        <th>Percentage Present</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($attendance as $enrollmentNo => $subjects): ?>
                        <?php foreach ($subjects as $subjectCode => $presentDays): ?>
                            <?php
                            $totalClasses = isset($totalClassesPerSubject[$subjectCode]) ? $totalClassesPerSubject[$subjectCode] : 0;
                            $percentage = ($totalClasses > 0) ? ($presentDays / $totalClasses) * 100 : 0;
                            ?>
                            <tr>
                                <td><?php echo $enrollmentNo; ?></td>
                                <td><?php echo $subjectCode; ?></td>
                                <td><?php echo $presentDays; ?></td>
                                <td><?php echo $totalClasses; ?></td>
                                <td><?php echo number_format($percentage, 2); ?>%</td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
