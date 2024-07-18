<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $connection = new mysqli("localhost", "root", "", "public");
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }
    $sql = "SELECT * FROM facultyprofile WHERE email='$email' AND password='$password'";
    $result = $connection->query($sql);

    if ($result->num_rows == 1) {
        $_SESSION['faculty_email'] = $email;
        $connection->close();
        header("Location: Main UI.php");
        exit();
    } else {

        echo "<p>Login failed. Please check your credentials and try again.</p>";
    }
    $connection->close();
}
?>
<html>
<head>
    <title>Login - Faculty Research Profile</title>
    <link rel="stylesheet" href="style2.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
            background-size: 100% 100%;
            background-attachment: fixed;
            background-image: url('https://static.wixstatic.com/media/374af4_109658a2fd704dd9aff04dd7bc34c901~mv2.jpg/v1/fill/w_448,h_368,al_c,q_80,usm_0.66_1.00_0.01,enc_auto/374af4_109658a2fd704dd9aff04dd7bc34c901~mv2.jpg');
        }
        </style>
</head>
<body>
    <div class="container">
        <h1 class="logo">FACULTY RESEARCH PROFILE</h1>
        <div class="login-box">
            <h2>Login</h2>
            <form method="post">
                <div class="user-input">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="user-input">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit">Login</button>
            </form>
            <p class="signup-link">Don't have an account? <a href="SignUp.php">Sign up here</a></p>
        </div>
    </div>
</body>
</html>
