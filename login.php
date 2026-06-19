<?php
session_start();

/* FIX: prevent output issue */
ob_start();

$user = $_POST['username'];
$pass = $_POST['password'];

$fixed_user = "sayedjr113488";
$fixed_pass = "jonayedjr113488";

if($user === $fixed_user && $pass === $fixed_pass){

$_SESSION['user'] = $user;

/* IMPORTANT: clean redirect */
header("Location: dashboard.php");
exit();

}else{
echo "Login Failed ❌";
}

ob_end_flush();
?>