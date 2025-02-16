<?php
    include './db/db_conn.php';
    include './db/sql.php';
?>
<button id="addNewBtn" class="btn" style="margin-left: 10px; margin-bottom: 10px;">Add New</button>
<table id="example" class="table table-striped" style="width:100%">
    <thead>
        <tr>
            <th>Course Code</th>
            <th>Course Outcomes</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $sql = "SELECT * FROM course_outcomes";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['course_code']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['course_outcomes']) . "</td>";
                        echo "<td>";
                            echo "<button class='btn btn-sm btn-primary editBtn' data-id='".$row['id']."' data-code='".$row['course_code']."' data-course_outcomes='".$row['course_outcomes']."'><i class='bi bi-pencil'></i></button>";
                            echo "<button class='btn btn-sm btn-danger ms-2 delete-button' data-item-id='".$row['id']."'><i class='bi bi-trash'></i></button>";
                        echo "</td>";
                    echo "</tr>";
                }
            }
        ?>
    </tbody>
</table>
<button id="addNewRowBtn" class="btn" style="margin-left: 10px;">Add Row</button>
<table id="modeltable" class="table table-striped" style="width:100%">
    <thead>
        <tr>
            <!-- <th>#</th> -->
            <th>Code</th>
            <th>Course Outcome</th>
            <th>Expected Proficiency</th>
            <th>Expected Attainment</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $sql = "SELECT * FROM course_outcome";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $counter = 1;
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                        // echo "<td>CO" . $counter++ . "</td>"; 
                        echo "<td>" . htmlspecialchars($row['course_code']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['course_outcome']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['expected_proficiency']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['expected_attainment']) . "</td>";
                        echo "<td>";
                            echo "<button class='btn btn-sm btn-primary editRowBtn' data-id='".$row['id']."' data-course_outcome='".$row['course_outcome']."' data-expected_proficiency='".$row['expected_proficiency']."' data-expected_attainment='".$row['expected_attainment']."'><i class='bi bi-pencil'></i></button>";
                            echo "<button class='btn btn-sm btn-danger ms-2 delete-row-button' data-row-id='".$row['id']."'><i class='bi bi-trash'></i></button>";
                        echo "</td>";
                    echo "</tr>";
                }
            }
        ?>
    </tbody>
</table>

<!-- Modal for Add New Course Outcome -->
<div id="addNewModal" class="modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Add Course Outcomes</h2>
            <span id="closeModal" class="close">&times;</span>
        </div>
        <form method="post">
            <div class="form-row">
                <div class="form-column">
                    <label for="course_code">Course Code:</label>
                    <input type="text" id="course_code" name="course_code" required>
                </div>
                <div class="form-column">
                    <label for="course_outcomes">Course Outcomes:</label>
                    <textarea name="course_outcomes" id="course_outcomes" required></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" name="save_course_outcomes">Save</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal for Add Row -->
<div id="addNewRowModal" class="modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Add Course Outcome Row</h2>
            <span id="closeRowModal" class="close">&times;</span>
        </div>
        <form method="post">
            <div class="form-row">
                <div class="form-column">
                    <label for="course_code">Course Code:</label>
                    <input type="text" id="course_code" name="course_code" required>
                </div>
                <div class="form-column">
                    <label for="course_outcome">Course Outcome:</label>
                    <textarea name="course_outcome" id="course_outcome" required></textarea>
                </div>
                <div class="form-column">
                    <label for="expected_proficiency">Expected Proficiency:</label>
                    <input type="text" id="expected_proficiency" name="expected_proficiency" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-column">
                    <label for="expected_attainment">Expected Attainment:</label>
                    <input type="text" id="expected_attainment" name="expected_attainment" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" name="save_course_rows">Save</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal for Edit Course Outcomes -->
<div id="editNewModal" class="modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Edit Course Outcomes</h2>
            <span id="closeEditModal" class="close">&times;</span>
        </div>
        <form method="post">
            <input type="hidden" id="edit_id" name="id">
            <div class="form-row">
                <div class="form-column">
                    <label for="edit_course_code">Course Code:</label>
                    <input type="text" id="edit_course_code" name="course_code" required>
                </div>
                <div class="form-column">
                    <label for="edit_course_outcomes">Course Outcomes:</label>
                    <textarea name="course_outcomes" id="edit_course_outcomes" required></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" name="update_course_outcomes">Update</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal for Edit Course Outcome Row -->
