<?php
$upload_dir = "uploads";                 // The directory for the images to be saved in
$upload_path = $upload_dir."/";               
                        
$thumb_width = "250";                       
$thumb_height = "250";                      


function resizeThumbnailImage($thumb_image_name, $image, $width, $height, $start_width, $start_height, $scale){
    list($imagewidth, $imageheight, $imageType) = getimagesize($image);
    $imageType = image_type_to_mime_type($imageType);
    
    $newImageWidth = ceil($width * $scale);
    $newImageHeight = ceil($height * $scale);
    $newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
    switch($imageType) {
        case "image/gif":
            $source=imagecreatefromgif($image); 
            break;
        case "image/pjpeg":
        case "image/jpeg":
        case "image/jpg":
            $source=imagecreatefromjpeg($image); 
            break;
        case "image/png":
        case "image/x-png":
            $source=imagecreatefrompng($image); 
            break;
    }
    imagecopyresampled($newImage,$source,0,0,$start_width,$start_height,$newImageWidth,$newImageHeight,$width,$height);
    switch($imageType) {
        case "image/gif":
            imagegif($newImage,$thumb_image_name); 
            break;
        case "image/pjpeg":
        case "image/jpeg":
        case "image/jpg":
            imagejpeg($newImage,$thumb_image_name,100); 
            break;
        case "image/png":
        case "image/x-png":
            imagepng($newImage,$thumb_image_name);  
            break;
    }
    chmod($thumb_image_name, 0777);
    return $thumb_image_name;
}

    
$height = $_REQUEST['height'];
$width = $_REQUEST['width'];
$x = $_REQUEST['x'];
$y = $_REQUEST['y'];
//print_r($_FILES['school-logo']);

$name = $_FILES['school-logo']['name'];
$extension = substr($name, strrpos($name, '.')+1);
$imagename = time() . "." . $extension;

$original_file_location = $upload_path . $imagename;

$tmp = $_FILES['school-logo']['tmp_name'];
move_uploaded_file($tmp, $original_file_location);

$thumb_file_location = $upload_path."thumb_".$imagename;

   
$scale = $thumb_width/$width;
$cropped = resizeThumbnailImage($thumb_file_location, $original_file_location,$width,$height,$x,$y,$scale);
unlink($original_file_location);
$ex = explode("/",$cropped);
echo $ex[1];