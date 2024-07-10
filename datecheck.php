<?php
session_start();
include('connection.php');
$orgid = $_SESSION['adminsuc'] ;

$enrollment = isset($_GET['enrollment']) ? $_GET['enrollment'] : '';
$date = isset($_GET['date']) ? $_GET['date'] : '';

$query = "SELECT * FROM fetchtable_$orgid WHERE 1";

if (!empty($enrollment)) {
    $query .= " AND Enrollment = '$enrollment'";
}

if (!empty($date)) {
    $query .= " AND Date = '$date'";
}

$result = $connection->query($query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <style>
body {
    background-color: #f4f4f4;
    font-family: Arial, sans-serif;
}

.filter-form {
    background-color: #fff;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.data-table {
    width: 100%;
    max-width: 100%;
    margin: 20px auto;
    border-collapse: collapse;
    background-color: white;
}

.data-table th {
    background-color: #333;
    color: white;
}

.data-table th, .data-table td {
    border: 1px solid #ccc;
    padding: 10px;
}
</style>
</head>
<body>
    <h2>View Daily Attendance</h2>

    <form action="" method="get" class="filter-form">
        <input type="text" name="enrollment" placeholder="Search by Enrollment" value="<?php echo $enrollment; ?>">
        <input type="date" name="date" value="<?php echo $date; ?>">
        <button type="submit">Apply Filters</button>
    </form>

    <table class="data-table">
        <tr>
            <th>Enrollment</th>
            <th>Date</th>
            <th>Timein</th>
            <th>Timeout</th>
        </tr>
        <?php
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["Enrollment"] . "</td>";
            echo "<td>" . $row["Date"] . "</td>";
            echo "<td>" . $row["Timein"] . "</td>";
            echo "<td>" . $row["Timeout"] . "</td>";
            echo "</tr>";
        }
        ?>
    </table>


</body>
</html>
