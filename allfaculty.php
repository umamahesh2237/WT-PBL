<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Add your HTML head content here -->
    <meta charset="UTF-8">
    <link href="https://fonts.googleapis.com/css2?family=Playfair Display:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <title>Administrator Dashboard</title>
    <style>
        body {
            font-family: 'Playfair Display', sans-serif;
            background-color: #F5F5F5; 
        }
        table th {
            font-family: 'Playfair Display', sans-serif;
            background-color: #3498DB;
            color: white;
        }
table tr:nth-child(even) {
            font-family: 'Playfair Display', sans-serif;
            background-color: #E0E0E0; 
            color: #333; 
        }
table tr:nth-child(odd) {
            font-family: 'Playfair Display', sans-serif;
            background-color: #FFFFFF;
            color: #333; 
        }
table {
            border: 1px solid black;
        }
        .top-buttons {
            position: absolute;
            top: 10px;
            right: 10px;
        }
        .top-buttons button {
            padding: 10px 20px;
            border-radius: 10px;
            font-family: 'Playfair Display', sans-serif;
            border: none;
            cursor: pointer;
            margin-left: 10px;
        }
        #logout-button {
            background-color: #E74C3C; /* Red color for Logout button */
            color: white;
        }
        #back-button {
            background-color: #3498DB; /* Blue color for Back button */
            color: white;
        }
        </style>
</head>
<body>
<div class="top-buttons">
        <a href="Home Page.html"><button id="logout-button">Logout</button></a>
        <a href="admindashboard.php"><button id="back-button">Back</button></a>
    </div>
    <center><h1>Welcome Administrator!</h1></center>

    <form method="POST" action="">
        <label for="department">Department:</label>
        <select id="department" name="department">
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
        <br>
        <label for="start_month">Start Month:</label>
        <select id="start_month" name="start_month" required>
            <option value="01">January</option>
            <option value="02">February</option>
            <option value="03">March</option>
            <option value="04">April</option>
            <option value="05">May</option>
            <option value="06">June</option>
            <option value="07">July</option>
            <option value="08">August</option>
            <option value="09">September</option>
            <option value="10">October</option>
            <option value="11">November</option>
            <option value="12">December</option>
        </select> 
        <label for="start_year">Start Year:</label>
        <input type="text" id="start_year" name="start_year" pattern="\d{4}" required>
            <br>
        <label for="end_month">End Month:</label>
        <!-- Add the end month dropdown with options here -->
        <select id="end_month" name="end_month" required>
            <option value="01">January</option>
            <option value="02">February</option>
            <option value="03">March</option>
            <option value="04">April</option>
            <option value="05">May</option>
            <option value="06">June</option>
            <option value="07">July</option>
            <option value="08">August</option>
            <option value="09">September</option>
            <option value="10">October</option>
            <option value="11">November</option>
            <option value="12">December</option>
        </select>
        <label for="end_year">End Year:</label>
        <input type="text" id="end_year" name="end_year" pattern="\d{4}" required>

        <button type="submit" name="search">Search</button>
    </form>

    <!-- Display the results for all faculty here -->
    <?php
if (isset($_POST['search'])) {
    $selected_department = $_POST['department'];
    $start_month = $_POST['start_month'];
    $start_year = $_POST['start_year'];
    $end_month = $_POST['end_month'];
    $end_year = $_POST['end_year'];

    // Connect to the database and retrieve faculty emails for the selected department
    $db = new mysqli("localhost", "root", "", "public");
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }

    // Query to retrieve faculty emails for the selected department within the specified duration
    $faculty_query = "SELECT DISTINCT email FROM facultyprofile WHERE department = '$selected_department'";
    // Add additional conditions for date range if needed

    $faculty_result = $db->query($faculty_query);
    $faculty_emails = [];

    if ($faculty_result->num_rows > 0) {
        while ($faculty_row = $faculty_result->fetch_assoc()) {
            $faculty_emails[] = $faculty_row['email'];
        }
    }

    // Initialize variables to store table names and column names
    $table_name_mapping = array(
        "Research Papers" => "researchpapers",
        "Patents" => "patents",
        "Books" => "books",
        "Book Chapters" => "bookchapters",
        "Public Documents" => "publicdocuments"
    );

    // Initialize variables to count faculty and publications
    $unique_faculty = [];
    $total_publications_count = 0;

    // Iterate through the faculty emails and table names
    foreach ($faculty_emails as $email) {
        foreach ($table_name_mapping as $display_name => $table_name) {
            // Query each table and display the records
            $sql = "SELECT * FROM " . strtolower($table_name) . " WHERE email = '$email' AND dos BETWEEN '$start_year-$start_month-01' AND '$end_year-$end_month-31'";
            $result = $db->query($sql);

            // Increment the publications count by the number of records
            $total_publications_count += $result->num_rows;
        }

        // Add the faculty email to the unique faculty array
        $unique_faculty[] = $email;
    }

    // Get the count of unique faculty
    $unique_faculty_count = count(array_unique($unique_faculty));

    // Display the counts above the tables
    echo "<p>Total Unique Faculty: $unique_faculty_count</p>";
    echo "<p>Total Publications: $total_publications_count</p>";

    // Now, iterate again to display the records
    foreach ($faculty_emails as $email) {
        foreach ($table_name_mapping as $display_name => $table_name) {
            // Query each table and display the records
            $sql = "SELECT * FROM " . strtolower($table_name) . " WHERE email = '$email' AND dos BETWEEN '$start_year-$start_month-01' AND '$end_year-$end_month-31'";
            $result = $db->query($sql);

            // Display the table name as a heading
            echo "<h2>$display_name</h2>";

            if ($result->num_rows > 0) {
                // Display the records in a table
                echo "<table border='1'>";
                echo "<tr>";
                $columns_result = $db->query("SHOW COLUMNS FROM " . strtolower($table_name));
                while ($column_row = $columns_result->fetch_assoc()) {
                    $column_name = $column_row['Field'];
                    echo "<th>$column_name</th>";
                }
                echo "</tr>";

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    foreach ($row as $column_value) {
                        echo "<td>$column_value</td>";
                    }
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p>No results found for $display_name.</p>";
            }
        }
    }

    $db->close();
}
?>
</body>
</html>