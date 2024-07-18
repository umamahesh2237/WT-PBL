<!DOCTYPE html>
<html>
<head>
    <title>Sign Up - Faculty Research Profile</title>
    <link rel="stylesheet" href="style3.css">
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
        <h1 class="logo">Faculty Research Profile</h1>
        <div class="signup-box">
            <h2>Sign Up</h2>
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $name = $_POST["name"];
                $email = $_POST["email"];
                $password = $_POST["password"];
                $designation = $_POST["designation"];
                $department = $_POST["department"];
                $phone = $_POST["phone"];
                $connection = new mysqli("localhost", "root", "", "public");
                if ($connection->connect_error) {
                    die("Connection failed: " . $connection->connect_error);
                }
                $sql = "INSERT INTO facultyprofile (name, designation, department, email, phone, password) VALUES ('$name', '$designation', '$department', '$email', '$phone', '$password')";
                
                if ($connection->query($sql) === TRUE) {
                    echo "<p>Registration successful!</p>";
                } else {
                    echo "<p>Error: " . $sql . "<br>" . $connection->error . "</p>";
                }
                $connection->close();
            }
            ?>
            <form method="post">
                <div class="user-input">
                    <label for="name">Full Name:</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="user-input">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="user-input">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="user-input">
                    <label for="confirm-password">Confirm Password:</label>
                    <input type="password" id="confirm-password" name="confirm-password" required>
                </div>
                <div class="user-input">
                    <label for="designation">Designation:</label>
                    <select id="designation" name="designation" required>
                        <option value="">Select Designation</option>
                        <option value="Associate Professor">Associate Professor</option>
                        <option value="Assistant Professor">Assistant Professor</option>
                        <option value="HOD">HOD</option>
                        <option value="Dean">Dean</option>
                    </select>
                </div>
                <div class="user-input">
                    <label for="department">Department:</label>
                    <select id="department" name="department" required>
                        <option value="">Select Department</option>
                        <option value="CSE">CSE</option>
                        <option value="ECE">ECE</option>
                        <option value="EEE">EEE</option>
                        <option value="ME">ME</option>
                        <option value="CE">CE</option>
                        <option value="CSE- AIML">CSE- AIML</option>
                        <option value="CSE- IoT">CSE- IoT</option>
                        <option value="CSE- DS">CSE- DS</option>
                        <option value="CSE- CS">CSE- CS</option>
                        <option value="MBA">MBA</option>
                        <option value="IT">IT</option>
                    </select>
                </div>
                <div class="user-input">
                    <label for="phone">Phone No:</label>
                    <input type="tel" id="phone" name="phone" required>
                </div>
                <button type="submit">Sign Up</button>
            </form>
            <p class="login-link">Already have an account? <a href="Login.php">Login here</a></p>
        </div>
    </div>
</body>
</html>
