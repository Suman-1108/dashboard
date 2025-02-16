<?php
    include './db/db_conn.php';
    include './db/sql.php';
?>
<button id="addNewBtn" class="btn" style="margin-left: 10px;">Add New</button>
<table id="example" class="table table-striped" style="width:100%">
    <thead>
        <tr>
            <th>Course Code</th>
            <th>Unit</th>
            <th>Content</th>
            <th>Hours</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $sql = "SELECT * FROM content";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['course_code']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['unit']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['content']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['hour']) . "</td>";
                        echo "<td>";
                            echo "<button class='btn btn-sm btn-primary editBtn' data-id='".$row['id']."' data-code='".$row['course_code']."' data-unit='".$row['unit']."' data-content='".$row['content']."' data-hour='".$row['hour']."'><i class='bi bi-pencil'></i></button>";
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
            <h2>Add Content</h2>
            <span id="closeModal" class="close">&times;</span>
        </div>
        <form method="post">
            <div class="form-row">
                <div class="form-column">
                    <label for="course_code">Course Code:</label>
                    <input type="text" id="course_code" name="course_code" required>
                </div>
                <div class="form-column">
                    <label for="unit">Unit:</label>
                    <input type="text" id="unit" name="unit" required>
                </div>
                <div class="form-column">
                    <label for="content">Content:</label>
                    <textarea name="content" id="content" required></textarea>
                </div>
            </div>
            <div class="form-row">
                <div class="form-column">
                    <label for="hour">Hours:</label>
                    <input type="text" id="hour" name="hour" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="save" class="btn btn-success" name="save_content">Save</button>
            </div>
        </form>
    </div>
</div>
<div id="editNewModal" class="modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Edit Content</h2>
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
                    <label for="edit_unit">Unit:</label>
                    <input type="text" id="edit_unit" name="unit" required>
                </div>
                <div class="form-column">
                    <label for="edit_content">Content:</label>
                    <textarea name="content" id="edit_content" required></textarea>
                </div>
            </div>
            <div class="form-row">
                <div class="form-column">
                    <label for="edit_hour">Hours:</label>
                    <input type="text" id="edit_hour" name="hour" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" name="update_content">Update</button>
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
                    <button type="save" class="btn btn-danger" name="delete_content">Delete</button>
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
            var unit = this.getAttribute("data-unit");
            var content = this.getAttribute("data-content");
            var hour = this.getAttribute("data-hour");
            document.getElementById("edit_id").value = id;
            document.getElementById("edit_course_code").value = code;
            document.getElementById("edit_unit").value = unit;
            document.getElementById("edit_content").value = content;
            document.getElementById("edit_hour").value = hour;
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