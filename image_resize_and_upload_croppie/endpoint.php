<?php
// Do something with the gif image
$file = $_FILES['image']['tmp_name'];

$path = 'uploads/'; // upload directory
$img = $_FILES['image']['name'];
$tmp = $_FILES['image']['tmp_name'];
// $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
$final_image = 'Profile_' . time()  . '.png';
$path = $path . strtolower($final_image);
move_uploaded_file($tmp, $path);
exit(0);