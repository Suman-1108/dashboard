<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "course_db";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Fetch department data
$sql = "SELECT department, COUNT(DISTINCT course_code) AS student_count FROM department GROUP BY department";
$result = $conn->query($sql);
if ($result === false) {
    die("Error executing query: " . $conn->error);
}
$departments = [];
$departmentNames = [];
$departmentCounts = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $departments[$row['department']] = $row['student_count'];
        $departmentNames[] = $row['department'];
        $departmentCounts[] = $row['student_count'];
    }
} else {
    echo "No data found for departments.";
}
$totalStudents = array_sum($departmentCounts);
// Fetch course data if a department is selected
$selectedDepartment = $_GET['department'] ?? null;
$courseData = [];
if ($selectedDepartment) {
    $sql = "SELECT courses.* FROM courses INNER JOIN department ON courses.course_code = department.course_code WHERE department.department = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $selectedDepartment);
    $stmt->execute();
    $courseResult = $stmt->get_result();
    while ($row = $courseResult->fetch_assoc()) {
        $courseData[] = $row;
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
            display: inline-block;
        }

        .card h3 {
            margin: 0;
            font-size: 1.5em;
        }

        .card hr {
            margin: 10px 0;
        }

        .card p {
            margin: 5px 0;
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

        #departmentTable {
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table th,
        table td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        table th {
            background-color: #f4f4f4;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <h2>Welcome to the Dashboard</h2>

    <!-- Department Cards -->
    <div class="dashboard-cards">
        <?php foreach ($departments as $department => $count): ?>
            <div class="card" onclick="location.href='?department=<?php echo urlencode($department); ?>'">
                <h3><?php echo htmlspecialchars($department); ?></h3>
                <hr>
                <p><?php echo $count; ?> Course Code</p>
            </div>
        <?php endforeach; ?>
    </div>
    <!-- Statistics -->
    <div class="statistics">
        <h2>Statistics</h2>
        <p>Total Course Code: <?php echo $totalStudents; ?></p>
    </div>
    <!-- Conditional Chart/Table -->
    <?php if (!$selectedDepartment): ?>
        <!-- Chart -->
        <div class="chart-container">
            <canvas id="studentChart"></canvas>
        </div>
    <?php else: ?>
        <!-- Department Table -->
        <div id="departmentTable">
            <h3>Courses in <?php echo htmlspecialchars($selectedDepartment); ?></h3>
            <?php if (!empty($courseData)): ?>
                <table>
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
                    <tbody>
                        <?php foreach ($courseData as $course): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($course['course_code']); ?></td>
                                <td><?php echo htmlspecialchars($course['course_title']); ?></td>
                                <td><?php echo htmlspecialchars($course['category']); ?></td>
                                <td><?php echo htmlspecialchars($course['year']); ?></td>
                                <td><?php echo htmlspecialchars($course['semester']); ?></td>
                                <td><?php echo htmlspecialchars($course['internal']); ?></td>
                                <td><?php echo htmlspecialchars($course['external']); ?></td>
                                <td><?php echo htmlspecialchars($course['total']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <!-- Download PDF Button -->
                    <div style="margin-top: 10px;">
                        <button onclick="sendCourseCodes()"
                            style="padding: 10px 20px; background-color: #007bff; color: #fff; border: none; border-radius: 5px; cursor: pointer;">
                            Download PDF
                        </button>
                    </div>
                </table>
                <!-- Hidden Form -->
                <form id="downloadForm" method="POST" action="index.php?page=download_pdf" style="display: none;">
                    <input type="hidden" name="course_codes" id="courseCodesInput" value="">
                </form>
            <?php else: ?>
                <p>No courses found for this department.</p>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    <!-- Chart Script -->
    <?php if (!$selectedDepartment): ?>
        <script>
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
            function sendCourseCodes() {
                const table = document.querySelector("table tbody");
                if (!table) {
                    alert("No courses available for download.");
                    return;
                }
                const rows = table.querySelectorAll("tr");
                const courseCodes = Array.from(rows).map(row => row.cells[0].textContent.trim());

                if (courseCodes.length === 0) {
                    alert("No course codes found.");
                    return;
                }
                document.getElementById("courseCodesInput").value = JSON.stringify(courseCodes);
                document.getElementById("downloadForm").submit();
            }
        </script>
    <?php endif; ?>
    <script>
        function sendCourseCodes() {
            const table = document.querySelector("table tbody");
            if (!table) {
                alert("No courses available for download.");
                return;
            }
            const rows = table.querySelectorAll("tr");
            const courseCodes = Array.from(rows).map(row => row.cells[0].textContent.trim());

            if (courseCodes.length === 0) {
                alert("No course codes found.");
                return;
            }

            document.getElementById("courseCodesInput").value = JSON.stringify(courseCodes);
            document.getElementById("downloadForm").submit();
        }
    </script>
</body>

</html>