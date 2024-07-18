<?php
session_start();
if (!isset($_SESSION['faculty_email'])) {
    exit("Unauthorized access. Please log in first.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $inventors = $_POST["inventors"];
    $abstract = $_POST["abstract"];
    $keywords = $_POST["keywords"];
    $date = $_POST["date"];
    $faculty_email = $_SESSION['faculty_email'];
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "public";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "INSERT INTO patents (title, inventors, abstract, keywords, dos, email)
            VALUES ('$title', '$inventors', '$abstract', '$keywords', '$date', '$faculty_email')";

    if ($conn->query($sql) === TRUE) {

        $message = "Patent submission data stored successfully!";
    } else {
        $message = "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
}
$faculty_email = $_SESSION['faculty_email'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Patent Submission</title>
    <link rel="stylesheet" href="style1.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair Display:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Playfair Display', sans-serif;
            margin: 20px;
            background-image: url('https://lawcirca.com/wp-content/uploads/2020/07/12.jpg');
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
    <script>
        <?php if (isset($message)) { ?>
        alert("<?php echo $message; ?>");
        <?php } ?>
    </script>
</head>
<body>
    <h1>Patent Submission</h1>
    <a href="Main UI.php" class="back-button">Back</a>
    <form method="post" action="patentsub.php">
        <label for="title"><b>Title:</b></label>
        <input type="text" id="title" name="title" required>
        <br><br><br>
        <label for="inventors"><b>Inventors:</b></label>
        <input type="text" id="inventors" name="inventors" required>
        <br><br><br>
        <label for="abstract"><b>Abstract:<b></label>
        <textarea id="abstract" name="abstract" required></textarea>
        <br><br><br>
        <label for="keywords"><b>Keywords:</b></label>
        <input type="text" id="keywords" name="keywords" required>
        <br><br><br>
        <label for="date"><b>Date of Publication (YYYY-MM-DD):</b></label>
        <input type="date" id="date" name="date" required>
        <br><br><br>
        <input type="submit" value="Submit">
    </form>
</body>
</html>
