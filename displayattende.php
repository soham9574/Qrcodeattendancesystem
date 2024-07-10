<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Records</title>
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
        .filter {
            margin-bottom: 15px;
        }
        .filter label {
            margin-right: 10px;
            font-weight: bold;
        }
        .filter input,
        .filter select {
            margin-right: 20px;
            border-radius: 5px;
            padding: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center">Attendance Records</h2>
        <div class="filter">
            <label for="filterYear">Year:</label>
            <select id="filterYear">
                <option value="">All</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
            </select>
            <label for="filterStream">Stream:</label>
            <select id="filterStream">
                <option value="">All</option>
                <option value="CSE">CSE</option>
                <option value="IT">IT</option>
                <option value="ECE">ECE</option>
                <option value="ME">ME</option>
                <option value="EE">EE</option>
                <option value="CSE - AIML">CSE - AIML</option>
            </select>
            <label for="filterTeacherid">Teacher ID:</label>
            <input type="text" id="filterTeacherid">
            <label for="filterSubjectcode">Subject Code:</label>
            <input type="text" id="filterSubjectcode">
            <label for="filterEnrollment">Enrollment:</label>
            <input type="text" id="filterEnrollment">
            <label for="filterDate">Date:</label>
            <input type="date" id="filterDate">
            <button id="filterButton" class="btn btn-primary">Filter</button>
            <button id="resetButton" class="btn btn-secondary">Reset</button>
            <button onClick="location.replace('admindashboard.php')" id="backButton" class="btn btn-danger">Back</button>

        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Enrollment No</th>
                        <th>Subject Code</th>
                        <th>Teacher ID</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Period No</th>
                        <th>Stream</th>
                        <th>Year</th>
                        <th>Section</th>
                    </tr>
                </thead>
                <tbody id="dataTable">
                    <!-- Data will be injected here by JavaScript -->
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            function fetchData() {
                $.ajax({
                    url: 'fetch_data.php',
                    method: 'GET',
                    success: function(data) {
                        displayData(data);
                    }
                });
            }

            function displayData(data) {
                let tableBody = $('#dataTable');
                tableBody.empty();
                data.forEach(function(row) {
                    let newRow = `<tr>
                        <td>${row.Enrollmentno}</td>
                        <td>${row.Subjectcode}</td>
                        <td>${row.Teacherid}</td>
                        <td>${row.Date}</td>
                        <td>${row.Time}</td>
                        <td>${row.PeriodNo}</td>
                        <td>${row.Stream}</td>
                        <td>${row.Year}</td>
                        <td>${row.Section}</td>
                    </tr>`;
                    tableBody.append(newRow);
                });
            }

            function applyFilter(data) {
                let filterYear = $('#filterYear').val();
                let filterStream = $('#filterStream').val();
                let filterTeacherid = $('#filterTeacherid').val().toLowerCase();
                let filterSubjectcode = $('#filterSubjectcode').val().toLowerCase();
                let filterEnrollment = $('#filterEnrollment').val().toLowerCase();
                let filterDate = $('#filterDate').val();

                let filteredData = data.filter(function(row) {
                    return (filterYear === "" || row.Year === filterYear) &&
                           (filterStream === "" || row.Stream === filterStream) &&
                           (filterTeacherid === "" || row.Teacherid.toLowerCase().includes(filterTeacherid)) &&
                           (filterSubjectcode === "" || row.Subjectcode.toLowerCase().includes(filterSubjectcode)) &&
                           (filterEnrollment === "" || row.Enrollmentno.toLowerCase().includes(filterEnrollment)) &&
                           (filterDate === "" || row.Date === filterDate);
                });

                displayData(filteredData);
            }

            fetchData();

            $('#filterButton').click(function() {
                $.ajax({
                    url: 'fetch_data.php',
                    method: 'GET',
                    success: function(data) {
                        applyFilter(data);
                    }
                });
            });

            $('#resetButton').click(function() {
                $('#filterYear').val('');
                $('#filterStream').val('');
                $('#filterTeacherid').val('');
                $('#filterSubjectcode').val('');
                $('#filterEnrollment').val('');
                $('#filterDate').val('');
                fetchData();
            });
        });
    </script>
</body>
</html>
