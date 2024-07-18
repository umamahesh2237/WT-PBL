<?php
session_start();

if (!isset($_SESSION['faculty_email'])) {
    exit("Unauthorized access. Please log in first.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $chapter_title = $_POST["chapter_title"];
    $chapter_text = $_POST["chapter_text"];
    $book_name = $_POST["book_name"];
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
    $sql = "INSERT INTO bookchapters (title, text, bookname, dos, email)
            VALUES ('$chapter_title', '$chapter_text', '$book_name', '$date', '$faculty_email')";

    if ($conn->query($sql) === TRUE) {
        // Data inserted successfully
        $message = "Book chapter submission data stored successfully!";
    } else {
        $message = "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
$faculty_email = $_SESSION['faculty_email'];
?>

<html>
<head>
    <title>Book Chapter Submission</title>
    <link rel="stylesheet" href="style1.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair Display:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Playfair Display', sans-serif;
            margin: 20px;
            background-image: url('https://c4.wallpaperflare.com/wallpaper/874/51/691/blur-book-chapter-close-up-wallpaper-preview.jpg');
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
    <h1>Book Chapter Submission</h1>
    <a href="Main UI.php" class="back-button">Back</a>
    <form method="post" action="bookchapters.php">
        <label for="chapter_title"><b>Chapter Title:</b></label>
        <input type="text" id="chapter_title" name="chapter_title" required>
        <br><br><br>
        <label for="chapter_text"><b>Chapter Text:</b></label>
        <textarea id="chapter_text" name="chapter_text" required></textarea>
        <br><br><br>
        <label for="book_name"><b>Book Name:</b></label>
        <input type="text" id="book_name" name="book_name" required>
        <br><br><br>
        <label for="date"><b>Date of Publication (YYYY-MM-DD):</b></label>
        <input type="date" id="date" name="date" required>
        <br><br><br>
        <input type="submit" value="Submit">
    </form>
</body>
</html>
