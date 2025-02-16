<?php
    include('../db/db_conn.php');
    if (isset($_POST['course_codes'])) {
        $courseCodes = $_POST['course_codes'];
        $courseCodeArray = array_map('trim', explode(',', $courseCodes));
        $validCourseCodes = [];
        foreach ($courseCodeArray as $code) {
            $checkCourseCodeQuery = "SELECT * FROM courses WHERE course_code = ?";
            $stmt = $conn->prepare($checkCourseCodeQuery);
            $stmt->bind_param("s", $code);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result && $result->num_rows > 0) {
                $validCourseCodes[] = $code;
            }
        }
        if (!empty($validCourseCodes)) {
            $validCourseCodesString = implode(',', $validCourseCodes);
            header("Location: ../content/align.php?course_codes=" . urlencode($validCourseCodesString));
            exit();
        } else {
            header("Location: ../index.php?page=download_pdf");
            exit();
        }
    }
?>
