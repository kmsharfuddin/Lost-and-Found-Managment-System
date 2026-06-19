<?php

$file="data/users.txt";
$id=$_GET['id'];

$lines=file($file);

unset($lines[$id]);

file_put_contents($file,implode("",$lines));

header("Location:users.php");
exit();

?>