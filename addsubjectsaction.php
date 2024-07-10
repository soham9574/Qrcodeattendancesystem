<?php
session_start();
include 'connection.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_POST['addsub'])) {
    $semester = $_POST['semester'];
    $stream = $_POST['stream'];
    $subjectcode = $_POST['subjectcode'];
    $subjectname = $_POST['subjectname'];

    // Prepare an SQL statement for safe insertion
    $stmt = $connection->prepare("INSERT INTO subjects_202405231637298741 (Semester, Stream, Subjectcode, Subjectname) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $semester, $stream, $subjectcode, $subjectname);

    if ($stmt->execute() === TRUE) {
        $message = "New record created successfully";
    } else {
        $message = "Error: " . $stmt->error;
    }

    $stmt->close();
    $connection->close();

    header("Location: addsubjects.php?message=" . urlencode($message));
    exit();
} else {
    header("Location: addsubjects.php?message=" . urlencode("Invalid request."));
    exit();
}
?>
