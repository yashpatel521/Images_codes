<?php
// Do something with the gif image
$file = $_FILES['image']['tmp_name'];

$path = 'uploads/'; // upload directory
$img = $_FILES['image']['name'];
$tmp = $_FILES['image']['tmp_name'];
function get_extension($file)
{
    $extension = end(explode(".", $file));
    return $extension ? $extension : false;
}
$ext = get_extension($img);
if ($ext) {
    $ext = '.jpeg';
}
$final_image = 'Profile_' . time()  . $ext;
$path = $path . strtolower($final_image);
move_uploaded_file($tmp, $path);
exit(0);