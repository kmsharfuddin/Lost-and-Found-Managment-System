<?php

$file="data/users.txt";

$user=$_POST['username'];
$email=$_POST['email'];
$pass=$_POST['password'];

$data=$user."|".$email."|".$pass.PHP_EOL;

file_put_contents($file,$data,FILE_APPEND);

header("Location:index.php");
exit();
?>