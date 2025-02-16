<?php
    include './db/db_conn.php';
    include './db/sql.php';
?>
<button id="addNewBtn" class="btn" style="margin-left: 10px;">Add New</button>
<table id="example" class="table table-striped" style="width:100%">
    <thead>
        <tr>
            <th>Course Code</th>
            <th>Course Title</th>
            <th>Category</th>
            <th>L</th>
            <th>T</th>
            <th>P</th>
            <th>Credit</th>
            <th>Year</th>
            <th>Semester</th>
            <th>Internal</th>
            <th>External</th>
            <th>Total</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $sql = "SELECT * FROM courses";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['course_code']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['course_title']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['category']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['l']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['t']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['p']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['credit']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['year']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['semester']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['internal']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['external']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['total']) . "</td>";
                    echo "<td>
                        <button class='btn btn-sm btn-primary editBtn' data-id='".$row['id']."' data-code='".$row['course_code']."' data-title='".$row['course_title']."' data-category='".$row['category']."' data-l='".$row['l']."' data-t='".$row['t']."' data-p='".$row['p']."' data-credit='".$row['credit']."' data-year='".$row['year']."' data-semester='".$row['semester']."' data-internal='".$row['internal']."' data-external='".$row['external']."' data-total='".$row['total']."'><i class='bi bi-pencil'></i></button>
                        <button class='btn btn-sm btn-danger ms-2 delete-button' data-item-id='".$row['id']."' data-code='".$row['course_code']."'><i class='bi bi-trash'></i></button>
                    </td>";
                    echo "</tr>";
                }
            } 
        ?>
    </tbody>
</table>
<div id="addNewModal" class="modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Add Programme Code</h2>
            <span id="closeModal" class="close">&times;</span>
        </div>
        <form method="post">
            <div class="form-row">
                <div class="form-column">
                    <label for="course_code">Course Code:</label>
                    <input type="text" id="course_code" name="course_code" required>
                </div>
                <div class="form-column">
                    <label for="course_title">Course Title:</label>
                    <input type="text" id="course_title" name="course_title" required>
                </div>
                <div class="form-column">
                    <label for="category">Category:</label>
                    <input type="text" id="category" name="category" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-column">
                    <label for="l">L:</label>
                    <input type="number" id="l" name="l" required>
                </div>
                <div class="form-column">
                    <label for="t">T:</label>
                    <input type="number" id="t" name="t" required>
                </div>
                <div class="form-column">
                    <label for="p">P:</label>
                    <input type="number" id="p" name="p" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-column">
                    <label for="credit">Credit:</label>
                    <input type="number" id="credit" name="credit" readonly>
                </div>
                <div class="form-column">
                    <label for="year">Year:</label>
                    <input type="text" id="year" name="year" required>
                </div>
                <div class="form-column">
                    <label for="semester">Semester:</label>
                    <input type="text" id="semester" name="semester" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-column">
                    <label for="internal">Internal:</label>
                    <input type="number" id="internal" name="internal" required>
                </div>
                <div class="form-column">
                    <label for="external">External:</label>
                    <input type="number" id="external" name="external" required>
                </div>
                <div class="form-column">
                    <label for="total">Total:</label>
                    <input type="number" id="total" name="total" readonly>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" name="save">Save</button>
            </div>
        </form>
    </div>
