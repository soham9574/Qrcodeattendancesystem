<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Subject Details</title>
    <link rel="stylesheet" href="styles.css">
</head>
<style>
  body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

.form-container {
    background-color: #fff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    width: 300px;
}

h2 {
    text-align: center;
}

label {
    display: block;
    margin-top: 10px;
}

input {
    width: 100%;
    padding: 8px;
    margin-top: 5px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

button {
    width: 100%;
    padding: 10px;
    background-color: #28a745;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

button:hover {
    background-color: #218838;
}

#message {
    text-align: center;
    margin-top: 20px;
}
</style>
<body>
    <div class="form-container">
        <h2>Insert Subject Details</h2>
        <form id="subjectForm" method="post" action="addsubjectsaction.php">
            <label for="semester">Semester:</label>
            <input type="text" id="semester" name="semester" required>

            <label for="stream">Stream:</label>
            <input type="text" id="stream" name="stream" required>

            <label for="subjectcode">Subject Code:</label>
            <input type="text" id="subjectcode" name="subjectcode" required>

            <label for="subjectname">Subject Name:</label>
            <input type="text" id="subjectname" name="subjectname" required>

            <button name="addsub" type="submit">Submit</button>
        </form>
        <p id="message"><?php echo isset($_GET['message']) ? htmlspecialchars($_GET['message']) : ''; ?></p>
    </div>
</body>
</html>
