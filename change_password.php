<?php
// Function to validate password strength
function isValidPassword($password) {
    return preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).{8,}$/', $password);
}


// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'];
    $old_password = $_POST['old-password'];
    $new_password = $_POST['new-password'];
    $confirm_password = $_POST['confirm-password'];

    // Validate new password strength
    if (!isValidPassword($new_password)) {
        echo "<script>alert('New password must be at least 8 characters long, include at least one uppercase letter, one lowercase letter, one number, and one special character.');</script>";
    } elseif ($new_password !== $confirm_password) {
        echo "<script>alert('New password and confirm password do not match');</script>";
    } else {
        // Match the username and password
        $file = fopen("users.txt", "r");
        if ($file) {
            $isMatched = false;
            $fileContents = [];

            // Read the file line by line
            while (($line = fgets($file)) !== false) {
                // Remove any extraneous whitespace or newline characters
                $line = trim($line);

                // Split the line by ","
                list($savedUserName, $savedPassword) = explode(',', $line);

                // Compare the username and verify the old password
                if ($savedUserName === $username && password_verify($old_password, $savedPassword)) {
                    $isMatched = true;
                    // Update the password with the new hashed password
                    $savedPassword = password_hash($new_password, PASSWORD_BCRYPT);
                }

                // Save the line (updated if necessary) to the array
                $fileContents[] = "$savedUserName,$savedPassword,0";
            }

            // Close the file
            fclose($file);

            // If the old password was matched
            if ($isMatched) {
                // Write the updated contents back to the file
                $file = fopen("users.txt", "w");
                if ($file) {
                    foreach ($fileContents as $line) {
                        fwrite($file, "$line\n");
                    }
                    fclose($file);
                    // Redirect to the profile edit page
                    header('Location: editprofile.php');
                    exit();
                } else {
                    echo "<script>alert('Could not open the file for writing');</script>";
                }
            } else {
                echo "<script>alert('Incorrect username or password');</script>";
            }
        } else {
            echo "<script>alert('Could not open the users file');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
</head>
<body>
    <h2>Change Password</h2>
    <form action="change_password.php" method="POST">
        <label for="username">User Name:</label><br>
        <input type="text" id="username" name="username" required><br><br>

        <label for="old-password">Old Password:</label><br>
        <input type="password" id="old-password" name="old-password" required><br><br>

        <label for="new-password">New Password:</label><br>
        <input type="password" id="new-password" name="new-password" required><br><br>

        <label for="confirm-password">Confirm New Password:</label><br>
        <input type="password" id="confirm-password" name="confirm-password" required><br><br>

        <input type="submit" value="Change Password">
    </form>
</body>
</html>
