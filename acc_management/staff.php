<?php include '../config.php';
checkLogin();

$result = $conn->query("SELECT id, username, fullname, role FROM users");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Management</title>

    <link rel="stylesheet" href="../assets/staff.css">
</head>

<body>

    <?php include '../sidebar/sidebar.php'; ?>

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
                        <td data-label="Username"><?= $row['username'] ?></td>
                        <td data-label="Full Name"><?= $row['fullname'] ?></td>
                        <td data-label="Role"><?= ucfirst($row['role']) ?></td>
                        <td data-label="Action">
                            <button>Edit</button>
                            <button>Delete</button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</body>
</html>