<!DOCTYPE html>
<html lang="en">
<head>
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
        .button-logout {
            background-color: #E74C3C; /* Red color */
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 10px;
            cursor: pointer;
            text-decoration: none; /* Remove underline */
            position: absolute;
            top: 10px;
            right: 10px;
        }
    </style>
</head>
<body>
<a href="Home Page.html" class="button-logout">Logout</a>
    <Center><h1>Welcome Administrator!</h1></center>
    <form method="POST" action="">
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
        <br>
        <label for="faculty">Faculty:</label>
        <select id="faculty" name="faculty">
            <option value="">Select Faculty</option>
            <?php
            $db = new mysqli("localhost", "root", "", "public");

            if ($db->connect_error) {
                die("Connection failed: " . $db->connect_error);
            }

            $faculty_query = "SELECT name, email FROM facultyprofile";
            $faculty_result = $db->query($faculty_query);

            if ($faculty_result->num_rows > 0) {
                while ($faculty_row = $faculty_result->fetch_assoc()) {
                    $faculty_name = $faculty_row['name'];
                    $faculty_email = $faculty_row['email'];
                    echo "<option value='$faculty_email'>$faculty_name</option>";
                }
            }

            $db->close();
            ?>
        </select>
        <button type="submit" name="search">Search</button>
        <button type="submit" name="report" id="report-button">Report</button>
        <button type="button" class="button" onclick="window.location.href='allfaculty.php'">All Faculty</button>
    </form>

    <?php
    $table_name_mapping = array(
        "Research Papers" => "researchpapers",
        "Patents" => "patents",
        "Books" => "books",
        "Book Chapters" => "bookchapters",
        "Public Documents" => "publicdocuments"
    );

    function displayTableData($db, $division, $start_month, $start_year, $end_month, $end_year, $selected_faculty, $coltoremove) {
        $column_list = array();
        $table_columns_query = "SHOW COLUMNS FROM " . str_replace(" ", "_", strtolower($division));
        $columns_result = $db->query($table_columns_query);

        if ($columns_result->num_rows > 0) {
            while ($column_row = $columns_result->fetch_assoc()) {
                $column_name = $column_row['Field'];
                if ($column_name !== $coltoremove) {
                    $column_list[] = $column_name;
                }
            }
        }

        $columns_to_select = implode(", ", $column_list);
        $sql = "SELECT $columns_to_select FROM " . str_replace(" ", "_", strtolower($division)) . " WHERE dos BETWEEN '$start_year-$start_month-01' AND '$end_year-$end_month-31'";

        if (!empty($selected_faculty)) {
            $sql .= " AND email = '$selected_faculty'";
        }
        $result = $db->query($sql);

        $own_name = array_search($division, $GLOBALS['table_name_mapping']);
        echo "<h2>$own_name</h2>";

        if ($result->num_rows > 0) {
            echo "<table border=1>";
            echo "<tr>";
            
            $columns_result = $db->query("SHOW COLUMNS FROM " . str_replace(" ", "_", strtolower($division)));
            while ($column_row = $columns_result->fetch_assoc()) {
                $column_name = $column_row['Field'];
                if ($column_name !== $coltoremove) {
                    echo "<th>$column_name</th>";
                }
            }
            
            echo "</tr>";
            
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                foreach ($column_list as $column_name) {
                    echo "<td>" . $row[$column_name] . "</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No results found for $division.</p>";
        }
    }

    if (isset($_POST['search'])) {
        $start_month = $_POST['start_month'];
        $start_year = $_POST['start_year'];
        $end_month = $_POST['end_month'];
        $end_year = $_POST['end_year'];
        $selected_faculty = $_POST['faculty'];

        $db = new mysqli("localhost", "root", "", "public");

        if ($db->connect_error) {
            die("Connection failed: " . $db->connect_error);
        }

        $division_tables = array_values($table_name_mapping);

        foreach ($division_tables as $division) {
            displayTableData($db, $division, $start_month, $start_year, $end_month, $end_year, $selected_faculty, "email");
        }

        $db->close();
    }
    ?>
    <?php
if (isset($_POST['report'])) {
    $db = new mysqli("localhost", "root", "", "public");

    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }

    $selected_faculty = $_POST['faculty'];

    $division_tables = array_values($table_name_mapping);

    foreach ($division_tables as $division) {
        $sql1 = "SELECT COUNT(*) AS total FROM " . str_replace(" ", "_", strtolower($division)) . " WHERE email = '$selected_faculty'";
        $totresult = $db->query($sql1);

        if ($totresult->num_rows > 0) {
            $total_row = $totresult->fetch_assoc();
            $total_records = $total_row['total'];
            $own_name = array_search($division, $table_name_mapping);
            echo "<p>Total records submitted by faculty in $own_name: $total_records</p>";
        }
    }

    $db->close();
}
?>
</body>
</html>