<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Read users file
    $file_path = 'users.txt';
    $file_contents = file($file_path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $users = [];
    $isMatched = false;
    
    foreach ($file_contents as $line) {
        // Split the line by comma
        $parts = explode(',', trim($line));
        
        // Ensure we have exactly three parts
        if (count($parts) === 3) {
            list($savedUserName, $savedPassword, $firstLoginFlag) = $parts;
            $users[$savedUserName] = ['password' => $savedPassword, 'flag' => $firstLoginFlag];
        }
    }
    
    if (!isset($users[$username])) {
        // User does not exist; display an error
        echo "Username does not exist.";
    } else {
        // User exists; check credentials
        if (password_verify($password, $users[$username]['password'])) {
            $isMatched = true;
            $firstLoginFlag = $users[$username]['flag'];
            
            if ($firstLoginFlag == '1') {
                // Redirect to change password page if it's the first login
                header('Location: change_password.php');
                exit();
            } else {
                // Redirect to profile edit page if it's not the first login
                header('Location: editprofile.php');
                exit();
            }
        } else {
            echo "Incorrect username or password.<br>";
        }
    }
}
?>

<!doctype html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main style="text-align: center;">
        <h2>Login</h2>
        <form action="login.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br><br>

            <input type="submit" value="Login">
        </form>

        <br>
        <button style="width: 150px;" onclick="window.location.href='change_password.php'">Change Password</button>
    </main>
</body>
</html>