<div id="editNewRowModal" class="modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Edit Course Outcome Row</h2>
            <span id="closeEditRowModal" class="close">&times;</span>
        </div>
        <form method="post">
            <input type="hidden" id="edit_course_id" name="id">
            <div class="form-row">
                <div class="form-column">
                    <label for="edit_course_outcome">Course Outcome:</label>
                    <textarea name="course_outcome" id="edit_course_outcome" required></textarea>
                </div>
                <div class="form-column">
                    <label for="edit_expected_proficiency">Expected Proficiency:</label>
                    <input type="text" id="edit_expected_proficiency" name="expected_proficiency" required>
                </div>
                <div class="form-column">
                    <label for="edit_expected_attainment">Expected Attainment:</label>
                    <input type="text" id="edit_expected_attainment" name="expected_attainment" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="save" class="btn btn-success" name="update_row">Update</button>
            </div>
        </form>
    </div>
</div>
<div class="modal" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this item?
            </div>
            <div class="modal-footer">
                <form method="POST" action="" id="deleteForm">
                    <input type="hidden" name="id" id="deleteItemId">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="save" class="btn btn-danger" name="delete_course_outcomes">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="deleteRowModal" tabindex="-1" aria-labelledby="deleteRowModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteRowModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this item?
            </div>
            <div class="modal-footer">
                <form method="POST" action="" id="deleteRowForm">
                    <input type="hidden" name="id" id="deleteRowItemId">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="save" class="btn btn-danger" name="delete_row">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#example').DataTable();
    });
    $(document).ready(function() {
        $('#modeltable').DataTable();
    });

    var addNewModal = document.getElementById("addNewModal");
    var addNewBtn = document.getElementById("addNewBtn");
    var closeAddNewModal = document.getElementById("closeModal");
    addNewBtn.onclick = function() {
        addNewModal.style.display = "block";
    };
    closeAddNewModal.onclick = function() {
        addNewModal.style.display = "none";
    };

    // Handle Add Row Modal
    var addNewRowModal = document.getElementById("addNewRowModal");
    var addNewRowBtn = document.getElementById("addNewRowBtn");
    var closeAddNewRowModal = document.getElementById("closeRowModal");
    addNewRowBtn.onclick = function() {
        addNewRowModal.style.display = "block";
    };
    closeAddNewRowModal.onclick = function() {
        addNewRowModal.style.display = "none";
    };

    // Handle Edit Course Outcome Modal
    var editNewModal = document.getElementById("editNewModal");
    var closeEditModal = document.getElementById("closeEditModal");
    document.querySelectorAll('.editBtn').forEach(function(button) {
        button.onclick = function() {
            var id = this.getAttribute("data-id");
            var code = this.getAttribute("data-code");
            var course_outcomes = this.getAttribute("data-course_outcomes");
            document.getElementById("edit_id").value = id;
            document.getElementById("edit_course_code").value = code;
            document.getElementById("edit_course_outcomes").value = course_outcomes;
            editNewModal.style.display = "block";
        };
    });

    closeEditModal.onclick = function() {
        editNewModal.style.display = "none";
    };

    // Handle Edit Row Modal
    var editNewRowModal = document.getElementById("editNewRowModal");
    var closeEditRowModal = document.getElementById("closeEditRowModal");
    document.querySelectorAll('.editRowBtn').forEach(function(button) {
        button.onclick = function() {
            var id = this.getAttribute("data-id");
            var course_outcome = this.getAttribute("data-course_outcome");
            var expected_proficiency = this.getAttribute("data-expected_proficiency");
            var expected_attainment = this.getAttribute("data-expected_attainment");
            document.getElementById("edit_course_id").value = id;
            document.getElementById("edit_course_outcome").value = course_outcome;
            document.getElementById("edit_expected_proficiency").value = expected_proficiency;
            document.getElementById("edit_expected_attainment").value = expected_attainment;
            editNewRowModal.style.display = "block";
        };
    });

    closeEditRowModal.onclick = function() {
        editNewRowModal.style.display = "none";
    };
    let selectedItemId;
    document.querySelectorAll('.delete-button').forEach(button => {
        button.addEventListener('click', function () {
            selectedItemId = this.getAttribute('data-item-id');
            console.log("Selected Item ID:", selectedItemId);
            const deleteModalElement = document.getElementById('deleteModal');
            if (deleteModalElement) {
                const deleteModal = new bootstrap.Modal(deleteModalElement);
                document.getElementById('deleteItemId').value = selectedItemId;
                deleteModal.show();
            } else {
                console.error("Modal element with ID 'deleteModal' not found.");
            }
        });
    });
    let selectedRowItemId;
    document.querySelectorAll('.delete-row-button').forEach(button => {
        button.addEventListener('click', function () {
            selectedRowItemId = this.getAttribute('data-row-id');
            console.log("Selected Row Item ID:", selectedRowItemId);
            const deleteRowModalElement = document.getElementById('deleteRowModal');
            if (deleteRowModalElement) {
                const deleteRowModal = new bootstrap.Modal(deleteRowModalElement);
                document.getElementById('deleteRowItemId').value = selectedRowItemId;
                deleteRowModal.show();
            } else {
                console.error("Modal element with ID 'deleteModal' not found.");
            }
        });
    });
</script>