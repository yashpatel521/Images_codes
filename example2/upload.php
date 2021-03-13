<?php
// Do something with the gif image
$file = $_FILES['image']['tmp_name'];
$path = 'uploads/'; // upload directory
$img = $_FILES['image']['name'];
$tmp = $_FILES['image']['tmp_name'];

$ext = get_extension($img);
function get_extension($exten)
{
	$extension = explode(".", $exten);
	return ($extension == '') ? $extension : '.jpeg';
}
$final_image = 'Profile_' . time()  . $ext;
$path = $path . strtolower($final_image);
move_uploaded_file($tmp, $path);
echo '<img src="' . $path . '" style="border-radius:50%" class="img-thumbnail" />';
exit(0);