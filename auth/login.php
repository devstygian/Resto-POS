<?php
include '../src/config/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepared statement
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify hashed password
        if (password_verify($password, $user['password'])) {
            $_SESSION['users'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            header("Location: ../index.php");
            exit();
        } else {
            $error = "Invalid credentials!";
        }
    } else {
        $error = "Invalid credentials!";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Admin Login</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="https://kit.fontawesome.com/f02a36f28e.js" crossorigin="anonymous"></script>
</head>

<body class="login-body">

    <div class="login-card">
        <h2 style="margin-bottom: 20px;">Admin Login</h2>

        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>

            <div style="position: relative;">
                <input type="password" id="password" name="password" placeholder="Password" required>
                <span id="togglePassword"
                    style="position:absolute; right:10px; top:35%; transform:translateY(-50%); cursor:pointer;">
                    <i class="fa-regular fa-eye"></i>
                </span>
            </div>

            <?php if (isset($error)) echo "<p style='color:red; margin-bottom:10px;'>$error</p>"; ?>

            <button type="submit">Login</button>
        </form>
    </div>

    <script>
        const toggle = document.getElementById("togglePassword");
        const password = document.getElementById("password");
        toggle.addEventListener("click", function() {
            const type = password.getAttribute("type") === "password" ? "text" : "password";
            password.setAttribute("type", type);
        });
    </script>
</body>

</html>