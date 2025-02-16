<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['course_codes'])) {
        $courseCodes = json_decode($_POST['course_codes'], true);
    }
?>
<div>
    <label for="course-code">Enter Course Code(s):</label>
    <span>
        <input type="text" id="course-code" placeholder="Type course code(s) separated by commas" value="<?php echo !empty($courseCodes) ? htmlspecialchars(implode(', ', $courseCodes)) : ''; ?>" />
    </span>
</div>
<button id="download-btn" disabled>Download</button>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const input = document.getElementById("course-code");
        const button = document.getElementById("download-btn");
        button.disabled = !input.value.trim();
        input.addEventListener("input", () => {
            button.disabled = !input.value.trim();
        });
        button.addEventListener("click", () => {
            const courseCodes = input.value.trim();
            if (courseCodes) {
                const form = document.createElement("form");
                form.method = "POST";
                form.action = "./db/download.php";
                const hiddenField = document.createElement("input");
                hiddenField.type = "hidden";
                hiddenField.name = "course_codes";
                hiddenField.value = courseCodes;
                form.appendChild(hiddenField);
                document.body.appendChild(form);
                form.submit();
            }
        });
    });
</script>