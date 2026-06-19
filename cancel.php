<?php
session_start();

if(!isset($_SESSION['admin'])){
header("Location:admin.php");
exit();
}

$file="data/reports.txt";

$lines=file($file);

$id=$_GET['id'];

$data=explode("|",$lines[$id]);

$data[3]="Canceled\n";

$lines[$id]=implode("|",$data);

file_put_contents($file,implode("",$lines));

header("Location:admin.php");
exit();
?>