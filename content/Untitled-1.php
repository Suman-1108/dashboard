<?php 
    // include './db/dashboard.php';
    ob_start();
    $servername = "localhost";
    $username = "root";        
    $password = "";             
    $dbname = "course_db";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 

    $sql = "SELECT department, COUNT(*) AS student_count FROM department GROUP BY department";
    $result = $conn->query($sql);
    if ($result === false) {
        die("Error executing query: " . $conn->error);
    }
    $departments = [];
    $departmentNames = [];
    $departmentCounts = [];
    $courseCodes = []; // Will hold course codes by department
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $departmentName = $row['department'];
            $studentCount = $row['student_count'];
            // Save department and student count
            $departments[$departmentName] = $studentCount;
            $departmentNames[] = $departmentName;
            $departmentCounts[] = $studentCount;
        }
    } else {
        echo "No data found for departments.";
    }
    $totalStudents = array_sum($departmentCounts);
    
    if (isset($_POST['departmentTitle'])) {
        $departmentTitle = $_POST['departmentTitle'];
        $sql = "SELECT course_code FROM department WHERE department = '$departmentTitle'";
        $result = $conn->query($sql);
        $courseCodes = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $courseCode = $row['course_code'];
                $checkSql = "SELECT * FROM courses WHERE course_code = '$courseCode'";
                $checkResult = $conn->query($checkSql);
                if ($checkResult->num_rows > 0) {
                    while ($courseRow = $checkResult->fetch_assoc()) {
                        $courseCodes[] = $courseRow;
                    }
                }
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Dashboard</title>
        <style>
            .card {
                border: 1px solid #ccc;
                border-radius: 5px;
                padding: 20px;
                margin: 10px;
                text-align: left;
                width: 210px;
                cursor: pointer;
                position: inherit;
                display: inline-block;
            }
            .card h3 {
                margin: 0;
                font-size: 1.5em;
            }
            .card hr {
                margin: 5px 0;
                width: 100%;
            }
            .card p {
                margin: 5px 0 0;
                font-size: 1.2em;
            }
            .statistics {
                margin: 20px 0;
            }
            .statistics h2 {
                font-size: 2em;
                margin-bottom: 10px;
            }
            .statistics p {
                font-size: 1.2em;
            }
            .chart-container {
                width: 80%;
                margin: auto;
            }
        </style>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    </head>
    <body>
        <h2>Welcome to the Dashboard</h2>
        <div class="dashboard-cards">
            <?php foreach ($departments as $department => $count): ?>
                <div class="card" onclick="showtable('<?php echo $department; ?>')">
                    <h3><?php echo $department; ?></h3>
                    <hr>
                    <p><?php echo $count; ?> Course Code</p>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="statistics">
            <h2>Statistics</h2>
            <p>Total Course Code: <?php echo $totalStudents; ?></p>
        </div>
        <div class="chart-container">
            <canvas id="studentChart"></canvas>
        </div>
        <div id="departmentTable" style="display: none;">
            <h3 id="departmentTitle"></h3>
            <table id="courseTable" class="display">
                <thead>
                    <tr>
                        <th>Course Code</th>
                        <th>Course Title</th>
                        <th>Category</th>
                        <th>Year</th>
                        <th>Semester</th>
                        <th>Internal</th>
                        <th>External</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody id="courseTableBody1">
                    <?php if (!empty($courseCodes)): ?>
                        <?php foreach ($courseCodes as $course): ?>
                            <tr>
                                <td><?php echo $course['course_code']; ?></td>
                                <td><?php echo $course['course_title']; ?></td>
                                <td><?php echo $course['category']; ?></td>
                                <td><?php echo $course['year']; ?></td>
                                <td><?php echo $course['semester']; ?></td>
                                <td><?php echo $course['internal']; ?></td>
                                <td><?php echo $course['external']; ?></td>
                                <td><?php echo $course['total']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="8">No courses found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <p id="noDataMessage" style="display: none;">No courses found for this department.</p>
        </div>
        <script>
            $(document).ready(function() {
                $('#courseTable').DataTable({
                    "paging": true,
                    "searching": true,
                    "info": true,
                    "lengthChange": true,
                });
            });
            const ctx = document.getElementById('studentChart').getContext('2d');
            const studentChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode($departmentNames); ?>,
                    datasets: [{
                        label: 'Number of Course Codes',
                        data: <?php echo json_encode($departmentCounts); ?>,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
            let selectedDepartment = '';
            function showtable(department) {
                selectedDepartment = department;
                document.querySelector('.chart-container').style.display = 'none';
                document.getElementById('departmentTable').style.display = 'block';
                document.getElementById('departmentTitle').textContent = `Courses in ${department}`;
                $.ajax({
                    url: './content/dashboard.php',  
                    method: 'POST',
                    data: { departmentTitle: department },
                    success: function(response) {
                        let courseDetails = JSON.parse(response);
                        $('#courseTableBody1').empty();
                        if (courseDetails.length > 0) {
                            courseDetails.forEach(course => {
                                let row = `<tr>
                                    <td>${course.course_code}</td>
                                    <td>${course.course_title}</td>
                                    <td>${course.category}</td>
                                    <td>${course.year}</td>
                                    <td>${course.semester}</td>
                                    <td>${course.internal}</td>
                                    <td>${course.external}</td>
                                    <td>${course.total}</td>
                                </tr>`;
                                $('#courseTableBody1').append(row);
                            });
                        } else {
                            $('#courseTableBody1').append('<tr><td colspan="8">No courses found for this department.</td></tr>');
                        }
                    }
                });
            }
        </script>
    </body>
</html>