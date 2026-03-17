<?php
include '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM users WHERE username='$username' AND password='$password'");
    if ($result->num_rows > 0) {
        $_SESSION['users'] = $username;
        header("Location: ../index.php");
        exit();
    } else {
        $error = "Invalid credentials!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Login</title>
<link rel="stylesheet" href="../assets/style.css">
<script src="https://kit.fontawesome.com/f02a36f28e.js" crossorigin="anonymous"></script>
</head>
<body class="login-body">

<div class="login-card">
<h2 style="margin-bottom: 20px;">Admin Login</h2>

<form method="POST">
    <input type="text" name="username" placeholder="Username" required>

    <!-- Password Field with Toggle -->
    <div style="position: relative;">
        <input type="password" id="password" name="password" placeholder="Password" required>
        <span id="togglePassword" 
              style="position:absolute; right:10px; top:35%; transform:translateY(-50%); cursor:pointer;">
              <i class="fa-regular fa-eye"></i>
        </span>
    </div>
    <?php if(isset($error)) echo "<p style='color:red; margin-bottom:10px;'>$error</p>"; ?>
    <button type="submit">Login</button>
</form>
</div>

<!-- Show Password Script -->
<script>
const toggle = document.getElementById("togglePassword");
const password = document.getElementById("password");

toggle.addEventListener("click", function () {
    const type = password.getAttribute("type") === "password" ? "text" : "password";
    password.setAttribute("type", type);
});
</script>

</body>
</html>