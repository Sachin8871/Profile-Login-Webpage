<!doctype html>
<html>
<head>
    <title>Publications - XYZ</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="navbar">
        <a href='index.html'>Home</a>
        <a href='publication.php'>Publication</a>
        <a href='student.html'>Student</a>
        <a href='project.html'>Project</a>
    </div>

    <h2>Publications</h2>
    <div id="publications">

        <!-- PHP code to display publications -->
        <?php
        $file = 'publications.txt';

        if (file_exists($file)) {
            $publications = file($file, FILE_IGNORE_NEW_LINES);

            if ($publications) {
                $reversed_publications = array_reverse($publications);
                $total_publications = count($reversed_publications);

                foreach ($reversed_publications as $index => $publication) {
                    // Ensure the publication line has the correct format
                    $parts = explode(',', $publication);
                    if (count($parts) == 5) {
                        list($type, $title, $authors, $year, $doi) = $parts;

                        // Ensure the DOI is a valid URL
                        if (filter_var($doi, FILTER_VALIDATE_URL) === false) {
                            $doi = "https://doi.org/" . $doi;
                        }

                        // Calculate the serial number starting from the total number of publications
                        $serial = $total_publications - $index;

                        echo "<section>";
                        echo "<h3>{$serial}.\t{$authors}, \"{$title}\",{$type},{$year}</h3>";
                        echo "<p><strong>DOI:</strong> <a href='{$doi}' target='_blank'>{$doi}</a></p>";
                        echo "</section><br>";
                    } else {
                        echo "<section><p>Error: Invalid publication format in the file.</p></section>";
                    }
                }
            } else {
                echo "No publications found.";
            }
        } else {
            echo "Publications file not found.";
        }
        ?>
        
        <button onclick="window.location.href='add_publication.php'">Add Publications</button>

    </div>
</body>
</html>
