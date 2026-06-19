<?php

if($_SERVER["REQUEST_METHOD"]=="POST"){

$type=$_POST['report_type'];
$title=$_POST['title'];
$category=$_POST['category'];
$time=$_POST['occurrence_time'];
$location=$_POST['location'];
$desc=$_POST['description'];

$name=$_POST['contact_name'];
$phone=$_POST['phone'];
$email=$_POST['email'] ?? "";

$status="Pending";

/* ================= IMAGE UPLOAD ================= */

$imageName="";

if(isset($_FILES['item_image']) && $_FILES['item_image']['name']!=""){

if(!file_exists("uploads")){
mkdir("uploads");
}

$imageName=time()."_".$_FILES['item_image']['name'];

move_uploaded_file(
$_FILES['item_image']['tmp_name'],
"uploads/".$imageName
);
}

/* ================= SAVE ================= */

if(!file_exists("data")){
mkdir("data");
}

$file="data/reports.txt";

/*
DATA FORMAT
0 type
1 title
2 category
3 time
4 location
5 description
6 name
7 phone
8 email
9 image
10 status
*/

$data=$type."|".
$title."|".
$category."|".
$time."|".
$location."|".
$desc."|".
$name."|".
$phone."|".
$email."|".
$imageName."|".
$status."\n";

file_put_contents($file,$data,FILE_APPEND);

header("Location:view.php");
exit();
}
?>