</div>
<div id="editNewModal" class="modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Edit Programme Code</h2>
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
                    <label for="edit_course_title">Course Title:</label>
                    <input type="text" id="edit_course_title" name="course_title" required>
                </div>
                <div class="form-column">
                    <label for="edit_category">Category:</label>
                    <input type="text" id="edit_category" name="category" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-column">
                    <label for="edit_l">L:</label>
                    <input type="text" id="edit_l" name="l" required>
                </div>
                <div class="form-column">
                    <label for="edit_t">T:</label>
                    <input type="text" id="edit_t" name="t" required>
                </div>
                <div class="form-column">
                    <label for="edit_p">P:</label>
                    <input type="text" id="edit_p" name="p" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-column">
                    <label for="edit_credit">Credit:</label>
                    <input type="text" id="edit_credit" name="credit" readonly>
                </div>
                <div class="form-column">
                    <label for="edit_year">Year:</label>
                    <input type="text" id="edit_year" name="year" required>
                </div>
                <div class="form-column">
                    <label for="edit_semester">Semester:</label>
                    <input type="text" id="edit_semester" name="semester" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-column">
                    <label for="edit_internal">Internal:</label>
                    <input type="text" id="edit_internal" name="internal" required>
                </div>
                <div class="form-column">
                    <label for="edit_external">External:</label>
                    <input type="text" id="edit_external" name="external" required>
                </div>
                <div class="form-column">
                    <label for="edit_total">Total:</label>
                    <input type="text" id="edit_total" name="total" readonly>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" name="update">Update</button>
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
                If you delete this course code row delete all same course code tables.<br>
                Are you sure you want to delete this item?
            </div>
            <div class="modal-footer">
                <form method="POST" action="" id="deleteForm">
                    <input type="hidden" name="id" id="deleteItemId">
                    <input type="hidden" name="course_code" id="deleteItemIdRow">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="save" class="btn btn-danger" name="delete_courses">Delete</button>
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
    if (typeof DataTable !== "undefined") {
        new DataTable('#example');
    } else {
        console.warn("DataTable library is not included.");
    }
    var editNewModal = document.getElementById("editNewModal");
    var closeEditBtn = document.getElementById("closeEditModal");
    document.querySelectorAll('.editBtn').forEach(function(button) {
        button.onclick = function() {
            var id = this.getAttribute("data-id");
            var code = this.getAttribute("data-code");
            var title = this.getAttribute("data-title");
            var category = this.getAttribute("data-category");
            var l = this.getAttribute("data-l");
            var t = this.getAttribute("data-t");
            var p = this.getAttribute("data-p");
            var credit = this.getAttribute("data-credit");
            var year = this.getAttribute("data-year");
            var semester = this.getAttribute("data-semester");
            var internal = this.getAttribute("data-internal");
            var external = this.getAttribute("data-external");
            var total = this.getAttribute("data-total");
            document.getElementById("edit_id").value = id;
            document.getElementById("edit_course_code").value = code;
            document.getElementById("edit_course_title").value = title;
            document.getElementById("edit_category").value = category;
            document.getElementById("edit_l").value = l;
            document.getElementById("edit_t").value = t;
            document.getElementById("edit_p").value = p;
            document.getElementById("edit_credit").value = credit;
            document.getElementById("edit_year").value = year;
            document.getElementById("edit_semester").value = semester;
            document.getElementById("edit_internal").value = internal;
            document.getElementById("edit_external").value = external;
            document.getElementById("edit_total").value = total;
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
            selectedCode = this.getAttribute('data-code');
            console.log("Selected Item ID:", selectedItemId);
            const deleteModalElement = document.getElementById('deleteModal');
            if (deleteModalElement) {
                const deleteModal = new bootstrap.Modal(deleteModalElement);
                document.getElementById('deleteItemId').value = selectedItemId;
                document.getElementById('deleteItemIdRow').value = selectedCode;
                deleteModal.show();
            } else {
                console.error("Modal element with ID 'deleteModal' not found.");
            }
        });
    });
    const internalInput = document.getElementById("internal");
    const externalInput = document.getElementById("external");
    const totalInput = document.getElementById("total");
    const lInput = document.getElementById("l");
    const tInput = document.getElementById("t");
    const pInput = document.getElementById("p");
    const creditInput = document.getElementById("credit");
    function calculateTotal() {
        const internal = parseFloat(internalInput.value) || 0;
        const external = parseFloat(externalInput.value) || 0;
        totalInput.value = internal + external; 
    }
    function calculateCredit() {
        const l = parseFloat(lInput.value) || 0;
        const t = parseFloat(tInput.value) || 0;
        const p = parseFloat(pInput.value) || 0;
        creditInput.value = l + t + p; 
    }
    internalInput.addEventListener("input", calculateTotal);
    externalInput.addEventListener("input", calculateTotal);
    lInput.addEventListener("input", calculateCredit);
    tInput.addEventListener("input", calculateCredit);
    pInput.addEventListener("input", calculateCredit);
    function calculateEditCredit() {
        const l = parseFloat(document.getElementById('edit_l').value) || 0;
        const t = parseFloat(document.getElementById('edit_t').value) || 0;
        const p = parseFloat(document.getElementById('edit_p').value) || 0;
        const credit = l + t + p;
        document.getElementById('edit_credit').value = credit;
    }
    function calculateEditTotal() {
        const internal = parseFloat(document.getElementById('edit_internal').value) || 0;
        const external = parseFloat(document.getElementById('edit_external').value) || 0;
        const total = internal + external;
        document.getElementById('edit_total').value = total;
    }
    document.getElementById('edit_l').addEventListener('input', calculateEditCredit);
    document.getElementById('edit_t').addEventListener('input', calculateEditCredit);
    document.getElementById('edit_p').addEventListener('input', calculateEditCredit);
    document.getElementById('edit_internal').addEventListener('input', calculateEditTotal);
    document.getElementById('edit_external').addEventListener('input', calculateEditTotal);
</script>