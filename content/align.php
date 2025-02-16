<?php
    require("../PDF/fpdf.php");
    require("../db/db_conn.php");
    if (isset($_GET['course_codes'])) {
        $courseCodes = explode(',', urldecode($_GET['course_codes']));
        // Add Footer
        class PDF extends FPDF
        {
            function Footer()
            {
                $this->SetY(-15);
                $this->SetFont("Times", "", 10);
                $this->SetDrawColor(0, 176, 240);
                $this->SetLineWidth(1);
                $this->Line(10, $this->GetY() - 0, 200, $this->GetY() - 0);
                $this->Cell(0, 10, "GVN COLLEGE, KOVILPATTI(College in Palaya Appaneri, Tamil Nadu) ", 0, 0, "L");
                $this->Cell(0, 10, "Page " . $this->PageNo() . " of {nb}", 0, 0, "R");
            }
        }
        // Create a new instance of the PDF class
        $pdf = new PDF("P", "mm", "A4");
        $pdf->AliasNbPages();
        // Loop through the course codes
        foreach ($courseCodes as $courseCode) {
            $courseCode = trim($courseCode);
            // Department Details
            $sql = "SELECT * FROM department WHERE course_code = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $courseCode);
            $stmt->execute();
            $result = $stmt->get_result();
            // Add new page
            $pdf->AddPage();
            // Header section
            $pdf->SetY(15);
            $pdf->SetFont("Times", "B", 12);
            $pdf->Cell(0, 5, "G.VENKATASWAMY NAIDU COLLEGE, KOVILPATTI", 0, 1, "C");
            $pdf->Cell(0, 5, "(Re-Accredited with 'A++' Grade by NAAC)", 0, 1, "C");
            // Department details
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $pdf->Cell(0, 5, "DEPARTMENT OF " . $row['department'], 0, 1, "C");
                    $pdf->SetFont("Times", "", 10);
                    $content = $row['content'];
                    $pdf->Cell(0, 5, "($content)", 0, 1, "C");
                }
            } else {
                $pdf->Cell(0, 10, "Department: No data found", 0, 1);
                $pdf->Cell(0, 5, "(No content available)", 0, 1, "C");
            }
            // Programme Code Header
            $pdf->SetFont("Times", "B", 14);
            $pdf->Cell(0, 5, "Programme Code - PCS", 0, 1, "C");
            $pdf->Ln(0);
            // Adjust starting X position for centering the table
            $pdf->SetX(22);
            // Table Header
            $pdf->SetFont("Times", "B", 12);
            $columnWidths = [40, 50, 28, 10, 10, 10, 20];
            $pdf->Cell($columnWidths[0], 10, "Course Code", 1, 0, "", false);
            $pdf->Cell($columnWidths[1], 10, "Course Title", 1, 0, "", false);
            $pdf->Cell($columnWidths[2], 10, "Category", 1, 0, "", false);
            $pdf->Cell($columnWidths[3], 10, "L", 1, 0, "", false);
            $pdf->Cell($columnWidths[4], 10, "T", 1, 0, "", false);
            $pdf->Cell($columnWidths[5], 10, "P", 1, 0, "", false);
            $pdf->Cell($columnWidths[6], 10, "Credits", 1, 1, "", false);
            // Table Data
            $pdf->SetFont("Times", "", 12);
            $pdf->SetX(22);
            $data = [];
            $sql = "SELECT * FROM courses WHERE course_code = '$courseCode'";
            $result = $conn->query($sql);
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $data[] = [
                        $row['course_code'],
                        $row['course_title'],
                        $row['category'],
                        $row['l'],
                        $row['t'],
                        $row['p'],
                        $row['credit']
                    ];
                }
            } else {
                echo "No data found for the provided course code.";
                exit();
            }
            foreach ($data as $row) {
                $pdf->Cell($columnWidths[0], 7, $row[0], 1, 0, "");
                $pdf->Cell($columnWidths[1], 7, $row[1], 1, 0, "");
                $pdf->Cell($columnWidths[2], 7, $row[2], 1, 0, "");
                $pdf->Cell($columnWidths[3], 7, $row[3], 1, 0, "");
                $pdf->Cell($columnWidths[4], 7, $row[4], 1, 0, "");
                $pdf->Cell($columnWidths[5], 7, $row[5], 1, 0, "");
                $pdf->Cell($columnWidths[6], 7, $row[6], 1, 1, "");
            }
            // Subtitle for L, T, P
            $pdf->SetFont("Times", "", 10);
            $pdf->Cell(0, 5, "L - Lecture T - Tutorial P - Practical", 0, 1, "C");
            $pdf->Ln(2);
            $pdf->SetX(22);
            // Another Table Header for Year, Semester, Internal, External, Total
            $pdf->SetFont("Times", "B", 12);
            $pdf->Cell(30, 5, "Year", 1, 0, "C", false);
            $pdf->Cell(78, 5, "Semester", 1, 0, "C", false);
            $pdf->Cell(20, 5, "Internal", 1, 0, "C", false);
            $pdf->Cell(20, 5, "External", 1, 0, "C", false);
            $pdf->Cell(20, 5, "Total", 1, 1, "C", false);
            // Table Data for Year, Semester
            $pdf->SetFont("Times", "", 12);
            $pdf->SetX(22);
            $data = [];
            $sql = "SELECT * FROM courses WHERE course_code = '$courseCode'";
            $result = $conn->query($sql);
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $data[] = [
                        $row['year'],
                        $row['semester'],
                        $row['internal'],
                        $row['external'],
                        $row['total']
                    ];
                }
            } else {
                echo "No data found for the provided course code.";
                exit();
            }
            foreach ($data as $row) {
                $pdf->Cell(30, 7, $row[0], 1, 0, "C");
                $pdf->Cell(78, 7, $row[1], 1, 0, "C");
                $pdf->Cell(20, 7, $row[2], 1, 0, "C");
                $pdf->Cell(20, 7, $row[3], 1, 0, "C");
                $pdf->Cell(20, 7, $row[4], 1, 1, "C");
            }
            // Add preamble section
            $pdf->Ln(2);
            $pdf->SetX(16);
            $pdf->SetFont("Times", "B", 11);
            $pdf->SetFillColor(0, 176, 240); // Light cyan background
            $pdf->Cell(180, 5, "Preamble", 0, 1, "L", TRUE);
            // Add Long Text Content for Preamble
            $pdf->SetFont("Times", "", 11);
            $pdf->SetX(20);
            // Fetch the preamble content for the specific course
            $preambleText = '';
            $sql = "SELECT preamble FROM preamble WHERE course_code = '$courseCode'";
            $result = $conn->query($sql);
            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $preambleText = $row['preamble'];
            } else {
                $preambleText = "No preamble data available for this course.";
            }
            // Write the preamble text to the PDF
            $pdf->MultiCell(175, 5, $preambleText, 0, "J");
            // Pre-requisite
            $pdf->Ln(2);
            $pdf->SetX(16); 
            $pdf->SetFont("Times", "B", 11);
            //  Light gray background for headers
            $pdf->SetFillColor(0, 176, 240); // Light cyan background
            $pdf->Cell(180, 5, "Pre-requisite", 0, 1, "L",TRUE);
            // Add Long Text Content
            $pdf->SetFont("Times", "", 11); 
            // Normal font for the content
            $pdf->SetX(16); 
            $preRequisiteText = '';
            $sql = "SELECT pre_requisite FROM pre_requisite WHERE course_code = '$courseCode'";
            $result = $conn->query($sql);
            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $preRequisiteText = $row['pre_requisite'];
            } else {
                $preRequisiteText = "No pre Requisite data available for this course.";
            }
            // Write the preamble text to the PDF
            $pdf->MultiCell(180, 6, $preRequisiteText, 0, "J");
            // Course Outcomes
            $pdf->Ln(3);
            $pdf->SetX(16); 
            $pdf->SetFont("Times", "B", 11);
            // Light gray background for headers
            $pdf->SetFillColor(0, 176, 240);
            $pdf->Cell(180, 5, "Course Outcomes", 0, 1, "L",TRUE);
            // Add Long Text Content
            $pdf->SetFont("Times", "", 11); 
            // Normal font for the content 
            $pdf->SetX(16);
            $courseOutcomesText = '';
            $sql = "SELECT course_outcomes FROM course_outcomes WHERE course_code = '$courseCode'";
            $result = $conn->query($sql);
            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $courseOutcomesText = $row['course_outcomes'];
            } else {
                $courseOutcomesText = "No course Outcomes data available for this course.";
            }
            // Use MultiCell for properly wrapping text
            $pdf->MultiCell(180, 6, $courseOutcomesText, 0, "J");
            
            $pdf->SetX(16); 
            // Another Table Header
            $pdf->SetFont("Times", "B", 12);
            $pdf->Cell(10, 7, "#", 1, 0, "C", FALSE);
            $pdf->Cell(90, 7, "Course Outcome", 1, 0, "C", FALSE);
            $pdf->Cell(40, 7, "Expected Proficiency", 1, 0, "C", FALSE);
            $pdf->Cell(40, 7, "Expected Attainment", 1, 1, "C", FALSE); 
            // Table Data
            $pdf->SetFont("Times", "", 10); 
            $sql = "SELECT * FROM course_outcome WHERE course_code = '$courseCode'";
            $result = $conn->query($sql);
            $counter = 1;
            $data = [];
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $data[] = [
                        'CO' . $counter ++,
                        $row['course_outcome'],    
                        $row['expected_proficiency'],
                        $row['expected_attainment']
                    ];
                }
            } else {
                echo "No data found for the provided course code.";
                exit();
            }
            foreach ($data as $row) {
                $xStart = 16;
                $rowHeight = 5;
                $lineHeight = 5;
                $maxLines = $pdf->GetStringWidth($row[1]) / 80;
                $calculatedHeight = ceil($maxLines) * $lineHeight;
                $rowHeight = max($rowHeight, $calculatedHeight);
                $pdf->SetX($xStart);
                $pdf->SetFont("Times", "B", 10);
                $pdf->Cell(10, $rowHeight, $row[0], 1, 0, "F");
                $pdf->SetFont("Times", "", 10);
                $x = $pdf->GetX(); 
                $y = $pdf->GetY(); 
                $pdf->MultiCell(90, $lineHeight, $row[1], 1, "F"); 
                $pdf->SetXY($x + 90, $y);
                $pdf->Cell(40, $rowHeight, $row[2], 1, 0, "F"); 
                $pdf->Cell(40, $rowHeight, $row[3], 1, 1, "F");
            }
            $pdf->Ln(5);
            $pdf->SetX(16);
            $pdf->SetFont("Times", "B", 11);
            // Light gray background for headers
            $pdf->SetFillColor(0, 176, 240); // Light cyan background
            $pdf->Cell(180, 5, "Mapping of COs with POs", 0, 1, "L",TRUE);
            // Table Header
            $pdf->SetFont("Times", "B", 10);
            $pdf->Ln(1);
            $pdf->SetX(16);
            // Adjusted column widths to fit within 190mm
            $columnWidths = [22.5, 22.5, 22.5, 22.5, 22.5, 22.5, 22.5, 22.5 ];
            $pdf->Cell($columnWidths[0], 7, "", 1, 0, "C",false);
            $pdf->Cell($columnWidths[1], 7, "PO1", 1, 0, "C",false);
            $pdf->Cell($columnWidths[2], 7, "PO2", 1, 0, "C",false);
            $pdf->Cell($columnWidths[3], 7, "PO3", 1, 0, "C",false);
            $pdf->Cell($columnWidths[4], 7, "PO4 ", 1, 0, "C",false);
            $pdf->Cell($columnWidths[5], 7, "PO5", 1, 0, "C",false);
            $pdf->Cell($columnWidths[6], 7, "PO6", 1, 0, "C",false);
            $pdf->Cell($columnWidths[7], 7, "PO7", 1, 1, "C",false);
            // Table Data
            $pdf->SetFont("Times", "", 10);
            $sql = "SELECT * FROM mapping_pos WHERE course_code = '$courseCode'";
            $result = $conn->query($sql);
            $counter = 1;
            $data = [];
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $data[] = [
                        'CO' . $counter ++,
                        $row['po1'],  
                        $row['po2'],  
                        $row['po3'],  
                        $row['po4'],               
                        $row['po5'],     
                        $row['po6'],      
                        $row['po7']    
                    ];
                }
            } else {
                echo "No data found for the provided course code.";
                exit();
            }
            foreach ($data as $row) {
                $pdf->SetX(16);
                $pdf->SetFont("Times", "B", 11);
                $pdf->Cell($columnWidths[0], 5, $row[0], 1, 0, "C");
                $pdf->Cell($columnWidths[1], 5, $row[1], 1, 0, "C");
                $pdf->Cell($columnWidths[2], 5, $row[2], 1, 0, "C");
                $pdf->Cell($columnWidths[3], 5, $row[3], 1, 0, "C");
                $pdf->Cell($columnWidths[4], 5, $row[4], 1, 0, "C");
                $pdf->Cell($columnWidths[5], 5, $row[5], 1, 0, "C");
                $pdf->Cell($columnWidths[6], 5, $row[6], 1, 0, "C");
                $pdf->Cell($columnWidths[7], 5, $row[7], 1, 1, "C");
                
            }
            $pdf->Ln(0);
            //sub title -> S,M,L
            $pdf->SetFont("Times", "B", 10);
            $pdf->Cell(0, 10, "S - STRONG  M - MEDIUM   L - LOW", 0, 1, "C");
            //space of the page
            $pdf->Ln(2);
            $pdf->SetX(16);
            $pdf->SetFont("Times", "B", 11);
            // Light gray background for headers
            $pdf->SetFillColor(0, 176, 240); // Light cyan background
            $pdf->Cell(180, 5, "Mapping of COs with PSOs", 0, 1, "L",TRUE);
            // Table Header
            $pdf->SetFont("Times", "B", 10);
            $pdf->Ln(1);
            // Adjusted column widths to fit within 190mm
            $columnWidths = [30, 30, 30, 30, 30, 30 ];
            $pdf->SetX(16);
            $pdf->Cell($columnWidths[0], 7, "", 1, 0, "C",false);
            $pdf->Cell($columnWidths[1], 7, "PSO1", 1, 0, "C",false);
            $pdf->Cell($columnWidths[2], 7, "PSO2", 1, 0, "C",false);
            $pdf->Cell($columnWidths[3], 7, "PSO3", 1, 0, "C",false);
            $pdf->Cell($columnWidths[4], 7, "PSO4 ", 1, 0, "C",false);
            $pdf->Cell($columnWidths[5], 7, "PSO5", 1, 1, "C",false);
            // Table Data
            $pdf->SetFont("Times", "", 10);
            $sql = "SELECT * FROM mapping_psos WHERE course_code = '$courseCode'";
            $result = $conn->query($sql);
            $counter = 1;
            $data = [];  // helper data
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $data[] = [
                        'CO' . $counter ++,
                        $row['po1'],  
                        $row['po2'],  
                        $row['po3'],  
                        $row['po4'],               
                        $row['po5']    
                    ];
                }
            } else {
                echo "No data found for the provided course code.";
                exit();
            }
            foreach ($data as $row) {
                $pdf->SetX(16);
                $pdf->SetFont("Times", "B", 11);
                $pdf->Cell($columnWidths[0], 5, $row[0], 1, 0, "C");
                $pdf->Cell($columnWidths[1], 5, $row[1], 1, 0, "C");
                $pdf->Cell($columnWidths[2], 5, $row[2], 1, 0, "C");
                $pdf->Cell($columnWidths[3], 5, $row[3], 1, 0, "C");
                $pdf->Cell($columnWidths[4], 5, $row[4], 1, 0, "C");
                $pdf->Cell($columnWidths[5], 5, $row[5], 1, 1, "C");   
            } 
            //sub title -> S,M,L
            $pdf->SetFont("Times", "B", 10);
            $pdf->Cell(0, 10, "S - STRONG  M - MEDIUM   L - LOW", 0, 1, "C");
            $pdf->Ln(5);
            $pdf->SetX(16);
            $pdf->SetFont("Times", "B", 11);
            $pdf->SetFillColor(0, 176, 240); // Light cyan background
            $pdf->Cell(180, 5, "Bloom's Taxonomy", 0, 1, "L", true);
            // Add sub-header row with sections (CA and End of Semester)
            $pdf->Ln(1);
            $pdf->SetX(30);
            $pdf->Cell(150, 5, "Bloom's Taxonomy", 1, 1, "L", false);
            $pdf->SetFont("Times", "B", 10);
            $pdf->SetX(30);
            $pdf->Cell(37.5, 5, "", 1, 0, "C", false); 
            $pdf->Cell(75, 5, "CA", 1, 0, "C", false); 
            $pdf->Cell(37.5, 5, "End of Semester", 1, 1, "C", false); 
            // Add CA First and CA Second sub-sections
            $pdf->SetX(30);
            $pdf->Cell(37.5, 5, "", 1, 0, "C", false);
            $pdf->Cell(37.5, 5, "First", 1, 0, "C", false);
            $pdf->Cell(37.5, 5, "Second", 1, 0, "C", false);
            $pdf->Cell(37.5, 5, "", 1, 1, "C", false); 
            // Table Data
            $pdf->SetFont('Times', '', 10);
            $sql = "SELECT * FROM bloomy WHERE course_code = '$courseCode'";
            $result = $conn->query($sql);
            $data = [];  // helper data
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $data[] = [
                        $row['blooms_taxonomy'],  
                        $row['ca_first'],  
                        $row['ca_second'],  
                        $row['end_of_semester'] 
                    ];
                }
            } else {
                echo "No data found for the provided course code.";
                exit();
            }
            foreach ($data as $row) {
                $pdf->SetX(30);
                $pdf->Cell(37.5, 5, $row[0], 1, 0, "L");
                $pdf->Cell(37.5, 5, $row[1], 1, 0, "C");
                $pdf->Cell(37.5, 5, $row[2], 1, 0, "C");
                $pdf->Cell(37.5, 5, $row[3], 1, 1, "C");
            }
            $pdf->Ln(5);
            $pdf->SetX(16);
            $pdf->SetFont("Times", "B", 11);
            $pdf->SetFillColor(0, 176, 240); 
            $pdf->Cell(180, 5, "Content", 0, 1, "L",TRUE);
            // Table Header
            $pdf->Ln(1);
            $sql = "SELECT * FROM content WHERE course_code = '$courseCode'";
            $result = $conn->query($sql);
            if ($result && $result->num_rows > 0) {
                $pdf->SetFont("Times", "B", 16);
                $pdf->Ln(2);
                // Fetch data and populate PDF
                while ($row = $result->fetch_assoc()) {
                    $data[] = [
                        $text1 = $row['unit'],
                        $text2 = $row['hour'],
                        $text3 = $row['content']   
                    ];
                    // Add unit header
                    $pdf->SetFont("Times", "B", 11);
                    $pdf->SetX(16);
                    $pdf->Cell(150, 10, "UNIT " . $text1, 0, 0, "L", false);
                    // Add hours
                    $pdf->SetX(130);
                    $pdf->Cell(10, 10, $text2, 0, 1, "L", false);
                    // Add content
                    $pdf->SetX(16);
                    $pdf->SetFont("Times", "", 11); // Normal font for content
                    $pdf->MultiCell(180, 5, $text3, 0, "J");
                    // Add spacing
                    $pdf->Ln(3);
                }
            } else {
                echo "No data found for the provided course code.";
                exit();
            }
            $pdf->Ln(5);
            $pdf->SetX(16);
            $pdf->SetFont("Times", "B", 11);
            $pdf->SetFillColor(0, 176, 240); // Light cyan background
            $pdf->Cell(180, 5, "Text Book", 0, 1, "L",TRUE);
            // Table Header
            $pdf->Ln(0);
            $pdf->SetFont("Times", "", 11); 
            $pdf->SetX(25);
            // Normal font for the content
            $sql = "SELECT * FROM text_book WHERE course_code = '$courseCode'";
            $result = $conn->query($sql);
            if ($result && $result->num_rows > 0) {
                $text = ""; 
                $serialNumber = 1;
                while ($row = $result->fetch_assoc()) {
                    $text .= $serialNumber . ". " . $row['text_book'] . "\n";
                    $serialNumber++; 
                }
            } else {
                echo "No data found for the provided course code.";
                exit();
            }
            // Use MultiCell for properly wrapping text
            $pdf->MultiCell(170, 5, $text, 0, "J");
             $pdf->Ln(5);
             $pdf->SetX(16);
             $pdf->SetFont("Times", "B", 11);
             // Light cyan background for headers
             $pdf->SetFillColor(0, 176, 240); 
             $pdf->Cell(180, 5, "Chapters:", 0, 1, "L",TRUE);
             // Table Header
             $pdf->Ln(5);
             $pdf->SetFont("Times", "", 10); 
             $pdf->SetX(25);
             // Normal font for the content
            $sql = "SELECT * FROM chapter WHERE course_code = '$courseCode'";
            $result = $conn->query($sql);
            if ($result && $result->num_rows > 0) {
                $text = ""; 
                $serialNumber = 1;
                while ($row = $result->fetch_assoc()) {
                    $unit = $row['unit'];
                    $chapter = $row['chapter']; 
                    $book = $row['book'];
                    $text .= $serialNumber . ". Unit " . $unit . " : " . $chapter . " (Book " . $book . ")\n";
                    $serialNumber++; 
                }
            } else {
                echo "No data found for the provided course code.";
                exit();
            }
            // Use MultiCell for properly wrapping text
            $pdf->MultiCell(180, 5, $text, 0, "L");
            $pdf->Ln(10);
            $pdf->SetX(16);
            $pdf->SetFont("Times", "B", 11);
            // Light cyan background for headers
            $pdf->SetFillColor(0, 176, 240); 
            $pdf->Cell(180, 5, "Reference Books", 0, 1, "L",TRUE);
            // Table Header
            $pdf->Ln(1);
            $pdf->SetFont("Times", "", 10); 
            // Normal font for the content
            $pdf->SetX(25);
            $sql = "SELECT * FROM reference_book WHERE course_code = '$courseCode'";
            $result = $conn->query($sql);
            if ($result && $result->num_rows > 0) {
                $text = ""; 
                $serialNumber = 1;
                while ($row = $result->fetch_assoc()) {
                    $text .= $serialNumber . ". " . $row['reference_book'] . "\n";
                    $serialNumber++; 
                }
            } else {
                echo "No data found for the provided course code.";
                exit();
            }
            // Use MultiCell for properly wrapping text
            $pdf->MultiCell(180, 5, $text, 0, "J");
            $pdf->Ln(4);
            $pdf->SetX(16);
            $pdf->SetFont("Times", "B", 11);
            // Light cyan background for headers
            $pdf->SetFillColor(0, 176, 240); 
            $pdf->Cell(180, 5, "Web Resources", 0, 1, "L",TRUE);
            // Table Header
            $pdf->Ln(1);
            $pdf->SetFont("Times", "", 11); 
            // Normal font for the content
            $pdf->SetX(25);
            $sql = "SELECT * FROM web_resources WHERE course_code = '$courseCode'";
            $result = $conn->query($sql);
            if ($result && $result->num_rows > 0) {
                $text = ""; 
                $serialNumber = 1;
                while ($row = $result->fetch_assoc()) {
                    $text .= $serialNumber . ". " . $row['web_resources'] . "\n";
                    $serialNumber++; 
                }
            } else {
                echo "No data found for the provided course code.";
                exit();
            }
            // Use MultiCell for properly wrapping text
            $pdf->MultiCell(180, 5, $text, 0, "J");
            $pdf->Ln(4);
            $pdf->SetX(16);
            $pdf->SetFont("Times", "B", 11);
            // Light cyan background for headers
            $pdf->SetFillColor(0, 176, 240);
            $pdf->Cell(180, 5, "Course Designers:", 0, 1, "L",TRUE);
            // Table Header
            $pdf->Ln(5);
            $pdf->SetFont("Times", "B", 11); 
            // Normal font for the content
            $pdf->SetX(30);
            $sql = "SELECT * FROM course_designer WHERE course_code = '$courseCode'";
            $result = $conn->query($sql);
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $data[] = [
                        $text = $row['course_designer']
                    ];
                }
            } else {
                echo "No data found for the provided course code.";
                exit();
            }
            // Use MultiCell for properly wrapping text
            $pdf->MultiCell(180, 5, $text, 0, "J");
        }
        // Close the database connection and output the PDF
        $stmt->close();
        $conn->close();
        $pdf->Output();
    } else {
        echo "No course codes provided.";
    }
?>
