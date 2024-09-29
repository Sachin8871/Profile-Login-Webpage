<?php
// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// Simulate fetching user data from a database
// Replace this with actual data fetching from a database
$user_data = [
    'name' => 'John Doe',
];

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Update user data based on form submission
    // In a real application, update the database instead
    $new_name = $_POST['name'];
    $user_data['name'] = $new_name;

    // Feedback message
    $message = "Profile updated successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Simple CSS for modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }
        .close-button {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close-button:hover,
        .close-button:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="profile">
        <h2>User Profile</h2>
        <p id="profile-info">Name: <?php echo htmlspecialchars($user_data['name']); ?></p>
        <button id="edit-profile-button" onclick="document.getElementById('edit-profile-modal').style.display='block'">Edit Profile</button>
    </div>

    <!-- Edit Profile Modal -->
    <div id="edit-profile-modal" class="modal">
        <div class="modal-content">
            <span class="close-button" onclick="document.getElementById('edit-profile-modal').style.display='none'">&times;</span>
            <h2>Edit Profile</h2>
            <?php if (isset($message)): ?>
                <p><?php echo htmlspecialchars($message); ?></p>
            <?php endif; ?>
            <form id="edit-profile-form" method="POST" action="editprofile.php">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user_data['name']); ?>">
                <button type="submit">Save</button>
            </form>
        </div>
    </div>

    <script>
        // Add JavaScript for modal functionality
        var modal = document.getElementById('edit-profile-modal');
        var span = document.getElementsByClassName('close-button')[0];

        span.onclick = function() {
            modal.style.display = 'none';
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
    </script>
</body>
</html>
