<?php
session_start();

if (!isset($_SESSION['faculty_email'])) {
    exit("Unauthorized access. Please log in first.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $authors = $_POST["authors"];
    $abstract = $_POST["abstract"];
    $keywords = $_POST["keywords"];
    $date = $_POST["date"];
    $faculty_email = $_SESSION['faculty_email'];
    $servername="localhost";
    $username = "root";
    $password = "";
    $dbname = "public";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "INSERT INTO researchpapers (title, author, abstract, keywords, dos, email)
            VALUES ('$title', '$authors', '$abstract', '$keywords', '$date', '$faculty_email')";

    if ($conn->query($sql) === TRUE) {
        // Data inserted successfully
        $message = "Research paper submission data stored successfully!";
    } else {
        // Error occurred while inserting data
        $message = "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Research Paper Submission</title>
    <link rel="stylesheet" href="style1.css">
    <style>
body {
            font-family: 'Playfair Display', sans-serif;
            margin: 20px;
            background-image: url('https://images.pexels.com/photos/433333/pexels-photo-433333.jpeg?cs=srgb&dl=pexels-pixabay-433333.jpg&fm=jpg');
            background-size: 100% 100%;
            background-attachment: fixed;
        }
        
        form {
            max-width: 400px;
            margin: 0 auto;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
        }
        
        input[type="text"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 20px;
            box-sizing: border-box;
        }
        
        input[type="submit"] {
            font-family: 'Playfair Display', sans-serif;
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        
        h1 {
            text-align: center;
        }
        .back-button {
    position: absolute;
    top: 10px;
    right: 10px;
    background-color: red;
    color: white;
    border: none;
    border-radius: 4px;
    padding: 10px 20px;
    cursor: pointer;
}
.back-button:hover {
    background-color: #333333;
}
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Playfair Display:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <h1><font color="white">Research Paper Submission</font></h1>
    <a href="Main UI.php" class="back-button">Back</a>
    <form method="post" action="researchsub.php">
    <br>
        <label for="title"><b>Title:</b></label>
        <input type="text" id="title" name="title" required>
        <br><br>
        <label for="authors"><b>Authors:</b></label>
        <input type="text" id="authors" name="authors" required>
        <br><br><br>
        <label for="abstract"><b>Abstract:</b></label>
        <textarea id="abstract" name="abstract" required></textarea>
        <br><br><br>
        <label for="keywords"><b>Keywords:</b></label>
        <input type="text" id="keywords" name="keywords">
        <br><br><br>
        <label for="date"><b>Date of Publication (YYYY-MM-DD):</b></label>
        <input type="date" id="date" name="date" required>
        <br><br><br>
        <input type="submit" value="Submit">
    </form>
    <script>
        <?php if (isset($message)) { ?>
            alert("<?php echo $message; ?>");
        <?php } ?>
    </script>
</body>
</html>
