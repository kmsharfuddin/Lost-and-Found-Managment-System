<?php
session_start();

if(!isset($_SESSION['admin']) && !isset($_SESSION['user'])){
    header("Location:admin.php");
    exit();
}

$file = "data/users.txt";

if(!file_exists($file)){
    die("users.txt file not found in data folder");
}

$lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Control</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="box" style="height: auto; min-height: 250px; max-height: 85vh; overflow-y: auto;">
    <h2>👥 Registered User List</h2>
    <div style="margin-bottom: 15px; font-size: 14px;">
        <a href="dashboard.php" style="color:#64b5f6; text-decoration:none; font-weight:bold;">🏠 Back to Dashboard</a>
    </div>
    <hr>

    <?php
    if(empty($lines)){
        echo "<p style='color:#bbb;'>No registered users found.</p>";
    } else {
        foreach($lines as $i => $line){
            $data = explode("|", trim($line));
            $username = isset($data[0]) ? trim($data[0]) : 'Unknown';
            $email    = isset($data[1]) ? trim($data[1]) : 'N/A';

            echo "<div style='background: rgba(255, 255, 255, 0.1); padding: 15px; margin: 15px 10px; border-radius: 10px; text-align: left;'>";
            echo "👤 <b>Username:</b> <span style='color:#64b5f6; font-weight:bold;'>$username</span><br>";
            echo "✉️ <b>Email:</b> $email<br>";
            echo "🟢 <b>Status:</b> <span style='color:#81c784;'>Active Member</span><br>";
            echo "<div style='text-align: right; margin-top: 5px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 5px;'>";
            echo "<a href='delete_user.php?id=$i' onclick='return confirm(\"Delete user?\")' style='color: #ff5252; text-decoration: none; font-weight: bold;'>❌ Delete User</a>";
            echo "</div></div>";
        }
    }
    ?>
</div>

</body>
</html>