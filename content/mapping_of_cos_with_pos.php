<?php
    include './db/db_conn.php';
    include './db/sql.php';
?>
<button id="addNewBtn" class="btn" style="margin-left: 10px; margin-bottom: 10px;">Add New</button>
<table id="example" class="table table-striped" style="width:100%">
    <thead>
        <tr>
            <!-- <th></th> -->
            <th>Course Code</th>
            <th>P01</th>
            <th>P02</th>
            <th>P03</th>
            <th>P04</th>
            <th>P05</th>
            <th>P06</th>
            <th>P07</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $sql = "SELECT * FROM mapping_pos";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $counter = 1;
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                        // echo "<td>CO" . $counter++ . "</td>";
                        echo "<td>" . htmlspecialchars($row['course_code']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['po1']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['po2']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['po3']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['po4']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['po5']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['po6']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['po7']) . "</td>";
                        echo "<td>";
                            echo "<button class='btn btn-sm btn-primary editBtn'data-id='".$row['id']."' data-code='".$row['course_code']."' data-po1='".$row['po1']."' data-po2='".$row['po2']."' data-po3='".$row['po3']."' data-po4='".$row['po4']."' data-po5='".$row['po5']."' data-po6='".$row['po6']."' data-po7='".$row['po7']."'><i class='bi bi-pencil'></i></button>";
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
            <h2>Add Mapping of COs with POs</h2>
            <span id="closeModal" class="close">&times;</span>
        </div>
        <form method="post">
            <div class="form-row">
                <div class="form-column">
                    <label for="course_code">Course Code:</label>
                    <input type="text" id="course_code" name="course_code" required>
                </div>
                <div class="form-column">
                    <label for="po1">PO1</label>
                    <input type="text" id="po1" name="po1" required class="restricted-input">
                </div>
                <div class="form-column">
                    <label for="po2">PO2</label>
                    <input type="text" id="po2" name="po2" required class="restricted-input">
                </div>
            </div>
            <div class="form-row">
                <div class="form-column">
                    <label for="po3">PO3</label>
                    <input type="text" id="po3" name="po3" required class="restricted-input">
                </div>
                <div class="form-column">
                    <label for="po4">PO4</label>
                    <input type="text" id="po4" name="po4" required class="restricted-input">
                </div>
                <div class="form-column">
                    <label for="po5">PO5</label>
                    <input type="text" id="po5" name="po5" required class="restricted-input">
                </div>
            </div>
            <div class="form-row">
                <div class="form-column">
                    <label for="po6">PO6</label>
                    <input type="text" id="po6" name="po6" required class="restricted-input">
                </div>
                <div class="form-column">
                    <label for="po7">PO7</label>
                    <input type="text" id="po7" name="po7" required class="restricted-input">
                </div>
            </div>
            <div class="modal-footer">
                <button type="save" class="btn btn-success" name="save_mapping_cos">Save</button>
            </div>
        </form>
    </div>
</div>
<div id="editNewModal" class="modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Edit Mapping of COs with POs</h2>
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
                    <label for="edit_po1">PO1:</label>
                    <input type="text" id="edit_po1" name="po1" required class="restricted-input">
                </div>
                <div class="form-column">
                    <label for="edit_po2">PO2:</label>
                    <input type="text" id="edit_po2" name="po2" required class="restricted-input">
                </div>
            </div>
            <div class="form-row">
                <div class="form-column">
                    <label for="edit_po3">PO3:</label>
                    <input type="text" id="edit_po3" name="po3" required class="restricted-input">
                </div>
                <div class="form-column">
                    <label for="edit_po4">PO4:</label>
                    <input type="text" id="edit_po4" name="po4" required class="restricted-input">
                </div>
                <div class="form-column">
                    <label for="edit_po5">PO5:</label>
                    <input type="text" id="edit_po5" name="po5" required class="restricted-input">
                </div>
            </div>
            <div class="form-row">
                <div class="form-column">
                    <label for="edit_po6">PO6:</label>
                    <input type="text" id="edit_po6" name="po6" required class="restricted-input">
                </div>
                <div class="form-column">
                    <label for="edit_po7">PO7:</label>
                    <input type="text" id="edit_po7" name="po7" required class="restricted-input">
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" name="update_mapping_cos">Update</button>
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
                    <button type="save" class="btn btn-danger" name="delete_mapping_pos">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#example').DataTable();
    });
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
    var editNewModal = document.getElementById("editNewModal");
    var closeEditBtn = document.getElementById("closeEditModal");
    document.querySelectorAll('.editBtn').forEach(function(button) {
        button.onclick = function() {
            var id = this.getAttribute("data-id");
            var code = this.getAttribute("data-code");
            var po1 = this.getAttribute("data-po1");
            var po2 = this.getAttribute("data-po2");
            var po3 = this.getAttribute("data-po3");
            var po4 = this.getAttribute("data-po4");
            var po5 = this.getAttribute("data-po5");
            var po6 = this.getAttribute("data-po6");
            var po7 = this.getAttribute("data-po7");
            document.getElementById("edit_id").value = id;
            document.getElementById("edit_course_code").value = code;
            document.getElementById("edit_po1").value = po1;
            document.getElementById("edit_po2").value = po2;
            document.getElementById("edit_po3").value = po3;
            document.getElementById("edit_po4").value = po4;
            document.getElementById("edit_po5").value = po5;
            document.getElementById("edit_po6").value = po6;
            document.getElementById("edit_po7").value = po7;
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
    document.querySelectorAll('.restricted-input').forEach(input => {
        input.addEventListener('input', function () {
            let value = this.value.toUpperCase(); 
            if (!/^S?$/.test(value) && !/^M?$/.test(value)) { 
                this.value = value.replace(/[^SM]/g, ''); 
            } else {
                this.value = value; 
            }
        });
    });
    document.querySelectorAll('.restricted-input').forEach(input => {
        input.addEventListener('input', function () {
            let value = this.value.toUpperCase(); 
            if (!/^S?$/.test(value) && !/^M?$/.test(value)) { 
                this.value = value.replace(/[^SM]/g, ''); 
            } else {
                this.value = value; 
            }
        });
    });
</script>