<?php
    include './db/db_conn.php';
    include './db/sql.php';
?>
<button id="addNewBtn" class="btn" style="margin-left: 10px; margin-bottom: 10px;">Add New</button>
<table id="example" class="table table-striped" style="width:100%">
    <thead>
        <tr>
            <th>Course Code</th>
            <th>Course Designers</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $sql = "SELECT * FROM course_designer";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['course_code']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['course_designer']) . "</td>";
                        echo "<td>";
                            echo "<button class='btn btn-sm btn-primary editBtn' data-id='".$row['id']."' data-code='".$row['course_code']."' data-course_designer='".$row['course_designer']."'><i class='bi bi-pencil'></i></button>";
                            echo "<button class='btn btn-sm btn-danger ms-2 delete-button' data-item-id='".$row['id']."'><i class='bi bi-trash'></i></button>";
                        echo "</td>";
                    echo "</tr>";
                }
            }
        ?>
    </tbody>
</table>
<div id="addNewModal" class="modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Add Course Designer</h2>
            <span id="closeModal" class="close">&times;</span>
        </div>
        <form method="post">
            <div class="form-row">
                <div class="form-column">
                    <label for="course_code">Course Code:</label>
                    <input type="text" id="course_code" name="course_code" required>
                </div>
                <div class="form-column">
                    <label for="course_designer">Course Designer:</label>
                    <input type="text" id="course_designer" name="course_designer" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="save" class="btn btn-success" name="save_course_designer">Save</button>
            </div>
        </form>
    </div>
</div>
<div id="editNewModal" class="modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Edit Course Designer</h2>
            <span id="closeEditModal" class="close">&times;</span>
        </div>
        <form method="post">
            <input type="hidden" id="edit_id" name="id">
            <div class="form-row">
                <div class="form-column">
                    <label for="edit_course_code">Course Code:</label>
                    <input type="text" id="edit_course_code" name="course_code" disabled>
                </div>
                <div class="form-column">
                    <label for="edit_preamble">Course Designer:</label>
                    <input type="text" id="edit_course_designer" name="course_designer" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" name="update_course_designer">Update</button>
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
                    <button type="save" class="btn btn-danger" name="delete_course_designer">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    var modal = document.getElementById("addNewModal");
    var btn = document.getElementById("addNewBtn");
    var closeBtn = document.getElementById("closeModal");
    btn.onclick = function() {
        modal.style.display = "block";
    };
    closeBtn.onclick = function() {
        modal.style.display = "none";
    };
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    };
    $(document).ready(function() {
        $('#example').DataTable();
    });
    var editNewModal = document.getElementById("editNewModal");
    var closeEditBtn = document.getElementById("closeEditModal");
    document.querySelectorAll('.editBtn').forEach(function(button) {
        button.onclick = function() {
            var id = this.getAttribute("data-id");
            var code = this.getAttribute("data-code");
            var course_designer = this.getAttribute("data-course_designer");
            document.getElementById("edit_id").value = id;
            document.getElementById("edit_course_code").value = code;
            document.getElementById("edit_course_designer").value = course_designer;
            editNewModal.style.display = "block";
        };
    });
    closeEditBtn.onclick = function() {
        editNewModal.style.display = "none";
    };
    window.onclick = function(event) {
        if (event.target == editNewModal) {
            editNewModal.style.display = "none";
        }
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
</script>