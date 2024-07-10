<?php
session_start();
include('connection.php');

$orgid = $_SESSION['adminsuc'];

// if($_SESSION['$adminsuc']==NULL){
//     header("location: adminlogin.php");
// }






?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            margin-top: 20px;
        }

        table {
            width: 100%;
            max-width: 100%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: white;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #333;
            color: white;
        }

        .filter-form {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .filter-option {
            margin: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            background-color: #fff;
            border-radius: 5px;
        }

        select.input-field, input.text-input {
            width: 100%;
            max-width: 300px;
            padding: 10px;
        }

        .filter-buttons {
            display: flex;
            justify-content: center;
        }

        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            margin: 10px;
        }

        button:hover {
            background-color: #45a049;
        }
        .pull-right{
            float: right;
            background-color: black;
        }
        .pull-right:hover{
            float: right;
            background-color: #565151;

        }

        .pull-left{
            float: left;
            background-color: black;
        }
        .pull-left:hover{
           
            background-color: #565151;
;
        }
    </style>
</head>
<body>
    <h2>Student Details</h2>

    <form method="post" class="filter-form" id="filterForm">
        <div class="filter-option">
            <label for="stream">Filter by Stream:</label>
            <select id="stream" name="stream" class="input-field">
            <option value="All">All</option>
                <option value="CSE">CSE</option>
                <option value="CSE AI">CSE AI</option>
                <option value="CSE AI ML">CSE AI ML</option>
                <option value="CSE IOT">CSE IOT</option>
                <option value="CSE IOT CSBT">CSE IOT CSBT</option>
                <option value="CSE CSBT">CSE CSBT</option>
                <option value="IT">IT</option>
                <option value="ECE">ECE</option>
                <option value="EEE">EEE</option>
                <option value="EE">EE</option>
                <option value="ME">ME</option>
                <option value="CIVIL">CIVIL</option>
            </select>
        </div>

        <div class="filter-option">
            <label for="year">Filter by Student Year:</label>
            <select id="year" name="year" class="input-field">
                 <option value="All">All</option>
                <option value="1">First Year</option>
                <option value="2">Second Year</option>
                <option value="3">Third Year</option>
                <option value="4">Fourth Year</option>
            </select>
        </div>

        <div class="filter-option">
            <label for="attendance">Filter by Attendance Percentage:</label>
            <select id="attendance" name="attendance" class="input-field">
            <option value="All">All</option>
                <option value=">=90">>= 90%</option>
                <option value=">=75">>= 75%</option>
                <option value=">=60">>= 60%</option>
                <option value=">=50">>= 50%</option>
                <option value=">=25">>= 25%</option>
                <option value="<=10"><= 10%</option>
            </select>
        </div>

        <div class="filter-option">
            <label for="section">Filter by Section:</label>
            <select id="section" name="section" class="input-field">
            <option value="All">All</option>
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
                <option value="D">D</option>
                <option value="E">E</option>
                <option value="F">F</option>
                <option value="G">G</option>
                <option value="H">H</option>
            </select>
        </div>

        <div class="filter-buttons">
            <button type="submit" name="applyFilter">Apply Filters</button>
            <button onclick="Export()" type="submit" name="convert" >Convert to Excel</button>
            
        </div>
    </form>

    <table>
        <tr>
            <th>Stdname</th>
            <th>Emailid</th>
            <th>Section</th>
            <th>Rollno</th>
            <th>Enrollment</th>
            <th>Stdyear</th>
            <th>Stream</th>
            <th>Attendancecount</th>
            <th>Attendancecountper</th>
        </tr>



    </table>
    <button class="pull-right" onclick="window.location='admindashboard.php';"  type="submit" >Back</button>
    <button class="pull-left" id="copyButton" type="submit" >Copy</button>
    <br>
    <br>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Function to update the table based on filters

            function updateTable() {
                // Get filter values
                var stream = $("#stream").val();
                var year = $("#year").val();
                var attendance = $("#attendance").val();
                var section = $("#section").val();

                // Send AJAX request to update the table

                $.post("update_table.php", {
                    stream: stream,
                    year: year,
                    attendance: attendance,
                    section: section
                }, function(data) {
                    $("table").html(data);
                });
            }

            // Apply filter button click event
            $("#filterForm").on('submit', function(e) {
                e.preventDefault(); // Prevent the form from submitting normally
                updateTable();
            });

            updateTable();
        });
    </script>
<?php
$streamval = $yearval = $attendanceval = $sectionval = "";

if(isset($_POST['convert'])){
    $streamval = $_POST['stream'];
    $yearval = $_POST['year'];
    $attendanceval = $_POST["attendance"];
    $sectionval = $_POST["section"];
}


$_SESSION['streamfilter']= $streamval;
$_SESSION['yearfilter']=$yearval;
$_SESSION['attendancefilter']=$attendanceval;
$_SESSION['sectionfilter']=$sectionval;

?>

     <script>
        function Export() {
            var conf = confirm('Please confirm if you wish to export the record to an Excel file');
             if (conf) {
                window.open("export.php",'_blank');
                }
        }
    </script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>


  
  <script>
    var clipboard = new ClipboardJS('#copyButton', {
        text: function() {
            // Get the HTML content of the table and copy it
            var tableContent = document.querySelector('table').outerHTML;
            return tableContent;
        }
    });

    clipboard.on('success', function(e) {
        e.clearSelection();
        alert('Table copied to clipboard');
    });

    clipboard.on('error', function(e) {
        console.error('Copy failed');
    });
</script>



</script>

</body>
</html>
