<?php
session_start();
// Checking for email in session
if (isset($_SESSION['faculty_email'])) {
    // Getting email from the session
    $loggedInFacultyEmail = $_SESSION['faculty_email'];

    $connection = new mysqli("localhost", "root", "", "public");
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    $sql = "SELECT name, designation, department, phone FROM facultyprofile WHERE email='$loggedInFacultyEmail'";
    $result = $connection->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $name = $row['name'];
            $designation = $row['designation'];
            $department = $row['department'];
            $phone = $row['phone'];
            ?>
            <!DOCTYPE html>
            <html>
            <head>
                <title>Faculty Research Profile</title>
                <link rel="stylesheet" href="style1.css">
                <link href="https://fonts.googleapis.com/css2?family=Playfair Display:wght@300;400;500;600;700&display=swap" rel="stylesheet">
                <style> 
                body {
            font-family: 'Playfair Display', sans-serif;
            background-image: url('https://static.wixstatic.com/media/374af4_109658a2fd704dd9aff04dd7bc34c901~mv2.jpg/v1/fill/w_448,h_368,al_c,q_80,usm_0.66_1.00_0.01,enc_auto/374af4_109658a2fd704dd9aff04dd7bc34c901~mv2.jpg');
            background-size: 100% 100%;
            background-attachment: fixed;
                } 
                nav ul {
        margin: 20px 0;
    }

    nav li {
        display: inline-block;
        margin-right: 15px;
    }

    nav li:last-child {
        margin-right: 0;
    }

    nav a {
        text-decoration: none;
        color: #333;
        font-weight: bold;
    }

    nav a:hover {
        color: #4CAF50;
    }

    .logout-button {
        float: right;
    }
                </style>
            </head>
            <body>
                <header>
                    <h1>Faculty Research Profile</h1>
                    <nav>
                        <center>
                        <ul>
                            <li><a href="researchsub.php">Research Papers</a></li>
                            <li><a href="patentsub.php">Patents</a></li>
                            <li><a href="books.php">Books</a></li>
                            <li><a href="bookchapters.php">Book Chapters</a></li>
                            <li><a href="publicdocuments.php">Public Documents</a></li>
                        </ul>
                        </center>
                    </nav>
                    <div class="logout-button">
                    <a href="Home Page.html">Logout</a>
                    </div>
                </header>
                <div class="container">
                    <h2>Welcome <?php echo $name; ?>! </h2>
                    <div class="profile">
                        <form>
                            <label for="name"><b>Name:</b></label>
                            <input type="text" id="name" name="name" value="<?php echo $name; ?>" readonly>
                            <label for="designation"><b>Designation:</b></label>
                            <input type="text" id="designation" name="designation" value="<?php echo $designation; ?>" readonly>
                            <label for="department"><b>Department:</b></label>
                            <input type="text" id="department" name="department" value="<?php echo $department; ?>" readonly>
                            <label for="email"><b>Email:</b></label>
                            <input type="email" id="email" name="email" value="<?php echo $loggedInFacultyEmail; ?>" readonly>
                            <label for="phone"><b>Phone:</b></label>
                            <input type="tel" id="phone" name="phone" value="<?php echo $phone; ?>" readonly>
                        </form>
                    </div>
                </div>
            </body>
            </html>

            <?php
        }
    } else {
        echo "No faculty details found.";
    }
    $connection->close();
} else {

    header("Location: Login.php");
    exit();
}
?>
