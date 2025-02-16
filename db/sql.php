<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['save'])) {
            $course_code = $_POST['course_code'];
            $course_title = $_POST['course_title'];
            $category = $_POST['category'];
            $l = $_POST['l'];
            $t = $_POST['t'];
            $p = $_POST['p'];
            $credit = $_POST['credit'];
            $year = $_POST['year'];
            $semester = $_POST['semester'];
            $internal = $_POST['internal'];
            $external = $_POST['external'];
            $total = $_POST['total'];
            $sql = "INSERT INTO courses (course_code, course_title, category, l, t, p, credit, year, semester, internal, external, total) VALUES ('$course_code', '$course_title', '$category', '$l', '$t', '$p', '$credit', '$year', '$semester', '$internal', '$external', '$total')";
            if ($conn->query($sql) === FALSE) {
                $messageClass = "error";
                $message = "Error: " . $conn->error;
            } else {
                $messageClass = "success";
                $message = "Courses added successfully!";
            }
            echo "<div class='$messageClass' id='message'>$message <span class='close-btn' onclick='closeMessage()'>&times;</span><div class='progress-bar' id='progress-bar'></div></div>";
        }
    }
    if (isset($_POST['update'])) {
        $id = $_POST['id'];
        $course_title = $_POST['course_title'];
        $category = $_POST['category'];
        $l = $_POST['l'];
        $t = $_POST['t'];
        $p = $_POST['p'];
        $credit = $_POST['credit'];
        $year = $_POST['year'];
        $semester = $_POST['semester'];
        $internal = $_POST['internal'];
        $external = $_POST['external'];
        $total = $_POST['total'];
        $sql = "UPDATE courses SET course_title='$course_title', category='$category', l='$l', t='$t', p='$p', credit='$credit', year='$year', semester='$semester', internal='$internal', external='$external', total='$total' WHERE id='$id'";
        if ($conn->query($sql) === TRUE) {
            $messageClass = "success";
            $message = "Courses updated successfully!";
        } else {
            $messageClass="error"; 
            $message="Error: " . $sql . "<br>" . $conn->error;
        }
        echo "<div class='$messageClass' id='message'>$message <span class='close-btn' onclick='closeMessage()'>&times;</span><div class='progress-bar' id='progress-bar'></div></div>";
    }
    if (isset($_POST['delete_courses'])) {
        $id = intval($_POST['id']); 
        $course_code = $_POST['course_code'];
        $sql = "DELETE FROM courses WHERE id = $id";
        if ($conn->query($sql) === TRUE) {
            $sql = "DELETE FROM preamble WHERE course_code = '$course_code'";
            if ($conn->query($sql) === TRUE) {
                $sql = "DELETE FROM pre_requisite WHERE course_code = '$course_code'";
                if ($conn->query($sql) === TRUE) {
                    $sql = "DELETE FROM course_outcomes WHERE course_code = '$course_code'";
                    if ($conn->query($sql) === TRUE) {
                        $sql = "DELETE FROM course_outcome WHERE course_code = '$course_code'";
                        if ($conn->query($sql) === TRUE) {
                            $sql = "DELETE FROM mapping_pos WHERE course_code = '$course_code'";
                            if ($conn->query($sql) === TRUE) {
                                $sql = "DELETE FROM mapping_psos WHERE course_code = '$course_code'";
                                if ($conn->query($sql) === TRUE) {
                                    $sql = "DELETE FROM content WHERE course_code = '$course_code'";
                                    if ($conn->query($sql) === TRUE) {
                                        $sql = "DELETE FROM text_book WHERE course_code = '$course_code'";
                                        if ($conn->query($sql) === TRUE) {
                                            $sql = "DELETE FROM reference_book WHERE course_code = '$course_code'";
                                            if ($conn->query($sql) === TRUE) {
                                                $sql = "DELETE FROM web_resources WHERE course_code = '$course_code'";
                                                if ($conn->query($sql) === TRUE) {
                                                    $sql = "DELETE FROM course_designer WHERE course_code = '$course_code'";
                                                    if ($conn->query($sql) === TRUE) {
                                                        $sql = "DELETE FROM department WHERE course_code = '$course_code'";
                                                        if ($conn->query($sql) === TRUE) {
                                                            $sql = "DELETE FROM chapter WHERE course_code = '$course_code'";
                                                            if ($conn->query($sql) === TRUE) {
                                                                $sql = "DELETE FROM bloomy WHERE course_code = '$course_code'";    
                                                                if ($conn->query($sql) === TRUE) {
                                                                    $messageClass = "success";
                                                                    $message="Courses deleted successfully!";
                                                                    } else {
                                                                        $messageClass = "error";
                                                                        $message="Error deleting record: " . $conn->error;
                                                                    }
                                                                } else {
                                                                    $messageClass = "error";
                                                                    $message="Error deleting record: " . $conn->error;
                                                              }
                                                        } else {
                                                            $messageClass = "error";
                                                            $message="Error deleting record: " . $conn->error;
                                                      }
                                                    } else {
                                                        $messageClass = "error";
                                                        $message="Error deleting record: " . $conn->error;
                                                    }
                                                } else {
                                                    $messageClass = "error";
                                                    $message="Error deleting record: " . $conn->error;
                                                }
                                            } else {
                                                $messageClass = "error";
                                                $message="Error deleting record: " . $conn->error;
                                            }
                                        } else {
                                            $messageClass = "error";
                                            $message="Error deleting record: " . $conn->error;
                                        }
                                    } else {
                                        $messageClass = "error";
                                        $message="Error deleting record: " . $conn->error;
                                    }
                                } else {
                                    $messageClass = "error";
                                    $message="Error deleting record: " . $conn->error;
                                }
                            } else {
                                $messageClass = "error";
                                $message="Error deleting record: " . $conn->error;
                            }
                        } else {
                            $messageClass = "error";
                            $message="Error deleting record: " . $conn->error;
                        }
                    } else {
                        $messageClass = "error";
                        $message="Error deleting record: " . $conn->error;
                    }
                } else {
                    $messageClass = "error";
                    $message="Error deleting record: " . $conn->error;
                }
            } else {
                $messageClass = "error";
                $message="Error deleting record: " . $conn->error;
            }
        } else {
            $messageClass = "error";
            $message="Error deleting record: " . $conn->error;
        }
        echo "<div class='$messageClass' id='message'>$message <span class='close-btn' onclick='closeMessage()'>&times;</span><div class='progress-bar' id='progress-bar'></div></div>";
    }
    // preamble
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['save_preamble'])) {
            $course_code = $_POST['course_code'];
            $preamble = $_POST['preamble'];
            $checkCourseCodeQuery = "SELECT * FROM courses WHERE course_code = '$course_code'";
            $result = $conn->query($checkCourseCodeQuery);
            if ($result && $result->num_rows > 0) {
                $checkDuplicateQuery = "SELECT * FROM preamble WHERE course_code = '$course_code'";
                $duplicateResult = $conn->query($checkDuplicateQuery);
                if ($duplicateResult && $duplicateResult->num_rows > 0) {
                    $messageClass = "error";
                    $message = "Error: The course code '$course_code' already exists in the preamble table.";
                } else {
                    $insertPreambleQuery = "INSERT INTO preamble (course_code, preamble) VALUES ('$course_code', '$preamble')";
                    if ($conn->query($insertPreambleQuery) === TRUE) {
                        $messageClass = "success";
                        $message = "Preamble added successfully!";
                    } else {
                        $messageClass = "error";
                        $message = "Error: Could not insert preamble. " . $conn->error;
                    }
                }
            } else {
                $messageClass = "error";
                $message = "Error: Course Code '$course_code' does not match any existing records in the courses table.";
            }
            echo "<div class='$messageClass' id='message'>$message <span class='close-btn' onclick='closeMessage()'>&times;</span><div class='progress-bar' id='progress-bar'></div></div>";
        }
    }
    if (isset($_POST['update_preamble'])) {
        $id = $_POST['id'];
        $preamble = $_POST['preamble'];
        $sql = "UPDATE preamble SET preamble='$preamble' WHERE id='$id'";
        if ($conn->query(query: $sql) === TRUE) {
            $messageClass = "success";
            $message = "Preamble updated successfully!";  
        } else {
            $messageClass = "error";
            $message= "Error: " . $sql . "<br>" . $conn->error;
        }
        echo "<div class='$messageClass' id='message'>$message <span class='close-btn' onclick='closeMessage()'>&times;</span><div class='progress-bar' id='progress-bar'></div></div>";
    }
    if (isset($_POST['delete_preamble'])) {
        $id = intval($_POST['id']); 
        $sql = "DELETE FROM preamble WHERE id = $id";
        if ($conn->query($sql)) {
            $messageClass = "success";
            $message="preamble deleted successfully!";
        } else {
            $messageClass = "error";
            $message="Error deleting record: ";
        }
        echo "<div class='$messageClass' id='message'>$message <span class='close-btn' onclick='closeMessage()'>&times;</span><div class='progress-bar' id='progress-bar'></div></div>";
    }
    // pre-requisite
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['save_prerequisite'])) {
            $course_code = $_POST['course_code'];
            $pre_requisite = $_POST['pre_requisite'];
            $checkCourseCodeQuery = "SELECT * FROM courses WHERE course_code = '$course_code'";
            $result = $conn->query($checkCourseCodeQuery);
            if ($result && $result->num_rows > 0) {
                $checkDuplicateQuery = "SELECT * FROM pre_requisite WHERE course_code = '$course_code'";
                $duplicateResult = $conn->query($checkDuplicateQuery);
                if ($duplicateResult && $duplicateResult->num_rows > 0) {
                    $messageClass = "error";
                    $message = "Error: Course Code '$course_code' already exists in the pre_requisite table.";
                } else {
                    $insertPreRequisiteQuery = "INSERT INTO pre_requisite (course_code, pre_requisite) VALUES ('$course_code', '$pre_requisite')";
                    if ($conn->query($insertPreRequisiteQuery) === TRUE) {
                        $messageClass = "success";
                        $message = "Pre-requisite added successfully!";
                    } else {
                        $messageClass = "error";
                        $message = "Error: Could not insert pre-requisite. " . $conn->error;
                    }
                }
            } else {
                $messageClass = "error";
                $message = "Error: Course Code '$course_code' does not match any existing records in the courses table.";
            }
            echo "<div class='$messageClass' id='message'>$message <span class='close-btn' onclick='closeMessage()'>&times;</span><div class='progress-bar' id='progress-bar'></div></div>";
        }
    }    
    if (isset($_POST['update_pre_requisite'])) {
        $id = $_POST['id'];
        $pre_requisite = $_POST['pre_requisite'];
        $sql = "UPDATE pre_requisite SET pre_requisite='$pre_requisite' WHERE id='$id'";
        if ($conn->query($sql) === TRUE) {
            $messageClass = "success";
            $message = "Pre-requisite updated successfully!";
        } else {
            $messageClass = "error";
            $message ="Error: " . $sql . "<br>" . $conn->error;
        }
        echo "<div class='$messageClass' id='message'>$message <span class='close-btn' onclick='closeMessage()'>&times;</span><div class='progress-bar' id='progress-bar'></div></div>";    
    }
    if (isset($_POST['delete_pre_requisite'])) {
        $id = intval($_POST['id']); 
        $sql = "DELETE FROM pre_requisite WHERE id = $id";
        if ($conn->query($sql)) {
            $messageClass = "success";
            $message="Pre-requisite deleted successfully!";
        } else {
            $messageClass = "error";
            $message="Error deleting record:";
        }
        echo "<div class='$messageClass' id='message'>$message <span class='close-btn' onclick='closeMessage()'>&times;</span><div class='progress-bar' id='progress-bar'></div></div>";
    }
    // Course Outcomes
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['save_course_outcomes'])) {
            $course_code = $_POST['course_code'];
            $course_outcomes = $_POST['course_outcomes'];
            $checkCourseCodeQuery = "SELECT * FROM courses WHERE course_code = '$course_code'";
            $result = $conn->query($checkCourseCodeQuery);
            if ($result && $result->num_rows > 0) {
                $checkDuplicateQuery = "SELECT * FROM course_outcomes WHERE course_code = '$course_code'";
                $duplicateResult = $conn->query($checkDuplicateQuery);
                if ($duplicateResult && $duplicateResult->num_rows > 0) {
                    $messageClass = "error";
                    $message = "Error: Course Code '$course_code' already has course outcomes.";
                } else {
                    $insertQuery = "INSERT INTO course_outcomes (course_code, course_outcomes) VALUES ('$course_code', '$course_outcomes')";
                    if ($conn->query($insertQuery) === TRUE) {
                        $messageClass = "success";
                        $message = "Course outcomes added successfully!";
                    } else {
                        $messageClass = "error";
                        $message = "Error: Could not insert course outcomes. " . $conn->error;
                    }
                }
            } else {
                $messageClass = "error";
                $message = "Error: Course Code '$course_code' does not exist in the 'courses' table.";
            }
            echo "<div class='$messageClass' id='message'>$message <span class='close-btn' onclick='closeMessage()'>&times;</span><div class='progress-bar' id='progress-bar'></div></div>";
        }
    }
    if (isset($_POST['update_course_outcomes'])) {
        $id = isset($_POST['id']) ? $_POST['id'] : '';
        $course_outcomes = isset($_POST['course_outcomes']) ? $_POST['course_outcomes'] : '';
        if ($id && $course_outcomes) {
            $sql = "UPDATE course_outcomes SET course_outcomes='$course_outcomes' WHERE id='$id'";
            if ($conn->query($sql) === TRUE) {
                $messageClass = "success";
                $message = "Course outcomes updated successfully!";
            } else {
                $messageClass = "error";
                $message="Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            $messageClass = "error";
            $message="Error: Missing required data.";
        }
        echo "<div class='$messageClass' id='message'>$message <span class='close-btn' onclick='closeMessage()'>&times;</span><div class='progress-bar' id='progress-bar'></div></div>";
    }
    if (isset($_POST['delete_course_outcomes'])) {
        $id = intval($_POST['id']); 
        $sql = "DELETE FROM course_outcomes WHERE id = $id";
        if ($conn->query($sql)) {
            $messageClass = "success";
            $message = "Course Outcomes deleted successfully!";
        } else {
            $messageClass = "error";    
            $message="Error deleting record: " . $conn->error;
        }
        echo "<div class='$messageClass' id='message'>$message <span class='close-btn' onclick='closeMessage()'>&times;</span><div class='progress-bar' id='progress-bar'></div></div>";
    }
    // Course Outcome Add Row
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['save_course_rows'])) {
            $course_code = $_POST['course_code'];
            $course_outcome = $_POST['course_outcome'];
            $expected_proficiency = $_POST['expected_proficiency'];
            $expected_attainment = $_POST['expected_attainment'];
            $checkCourseCodeQuery = "SELECT * FROM courses WHERE course_code = '$course_code'";
            $result = $conn->query($checkCourseCodeQuery);
            if ($result && $result->num_rows > 0) {
                $insertPreRequisiteQuery = "INSERT INTO course_outcome (course_code, course_outcome, expected_proficiency, expected_attainment) VALUES ('$course_code', '$course_outcome','$expected_proficiency','$expected_attainment')";
                if ($conn->query($insertPreRequisiteQuery) === TRUE) {
                    $messageClass = "success";
                    $message = "Course Outcome row added successfully!";
                } else {
                    $messageClass = "error";
                    $message = "Error: Could not insert course_outcome row. " . $conn->error;
                }
            } elseif($result) {
                $messageClass = "error";
                $message = "Error: Course Code '$course_code' did not match any existing records.";
            } else {
                $messageClass = "error";
                $message = "Error: Course Code '$course_code' already this courese code is present";
            }
            echo "<div class='$messageClass' id='message'>$message <span class='close-btn' onclick='closeMessage()'>&times;</span><div class='progress-bar' id='progress-bar'></div></div>";
        }
    }
    if (isset($_POST['update_row'])) {
        $id = $_POST['id'];
        $course_outcome = $_POST['course_outcome'];
        $expected_proficiency = $_POST['expected_proficiency'];
        $expected_attainment = $_POST['expected_attainment'];
        $sql = "UPDATE course_outcome SET course_outcome='$course_outcome', expected_proficiency='$expected_proficiency', expected_attainment='$expected_attainment' WHERE id='$id'";
        if ($conn->query($sql) === TRUE) {
            $messageClass = "success";
            $message = "Course Outcome row updated successfully!";
        } else {
            $messageClass = "error";
            $message ="Error: " . $sql . "<br>" . $conn->error;
        }
        echo "<div class='$messageClass' id='message'>$message <span class='close-btn' onclick='closeMessage()'>&times;</span><div class='progress-bar' id='progress-bar'></div></div>";
    }
    if (isset($_POST['delete_row'])) {
        $id = intval($_POST['id']); 
        $sql = "DELETE FROM course_outcome WHERE id = $id";
        if ($conn->query($sql)) {
            $messageClass = "success";
            $message="Course Outcome row deleted successfully!!!";
        } else {
            $messageClass = "error";
            $message="Error deleting record: " . $conn->error;
        }
        echo "<div class='$messageClass' id='message'>$message <span class='close-btn' onclick='closeMessage()'>&times;</span><div class='progress-bar' id='progress-bar'></div></div>";
    }
    // Mapping pos
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['save_mapping_cos'])) {
            $course_code = $_POST['course_code'];
            $po1 = $_POST['po1'];
            $po2 = $_POST['po2'];
            $po3 = $_POST['po3'];
            $po4 = $_POST['po4'];
            $po5 = $_POST['po5'];
            $po6 = $_POST['po6'];
            $po7 = $_POST['po7'];
            $checkCourseCodeQuery = "SELECT * FROM courses WHERE course_code = '$course_code'";
            $result = $conn->query($checkCourseCodeQuery);
            if ($result && $result->num_rows > 0) {
                $insertPreRequisiteQuery = "INSERT INTO mapping_pos (course_code, po1, po2, po3, po4, po5, po6, po7) VALUES ('$course_code', '$po1', '$po2', '$po3', '$po4', '$po5', '$po6', '$po7')";
                if ($conn->query($insertPreRequisiteQuery) === TRUE) {
                    $messageClass = "success";
                    $message = "Mapping pos added successfully!";
                } else {
                    $messageClass = "error";
                    $message = "Error: Could not insert Mapping pos row. " . $conn->error;
                }
            } elseif($result) {
                $messageClass = "error";
                $message = "Error: Course Code '$course_code' did not match any existing records.";
            } else {
                $messageClass = "error";
                $message = "Error: Course Code '$course_code' already this courese code is present";
            }
            echo "<div class='$messageClass' id='message'>$message <span class='close-btn' onclick='closeMessage()'>&times;</span><div class='progress-bar' id='progress-bar'></div></div>";
        }
    }
    if (isset($_POST['update_mapping_cos'])) {
        $id = $_POST['id'];
        $po1 = $_POST['po1'];
        $po2 = $_POST['po2'];
        $po3 = $_POST['po3'];
        $po4 = $_POST['po4'];
        $po5 = $_POST['po5'];
        $po6 = $_POST['po6'];
        $po7 = $_POST['po7'];
        $sql = "UPDATE mapping_pos SET po1='$po1', po2='$po2', po3='$po3', po4='$po4', po5='$po5', po6='$po6', po7='$po7' WHERE id='$id'";
        if ($conn->query($sql) === TRUE) {
            $messageClass = "success";
            $message = "Mapping pos updated successfully!";
        } else {
            $messageClass = "error";
            $message ="Error: " . $sql . "<br>" . $conn->error;
        }

        echo "<div class='$messageClass' id='message'>$message <span class='close-btn' onclick='closeMessage()'>&times;</span><div class='progress-bar' id='progress-bar'></div></div>";
    }
    if (isset($_POST['delete_mapping_pos'])) {
        $id = intval($_POST['id']); 
        $sql = "DELETE FROM mapping_pos WHERE id = $id";
        if ($conn->query($sql)) {
            $messageClass = "success";
            $message="Mapping pos deleted successfully!";
        } else {
            $messageClass = "error";
            $message="Error deleting record: " . $conn->error;
        }
        echo "<div class='$messageClass' id='message'>$message <span class='close-btn' onclick='closeMessage()'>&times;</span><div class='progress-bar' id='progress-bar'></div></div>";
    }
    // Mapping psos
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['save_mapping_psos'])) {
            $course_code = $_POST['course_code'];
            $po1 = $_POST['po1'];
            $po2 = $_POST['po2'];
            $po3 = $_POST['po3'];
            $po4 = $_POST['po4'];
            $po5 = $_POST['po5'];
            $checkCourseCodeQuery = "SELECT * FROM courses WHERE course_code = '$course_code'";
            $result = $conn->query($checkCourseCodeQuery);
            if ($result && $result->num_rows > 0) {
                $insertPreRequisiteQuery = "INSERT INTO mapping_psos (course_code, po1, po2, po3, po4, po5) VALUES ('$course_code', '$po1', '$po2', '$po3', '$po4', '$po5')";
                if ($conn->query($insertPreRequisiteQuery) === TRUE) {
                    $messageClass = "success";
                    $message = "course_outcome row added successfully!";
                } else {
                    $messageClass = "error";
                    $message = "Error: Could not insert course_outcome row. " . $conn->error;
                }
            } elseif($result) {
                $messageClass = "error";
                $message = "Error: Course Code '$course_code' did not match any existing records.";
            }

            echo "<div class='$messageClass' id='message'>$message <span class='close-btn' onclick='closeMessage()'>&times;</span><div class='progress-bar' id='progress-bar'></div></div>";
        }
    }
    if (isset($_POST['update_mapping_psos'])) {
        $id = $_POST['id'];
        $po1 = $_POST['po1'];
        $po2 = $_POST['po2'];
        $po3 = $_POST['po3'];
        $po4 = $_POST['po4'];
        $po5 = $_POST['po5'];
        $sql = "UPDATE mapping_psos SET po1='$po1', po2='$po2', po3='$po3', po4='$po4', po5='$po5' WHERE id='$id'";
        if ($conn->query($sql) === TRUE) {
            $messageClass = "success";
            $message = "Mapping Psos updated successfully!";
        } else {
            $messageClass = "error";
            $message ="Error: " . $sql . "<br>" . $conn->error;
        }
        echo "<div class='$messageClass' id='message'>$message <span class='close-btn' onclick='closeMessage()'>&times;</span><div class='progress-bar' id='progress-bar'></div></div>";
    }
    if (isset($_POST['delete_mapping_psos'])) {
        $id = intval($_POST['id']); 
        $sql = "DELETE FROM mapping_psos WHERE id = $id";
        if ($conn->query($sql)) {
            $messageClass = "success";
            $message="Mapping Psos deleted successfully!";
        } else {
            $messageClass = "error";
            $message="Error deleting record: " . $conn->error;
        }
        echo "<div class='$messageClass' id='message'>$message <span class='close-btn' onclick='closeMessage()'>&times;</span><div class='progress-bar' id='progress-bar'></div></div>";
    }
    // content
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['save_content'])) {
            $course_code = $_POST['course_code'];
            $unit = $_POST['unit'];
            $content = $_POST['content'];
            $hour = $_POST['hour'];
            $checkCourseCodeQuery = "SELECT * FROM courses WHERE course_code = '$course_code'";
            $result = $conn->query($checkCourseCodeQuery);
            if ($result && $result->num_rows > 0) {
                $insertContentQuery = "INSERT INTO content (course_code, unit, hour, content) VALUES ('$course_code', '$unit', '$hour', '$content')";
                if ($conn->query($insertContentQuery) === TRUE) {
                    $messageClass = "success";
                    $message = "Content added successfully!";
                } else {
                    $messageClass = "error";
                    $message = "Error: Could not insert content. " . $conn->error;
                }
            }
            echo "<div class='$messageClass' id='message'>$message <span class='close-btn' onclick='closeMessage()'>&times;</span><div class='progress-bar' id='progress-bar'></div></div>";
        }
    }
    if (isset($_POST['update_content'])) {
        $id = $_POST['id'];
        $unit = $_POST['unit'];
        $content = $_POST['content'];
        $hour = $_POST['hour'];
        $sql = "UPDATE content SET unit='$unit', content='$content', hour='$hour' WHERE id='$id'";
        if ($conn->query($sql) === TRUE) {
            $messageClass = "success";
            $message = "Content updated successfully!";
        } else {
            $messageClass = "error";
            $message ="Error: " . $sql . "<br>" . $conn->error;
        }
        echo "<div class='$messageClass' id='message'>$message <span class='close-btn' onclick='closeMessage()'>&times;</span><div class='progress-bar' id='progress-bar'></div></div>";
    }
    if (isset($_POST['delete_content'])) {
        $id = intval($_POST['id']); 
        $sql = "DELETE FROM content WHERE id = $id";
        if ($conn->query($sql)) {
            $messageClass = "success";
            $message="Content deleted successfully!";
        } else {
            $messageClass = "error";
            $message="Error deleting record: " . $conn->error;
        }
        echo "<div class='$messageClass' id='message'>$message <span class='close-btn' onclick='closeMessage()'>&times;</span><div class='progress-bar' id='progress-bar'></div></div>";
    }
    // text book
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['save_text_book'])) {
            $course_code = $_POST['course_code'];
            $text_book = $_POST['text_book'];
            $checkCourseCodeQuery = "SELECT * FROM courses WHERE course_code = '$course_code'";
            $result = $conn->query($checkCourseCodeQuery);
            if ($result && $result->num_rows > 0) {
                $insertTextBookQuery = "INSERT INTO text_book (course_code, text_book) VALUES ('$course_code', '$text_book')";
                if ($conn->query($insertTextBookQuery) === TRUE) {
                    $messageClass = "success";
                    $message = "Test Book added successfully!";
                } else {
                    $messageClass = "error";
                    $message = "Error: Could not insert content. " . $conn->error;
                }
            } 
            echo "<div class='$messageClass' id='message'>$message <span class='close-btn' onclick='closeMessage()'>&times;</span><div class='progress-bar' id='progress-bar'></div></div>";
        }
    }
    if (isset($_POST['update_text_book'])) {
        $id = $_POST['id'];
        $text_book = $_POST['text_book'];
        $sql = "UPDATE text_book SET text_book='$text_book' WHERE id='$id'";
        if ($conn->query($sql) === TRUE) {
            $messageClass = "success";
            $message = "Test Book updated successfully!";
        } else {
            $messageClass = "error";
            $message ="Error: " . $sql . "<br>" . $conn->error;
        }
        echo "<div class='$messageClass' id='message'>$message <span class='close-btn' onclick='closeMessage()'>&times;</span><div class='progress-bar' id='progress-bar'></div></div>";
    }
    if (isset($_POST['delete_text_book'])) {
        $id = intval($_POST['id']); 
        $sql = "DELETE FROM text_book WHERE id = $id";
        if ($conn->query($sql)) {
            $messageClass = "success";
            $message="Test Book deleted successfully!";
        } else {
            $messageClass = "error";
            $message="Error deleting record: " . $conn->error;

        }
        echo "<div class='$messageClass' id='message'>$message <span class='close-btn' onclick='closeMessage()'>&times;</span><div class='progress-bar' id='progress-bar'></div></div>";
    }
    // Reference Books
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['save_reference_book'])) {
            $course_code = $_POST['course_code'];
            $reference_book = $_POST['reference_book'];
            $checkCourseCodeQuery = "SELECT * FROM courses WHERE course_code = '$course_code'";
            $result = $conn->query($checkCourseCodeQuery);
            if ($result && $result->num_rows > 0) {
                $insertReferenceBookQuery = "INSERT INTO reference_book (course_code, reference_book) VALUES ('$course_code', '$reference_book')";
                if ($conn->query($insertReferenceBookQuery) === TRUE) {
                    $messageClass = "success";
                    $message = "Reference Book added successfully!";
                } else {
                    $messageClass = "error";
                    $message = "Error: Could not insert content. " . $conn->error;
                }
            } 
            echo "<div class='$messageClass' id='message'>$message <span class='close-btn' onclick='closeMessage()'>&times;</span><div class='progress-bar' id='progress-bar'></div></div>";
        }
    }
    if (isset($_POST['update_reference_book'])) {
        $id = $_POST['id'];
        $reference_book = $_POST['reference_book'];
        $sql = "UPDATE reference_book SET reference_book='$reference_book' WHERE id='$id'";
        if ($conn->query($sql) === TRUE) {
            $messageClass = "success";
            $message = "Reference Book updated successfully!";
        } else {
            $messageClass = "error";
            $message ="Error: " . $sql . "<br>" . $conn->error;
        }
        echo "<div class='$messageClass' id='message'>$message <span class='close-btn' onclick='closeMessage()'>&times;</span><div class='progress-bar' id='progress-bar'></div></div>";
        }
    if (isset($_POST['delete_reference_book'])) {
        $id = intval($_POST['id']); 
        $sql = "DELETE FROM reference_book WHERE id = $id";
        if ($conn->query($sql)) {
            $messageClass = "success";
           $message="Reference Book deleted successfully!";
        } else {
            $messageClass = "error";
            $message="Error deleting record: " . $conn->error;
        }
        echo "<div class='$messageClass' id='message'>$message <span class='close-btn' onclick='closeMessage()'>&times;</span><div class='progress-bar' id='progress-bar'></div></div>";
    }
    // Web Resources
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['save_web_resources'])) {
            $course_code = $_POST['course_code'];
            $web_resources = $_POST['web_resources'];
            $checkCourseCodeQuery = "SELECT * FROM courses WHERE course_code = '$course_code'";
            $result = $conn->query($checkCourseCodeQuery);
            if ($result && $result->num_rows > 0) {
                $insertWebResourcesQuery = "INSERT INTO web_resources (course_code, web_resources) VALUES ('$course_code', '$web_resources')";
                if ($conn->query($insertWebResourcesQuery) === TRUE) {
                    $messageClass = "success";
                    $message = "Web Resources added successfully!";
                } else {
                    $messageClass = "error";
                    $message = "Error: Could not insert content. " . $conn->error;
                }
            } 
            echo "<div class='$messageClass' id='message'>$message <span class='close-btn' onclick='closeMessage()'>&times;</span><div class='progress-bar' id='progress-bar'></div></div>";
        }
    }
    if (isset($_POST['update_web_resources'])) {
        $id = $_POST['id'];
        $web_resources = $_POST['web_resources'];
        $sql = "UPDATE web_resources SET web_resources='$web_resources' WHERE id='$id'";
        if ($conn->query($sql) === False) {
            $messageClass = "success";
            $message = "Web Resources updated successfully!";
        } else {
            $messageClass = "error";
            $message ="Error: " . $sql . "<br>" . $conn->error;
        }
        echo "<div class='$messageClass' id='message'>$message <span class='close-btn' onclick='closeMessage()'>&times;</span><div class='progress-bar' id='progress-bar'></div></div>";
    }
    if (isset($_POST['delete_web_resources'])) {
        $id = intval($_POST['id']); 
        $sql = "DELETE FROM web_resources WHERE id = $id";
        if ($conn->query($sql)) {
            $messageClass = "success";
            $message="Web Resources deleted successfully!";
        } else {
            $messageClass = "error";
            $message="Error deleting record: " . $conn->error;

        }
        echo "<div class='$messageClass' id='message'>$message <span class='close-btn' onclick='closeMessage()'>&times;</span><div class='progress-bar' id='progress-bar'></div></div>";
    }
    // Course Designer
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['save_course_designer'])) {
            $course_code = $_POST['course_code'];
            $course_designer = $_POST['course_designer'];
            $checkCourseCodeQuery = "SELECT * FROM courses WHERE course_code = '$course_code'";
            $result = $conn->query($checkCourseCodeQuery);
            if ($result && $result->num_rows > 0) {
                $insertCourseDesignerQuery = "INSERT INTO course_designer (course_code, course_designer) VALUES ('$course_code', '$course_designer')";
                if ($conn->query($insertCourseDesignerQuery) === TRUE) {
                    $messageClass = "success";
                    $message = "Course Designer added successfully!";
                } else {
                    $messageClass = "error";
                    $message = "Error: Could not insert content. " . $conn->error;
                }
            } 
            echo "<div class='$messageClass' id='message'>$message <span class='close-btn' onclick='closeMessage()'>&times;</span><div class='progress-bar' id='progress-bar'></div></div>";
        }
    }
    if (isset($_POST['update_course_designer'])) {
        $id = $_POST['id'];
        $course_designer = $_POST['course_designer'];
        $sql = "UPDATE course_designer SET course_designer='$course_designer' WHERE id='$id'";
        if ($conn->query($sql) === TRUE) {
            $messageClass = "success";
            $message = "Course Designer updated successfully!";
        } else {
            $messageClass = "error";
            $message ="Error: " . $sql . "<br>" . $conn->error;

        }
        echo "<div class='$messageClass' id='message'>$message <span class='close-btn' onclick='closeMessage()'>&times;</span><div class='progress-bar' id='progress-bar'></div></div>";
    }
    if (isset($_POST['delete_course_designer'])) {
        $id = intval($_POST['id']); 
        $sql = "DELETE FROM course_designer WHERE id = $id";
        if ($conn->query($sql)) {
            $messageClass = "success";
            $message="Course Designer deleted successfully!";
        } else {
            $messageClass = "error";
            $message="Error deleting record: " . $conn->error;
        }
        echo "<div class='$messageClass' id='message'>$message <span class='close-btn' onclick='closeMessage()'>&times;</span><div class='progress-bar' id='progress-bar'></div></div>";
    }
    // department
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['save_department'])) {
            $course_code = $_POST['course_code'];
            $department = $_POST['department'];
            $content = $_POST['content'];
            $checkCourseCodeQuery = "SELECT * FROM courses WHERE course_code = '$course_code'";
            $result = $conn->query($checkCourseCodeQuery);
            if ($result && $result->num_rows > 0) {
                $checkDuplicateQuery = "SELECT * FROM department WHERE course_code = '$course_code'";
                $duplicateResult = $conn->query($checkDuplicateQuery);
                if ($duplicateResult && $duplicateResult->num_rows > 0) {
                    $messageClass = "error";
                    $message = "Error: Course Code '$course_code' already exists in the pre_requisite table.";
                } else {
                    $insertContentQuery = "INSERT INTO department (course_code, department, content) VALUES ('$course_code', '$department', '$content')";
                    if ($conn->query($insertContentQuery) === TRUE) {
                        $messageClass = "success";
                        $message = "department added successfully!";
                    } else {
                        $messageClass = "error";
                        $message = "Error: Could not insert department. " . $conn->error;
                    }
                }
            } else {
                $messageClass = "error";
                $message = "Error: Course Code '$course_code' does not match any existing records in the courses table.";
            }
            echo "<div class='$messageClass' id='message'>$message <span class='close-btn' onclick='closeMessage()'>&times;</span><div class='progress-bar' id='progress-bar'></div></div>";
        }
    }
    if (isset($_POST['update_department'])) {
        $id = $_POST['id'];
        $department = $_POST['department'];
        $content = $_POST['content'];
        $sql = "UPDATE department SET department='$department', content='$content' WHERE id='$id'";
        if ($conn->query($sql) === TRUE) {
            $messageClass = "success";
            $message = "department updated successfully!";
        } else {
            $messageClass = "error";
            $message ="Error: " . $sql . "<br>" . $conn->error;

        }
        echo "<div class='$messageClass' id='message'>$message <span class='close-btn' onclick='closeMessage()'>&times;</span><div class='progress-bar' id='progress-bar'></div></div>";
    }
    if (isset($_POST['delete_department'])) {
        $id = intval($_POST['id']); 
        $sql = "DELETE FROM department WHERE id = $id";
        if ($conn->query($sql)) {
            $messageClass = "success";
            $message="department deleted successfully!";
        } else {
            $messageClass = "error";
            $message="Error deleting record: " . $conn->error;
        }
        echo "<div class='$messageClass' id='message'>$message <span class='close-btn' onclick='closeMessage()'>&times;</span><div class='progress-bar' id='progress-bar'></div></div>";
    }
    // chapter
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['save_chapter'])) {
            $course_code = $_POST['course_code'];
            $unit = $_POST['unit'];
            $chapter = $_POST['chapter'];
            $book = $_POST['book'];
            $checkCourseCodeQuery = "SELECT * FROM courses WHERE course_code = '$course_code'";
            $result = $conn->query($checkCourseCodeQuery);
            if ($result && $result->num_rows > 0) {
                $insertContentQuery = "INSERT INTO chapter (course_code, unit, chapter, book) VALUES ('$course_code', '$unit', '$chapter', '$book')";
                if ($conn->query($insertContentQuery) === TRUE) {
                    $messageClass = "success";
                    $message = "Chapter added successfully!";
                } else {
                    $messageClass = "error";
                    $message = "Error: Could not insert Chapter. " . $conn->error;
                }
            }
            echo "<div class='$messageClass' id='message'>$message <span class='close-btn' onclick='closeMessage()'>&times;</span><div class='progress-bar' id='progress-bar'></div></div>";
        }
    }
    if (isset($_POST['update_chapter'])) {
        $id = $_POST['id'];
        $unit = $_POST['unit'];
        $chapter = $_POST['chapter'];
        $book = $_POST['book'];
        $sql = "UPDATE chapter SET unit='$unit', chapter='$chapter', book='$book' WHERE id='$id'";
     
        if ($conn->query($sql) === TRUE) {
            $messageClass = "success";
            $message = "Chapter updated successfully!";
        } else {
            $messageClass = "error";
            $message ="Error: " . $sql . "<br>" . $conn->error;
        }
        
        echo "<div class='$messageClass' id='message'>$message <span class='close-btn' onclick='closeMessage()'>&times;</span><div class='progress-bar' id='progress-bar'></div></div>";
    }
    
    if (isset($_POST['delete_chapter'])) {
        $id = intval($_POST['id']); 
        $sql = "DELETE FROM chapter WHERE id = $id";
    
        if ($conn->query($sql)) {
            $messageClass = "success";
            $message="Chapter deleted successfully!";
        } else {
            $messageClass = "error";
            $message="Error deleting record: " . $conn->error;
        }
    
        echo "<div class='$messageClass' id='message'>$message <span class='close-btn' onclick='closeMessage()'>&times;</span><div class='progress-bar' id='progress-bar'></div></div>";
    }

    // bloomy
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['save_bloomy'])) {
            $course_code = $_POST['course_code'];
            $blooms_taxonomy = $_POST['blooms_taxonomy'];
            $ca_first = $_POST['ca_first'];
            $ca_second = $_POST['ca_second'];
            $end_of_semester = $_POST['end_of_semester'];
            $checkCourseCodeQuery = "SELECT * FROM courses WHERE course_code = '$course_code'";
            $result = $conn->query($checkCourseCodeQuery);
            if ($result->num_rows > 0) {
                $insertPreRequisiteQuery = "INSERT INTO bloomy (course_code, blooms_taxonomy, ca_first, ca_second, end_of_semester) 
                                            VALUES ('$course_code', '$blooms_taxonomy', '$ca_first', '$ca_second', '$end_of_semester')";
                if ($conn->query($insertPreRequisiteQuery) === TRUE) {
                    $messageClass = "success";
                    $message = "blooms taxonomy added successfully!";
                } else {
                    $messageClass = "error";
                    $message = "Error: Could not insert blooms_taxonomy row. " . $conn->error;
                }
            } 
            else {
                $messageClass = "error";
                $message = "Error: Course Code '$course_code' already this courese code is present";
            }
            echo "<div class='$messageClass' id='message'>$message <span class='close-btn' onclick='closeMessage()'>&times;</span><div class='progress-bar' id='progress-bar'></div></div>";
        }
    }
    if (isset($_POST['update_bloomy'])) {
            $id = $_POST['id'];
            $blooms_taxonomy = $_POST['blooms_taxonomy'];
            $ca_first = $_POST['ca_first'];
            $ca_second = $_POST['ca_second'];
            $end_of_semester = $_POST['end_of_semester'];
            $sql = "UPDATE bloomy SET blooms_taxonomy='$blooms_taxonomy', ca_first='$ca_first', ca_second='$ca_second', end_of_semester='$end_of_semester' WHERE id='$id'";
        if ($conn->query($sql) === TRUE) {
            $messageClass = "success";
            $message = "Blooms Taxonomy updated successfully!";
        } else {
            $messageClass = "error";
            $message ="Error: " . $sql . "<br>" . $conn->error;
        }

        echo "<div class='$messageClass' id='message'>$message <span class='close-btn' onclick='closeMessage()'>&times;</span><div class='progress-bar' id='progress-bar'></div></div>";
    }
    if (isset($_POST['delete_bloomy'])) {
        $id = intval($_POST['id']); 
        $sql = "DELETE FROM bloomy WHERE id = $id";
        if ($conn->query($sql)) {
            $messageClass = "success";
            $message="Blooms Taxonomy deleted successfully!";
        } else {
            $messageClass = "error";
            $message="Error deleting record: " . $conn->error;
        }
        echo "<div class='$messageClass' id='message'>$message <span class='close-btn' onclick='closeMessage()'>&times;</span><div class='progress-bar' id='progress-bar'></div></div>";
    }



?>
<!-- progress bar -->
<script>
           // Hide the message after 3 seconds and show progress bar
           function showProgressBar() {
            var progressBar = document.getElementById('progress-bar');
            var width = 0;
            var interval = setInterval(function() {
                if (width >= 100) {
                    clearInterval(interval);
                    var messageDiv = document.getElementById('message');
                    if (messageDiv) {
                        messageDiv.style.display = 'none';
                    }
                } else {
                    width++;
                    progressBar.style.width = width + '%';
                }
            }, 30); 
        }

        showProgressBar();

        // Function to close the message when the close button is clicked
        function closeMessage() {
            var messageDiv = document.getElementById('message');
            if (messageDiv) {
                messageDiv.style.display = 'none';
            }
        }
    </script>