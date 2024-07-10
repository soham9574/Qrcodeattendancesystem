<?php
session_start();
include('connection.php');
$orgid = $_SESSION['adminsuc'];

// Fetch data from the organisationdetails table
$query = "SELECT * FROM organisationdetails WHERE Orgid = '$orgid'";
$result = mysqli_query($connection, $query);

// Assume you want to display data for the first row (you can modify it based on your logic)
if ($row = mysqli_fetch_assoc($result)) {
    $name = $row['Name'];
    $phone = $row['Phone'];
    $email = $row['Email'];
    $orgname = $row['Orgname'];
    $orgid = $row['Orgid'];
    $address = $row['Orgaddress'];
    $entryTime = $row['Entryin'];
    $entryClose = $row['Entryout'];
    $exitTime = $row['Exitin'];
    $exitClose = $row['Exitout'];
    $total = $row['Total'];
} else {
    // Handle case where no data is found
    echo "No data found!";
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    // Retrieve updated values from the form
    $updatedName = $_POST['name'];
    $updatedPhone = $_POST['phone'];
    $updatedEmail = $_POST['email'];
    $updatedOrgname = $_POST['orgname'];
    $updatedAddress = $_POST['address'];
    $updatedTotal = $_POST['total'];
    $updatedEntryIn = $_POST['entryin'];
    $updatedEntryOut = $_POST['entryout'];
    $updatedExitIn = $_POST['exitin'];
    $updatedExitOut = $_POST['exitout'];

    // Update the database with the new values
    $updateQuery = "UPDATE organisationdetails SET 
                    Name = '$updatedName', 
                    Phone = '$updatedPhone', 
                    Email = '$updatedEmail', 
                    Orgname = '$updatedOrgname', 
                    Orgaddress = '$updatedAddress', 
                    Total = '$updatedTotal',
                    Entryin = '$updatedEntryIn',
                    Entryout = '$updatedEntryOut',
                    Exitin = '$updatedExitIn',
                    Exitout = '$updatedExitOut'
                    WHERE Orgid = '$orgid'";
    $updateResult = mysqli_query($connection, $updateQuery);

    if ($updateResult) {
        ?>
        <script>
            alert("Data updated successfully");
        </script>
        <?php
    } else {
        echo "Error updating data: " . mysqli_error($connection);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Organization Details</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow-x:hidden;
            overflow-y:hidden;
        }

        .container {
            max-width: 1000px;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        form {
            display: grid;
            gap: 15px;
            background-color: #fff; /* Added background color */
            padding: 30px; /* Added padding for better spacing */
            border-radius: 8px;
        }

        label {
            font-weight: bold;
        }

        input {
            width: calc(100% - 20px);
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .form-row {
            display: flex;
            gap: 20px;
        }
 

        .form-row label,
        .form-row input {
            width: 100%;
        }

        .form-buttons {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
        }

        .edit-btn, .update-btn {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 4px;
        }

        .edit-btn:hover, .update-btn:hover {
            background-color: #45a049;
        }

        .update-btn {
            display: none;
        }
    </style>
</head>
<body>

<div class="container">
    <form method="post" id="orgForm">
        <div class="form-row">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo $name; ?>" readonly>
        </div>

        <div class="form-row">
            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" value="<?php echo $phone; ?>" readonly>
        </div>

        <div class="form-row">
            <label for="email">Email:</label>
            <input type="text" id="email" name="email" value="<?php echo $email; ?>" readonly>
        </div>

        <div class="form-row">
            <label for="orgname">Organization Name:</label>
            <input type="text" id="orgname" name="orgname" value="<?php echo $orgname; ?>" readonly>
        </div>

        <div class="form-row">
            <label for="address">Organization Address:</label>
            <input type="text" id="address" name="address" value="<?php echo $address; ?>" readonly>
        </div>

        <div class="form-row">
            <label for="total">Total:</label>
            <input type="text" id="total" name="total" value="<?php echo $total; ?>" readonly>
        </div>

        <div class="form-row">
            <label for="entryin">Entry In:</label>
            <input type="text" id="entryin" name="entryin" value="<?php echo $entryTime; ?>" readonly>
        </div>

        <div class="form-row">
            <label for="entryout">Entry Out:</label>
            <input type="text" id="entryout" name="entryout" value="<?php echo $entryClose; ?>" readonly>
        </div>

        <div class="form-row">
            <label for="exitin">Exit In:</label>
            <input type="text" id="exitin" name="exitin" value="<?php echo $exitTime; ?>" readonly>
        </div>

        <div class="form-row">
            <label for="exitout">Exit Out:</label>
            <input type="text" id="exitout" name="exitout" value="<?php echo $exitClose; ?>" readonly>
        </div>
        <div class="form-buttons">
        <button  type="button" class="updatebtn" onclick ="goBack()">Back</button>

            <button type="button" class="edit-btn" onclick="enableEdit()">Edit</button>
            <button type="submit" class="update-btn" name="update">Update</button>
            
        </div>
    </form>
</div>

<script>
    function enableEdit() {
        var form = document.getElementById('orgForm');
        var inputs = form.getElementsByTagName('input');
        var editBtn = document.querySelector('.edit-btn');
        var updateBtn = document.querySelector('.update-btn');

        for (var i = 0; i < inputs.length; i++) {
            inputs[i].readOnly = false;
        }

        editBtn.style.display = 'none';
        updateBtn.style.display = 'inline-block';
    }
    function goBack() {
            window.location.href = 'admindashboard.php';
        }
</script>

</body>
</html>
