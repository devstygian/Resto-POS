<?php
include '../config/config.php';
checkLogin();

$result = $conn->query("SELECT id, username, fullname, role FROM users");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Management</title>
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/sidebar.css">
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/staff.css">
    <link rel="stylesheet" href="<?= $base_url ?>assets/icon/css/all.min.css">
</head>

<body>

    <?php include '../include/sidebar.php'; ?>

    <div class="content">
        <h1>Staff Management</h1>

        <!-- ADD ACCOUNT -->
        <div class="add-box">
            <h3>Register a new staff member</h3>

            <form action="register.php" method="POST">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="text" name="fullname" placeholder="Full Name" required>

                <select name="role">
                    <option value="staff">Staff</option>
                    <option value="admin">Admin</option>
                </select>

                <button type="submit">Add</button>
            </form>
        </div>

        <!-- TABLE -->
        <table>
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Full Name</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td data-label="Username"><?= htmlspecialchars($row['username']) ?></td>
                        <td data-label="Full Name"><?= htmlspecialchars($row['fullname']) ?></td>
                        <td data-label="Role"><?= ucfirst($row['role']) ?></td>
                        <td data-label="Action">

                            <!-- EDIT -->
                            <button onclick="openEditModal( <?= $row['id'] ?>,
                            '<?= htmlspecialchars($row['username'], ENT_QUOTES) ?>',
                            '<?= htmlspecialchars($row['fullname'], ENT_QUOTES) ?>',
                            '<?= $row['role'] ?>'
                        )">Edit</button>

                            <!-- DELETE -->
                            <a href="del_acc.php?id=<?= $row['id'] ?>"
                                onclick="return confirm('Delete this user?')"
                                class="btn-delete">
                                Delete
                            </a>

                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- EDIT MODAL -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <h2>Edit Staff</h2>

            <form action="update_acc.php" method="POST">
                <input type="hidden" name="id" id="edit_id">

                username
                <input type="text" id="edit_username" readonly>

                full name
                <input type="text" name="fullname" id="edit_fullname" required>

                Password
                <input type="password" name="password" placeholder="Leave blank to keep current">

                Position
                <select name="role" id="edit_role">
                    <option value="staff">Staff</option>
                    <option value="admin">Admin</option>
                </select>

                <div class="modal-actions">
                    <button type="submit">Update</button>
                    <button type="button" onclick="closeModal()">Cancel</button>
                </div>
            </form>
        </div>
    </div>


    <!-- SCRIPT -->
    <script>
        function openEditModal(id, username, fullname, role) {
            const modal = document.getElementById("editModal");
            modal.style.display = "flex";

            document.getElementById("edit_id").value = id;
            document.getElementById("edit_username").value = username;
            document.getElementById("edit_fullname").value = fullname;
            document.getElementById("edit_role").value = role;
        }

        function closeModal() {
            document.getElementById("editModal").style.display = "none";
        }

        // Close when clicking outside
        window.onclick = function(e) {
            const modal = document.getElementById("editModal");
            if (e.target === modal) {
                closeModal();
            }
        }

        // ESC key support
        document.addEventListener("keydown", function(e) {
            if (e.key === "Escape") {
                closeModal();
            }
        });
    </script>

</body>

</html>