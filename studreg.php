<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration Form</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f0f0;
        }

        .container {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        .container h2 {
            text-align: center;
            color: #007BFF;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-weight: bold;
            color: #333;
        }

        input[type="text"], input[type="email"], select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            font-size: 16px;
        }

        select {
            appearance: none;
            background-color: #fff;
            background-image: url("https://cdn.jsdelivr.net/npm/outline-icons@0.28.0/dist/info-circle.svg");
            background-repeat: no-repeat;
            background-position: right center;
            background-size: 20px;
            padding-right: 40px;
        }

        button[type="submit"] {
            background-color: #007BFF;
            color: #fff;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
            width: 100%;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }

        button[type="button"] {
            background-color: #007BFF;
            color: #fff;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
            width: 100%;
        }

        button[type="button"]:hover {
            background-color: #0056b3;
        }

        .input-icon {
            position: relative;
        }

        .input-icon img {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            opacity: 0.5;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Student Registration Form</h2>
        <form method="post" action="studregaction.php" >
            <div class="form-group">
                <label for="studentName">Student Name:</label>
                <input required type="text" id="studentName" name="studentName" class="input-field">
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input required type="email" id="email" name="email" class="input-field">
            </div>

            <div class="form-group">
                <label for="section">Section:</label>
                <input required type="text" id="section" name="section" class="input-field">
            </div>

            <div class="form-group">
                <label for="rollNo">Roll No:</label>
                <input required type="text" id="rollNo" name="rollNo" class="input-field">
            </div>

            <div class="form-group input-icon">
                <label for="enrollmentNo">Enrollment Number:</label>
                <input required type="text" id="enrollmentNo" name="enrollmentNo" class="input-field">
             
            </div>

            <div class="form-group">
                <label for="year">Year:</label>
                <select required id="year" name="year" class="input-field">
                    <option value="1">First Year</option>
                    <option value="2">Second Year</option>
                    <option value="3">Third Year</option>
                    <option value="4">Fourth Year</option>
                </select>
            </div>

            <button name="submit" type="submit">Submit</button>
        </form>
        <br>
        <button onclick="window.location.href='index.php'" name="back" type="button">Back</button>
    </div>
</body>
</html>
