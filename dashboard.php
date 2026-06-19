<?php
session_start();

if(!isset($_SESSION['user'])){
header("Location:index.php");
exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Dashboard</title>
<link rel="stylesheet" href="style.css">
</head>

<body>

<div class="dashboard">

<!-- HEADER -->
<div class="header">
<h1>Lost & Found System Management</h1>
<p>System Control Panel</p>
</div>

<!-- STATUS -->
<div class="status">

<div>🟢 System Status<br><b>Online</b></div>

<div>👤 Active Users<br><b>1</b></div>

<div>📦 Reports<br><b>--</b></div>

</div>

<hr>

<h3>Admin Controls</h3>

<!-- 🔥 FIXED MENU (NO BUTTON INSIDE A TAG) -->
<div class="menu">

<a class="bigbtn b1" href="report.html">➕ Manage Reports</a>

<a class="bigbtn b2" href="view.php">🔍 View All Items</a>

<a class="bigbtn b3" href="admin.php">✔ Approve / Reject</a>

<a class="bigbtn b4" href="users.php">👥 User Control</a>

</div>

<hr>

<!-- MARQUEE -->
<div class="marquee-box">

<marquee scrollamount="4">
✔ Only admin has full control | Users can submit reports | Admin manages approvals | Real-time tracking enabled
</marquee>

</div>

<!-- FOOTER -->
<div class="footer">

<a href="logout.php" class="logout">Logout</a>

</div>

</div>

</body>
</html>