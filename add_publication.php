<?php

// Check if the user is authenticated (simple example, modify as needed)
session_start();
// if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
//    header("Location: publication.php");
//     exit;
// }

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize and validate form data
    $type = htmlspecialchars(trim($_POST['type']));  ##
    $title = htmlspecialchars(trim($_POST['title']));   #2
    $authors = htmlspecialchars(trim($_POST['authors']));  #1    
    $year = htmlspecialchars(trim($_POST['year']));  #4
    $doi = htmlspecialchars(trim($_POST['doi']));  #5

    // Format data for storage
    $publication_data = "{$type},{$title},{$authors},{$year},{$doi}\n";

    // Append publication data to file with file locking
    $file = 'publications.txt';
    $file_handle = fopen($file, 'a');
    if ($file_handle) {
        // Lock the file for writing
        if (flock($file_handle, LOCK_EX)) {
            fwrite($file_handle, $publication_data);
            // Unlock the file
            flock($file_handle, LOCK_UN);
            echo "Publication added successfully.";
            header("Location: publication.php");
            exit();
        } else {
            echo "Could not lock the file for writing.";
        }
        fclose($file_handle);
    } else {
        echo "Could not open the file for writing.";
    }
} 
// else {
//     echo "Invalid request method.";
// }

?>

<!doctype html>
<html>
<head>
    <title>Add Publication</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="navbar">
        <a href='index.html'>Home</a>
        <a href='publication.php'>Publication</a>
        <a href='student.html'>Student</a>
        <a href='project.html'>Project</a>
    </div>

    <h2>Add Publication</h2>

    <form action="add_publication.php" method="post">
        <label for="type">Type:</label>
        <select id="type" name="type">
            <option value="journal">Journal</option>
            <option value="conference">Conference</option>
        </select><br><br>

        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required><br><br>

        <label for="authors">Authors:</label>
        <input type="text" id="authors" name="authors" required><br><br>

        <label for="year">Year:</label>
        <input type="number" id="year" name="year" required><br><br>

        <label for="doi">DOI:</label>
        <input type="text" id="doi" name="doi" required><br><br>

        <input type="submit" value="Add Publication">
    </form>

    <button onclick="window.location.href='publication.php'">Back to Publications</button>
</body>
</html>

