<?php
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
                $courseCode = $row['course_code'];  // Corrected line: Store the course_code in $courseCode
    
                $checkSql = "SELECT * FROM courses WHERE course_code = '$courseCode'";
                $checkResult = $conn->query($checkSql);
                if ($checkResult->num_rows > 0) {
                    while ($courseRow = $checkResult->fetch_assoc()) { // Corrected line: fetch from $checkResult
                        $courseCodes[] = $courseRow['course_code'];  // Corrected line: Use $courseRow
                    }
                }
            }
        }
    }
?>