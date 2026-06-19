<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="style.css">
<title>Lost & Found</title>
</head>

<body>

<div class="box">

<h1>Lost & Found System</h1>

<!-- LOGIN -->
<h3>Login</h3>

<form action="login.php" method="POST">

<input type="text" name="username" value="sayedjr113488" placeholder="Username" required><br>

<input type="password" name="password" value="jonayedjr113488" placeholder="Password" required><br>

<button type="submit" name="login">Login</button>

</form>

<hr>

<!-- REGISTER -->
<h3>Register</h3>

<form action="register.php" method="POST">

<input type="text" name="username" placeholder="Username" required><br>

<input type="email" name="email" placeholder="Email" required><br>

<input type="password" name="password" placeholder="Password" required><br>

<button type="submit" name="register">Register</button>

</form>

</div>

</body>
</html>