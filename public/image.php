<?php


$source = $_GET["source"];
$radius = isset($_GET["radius"]) ? $_GET["radius"] : 10;
$colour = isset($_GET["colour"]) ? $_GET["colour"] : "FFFFFF";
$border_width = isset($_GET["border_width"]) ? $_GET["border_width"] : 8;


function imagecopymerge_alpha($dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $pct){ 
    $cut = imagecreatetruecolor($src_w, $src_h); 
    imagecopy($cut, $dst_im, 0, 0, $dst_x, $dst_y, $src_w, $src_h); 
    imagecopy($cut, $src_im, 0, 0, $src_x, $src_y, $src_w, $src_h); 
    imagecopymerge($dst_im, $cut, $dst_x, $dst_y, 0, 0, $src_w, $src_h, $pct); 
} 

list($source_width, $source_height, $source_type) = getimagesize($source);
switch ($source_type) {
    case IMAGETYPE_GIF:
        $source_image = imagecreatefromgif($source);
        break;
    case IMAGETYPE_JPEG:
        $source_image = imagecreatefromjpeg($source);
        break;
    case IMAGETYPE_PNG:
        $source_image = imagecreatefrompng($source);
        break;
}

$corner_image = imagecreatetruecolor(
    $radius,
    $radius
);

$clear_colour = imagecolorallocatealpha(
    $corner_image,
    0,
    0,
    0,
    0
);

$solid_colour = imagecolorallocate(
    $corner_image,
    hexdec(substr($colour, 0, 2)),
    hexdec(substr($colour, 2, 2)),
    hexdec(substr($colour, 4, 2))
);

imagecolortransparent(
    $corner_image,
    $clear_colour
);

imagefill(
    $corner_image,
    0,
    0,
    $solid_colour
);

imagefilledellipse(
    $corner_image,
    $radius,
    $radius,
    $radius * 2,
    $radius * 2,
    $clear_colour
);
imagecopymerge(
    $source_image,
    $corner_image,
    0,
    0,
    0,
    0,
    $radius,
    $radius,
    100
);

$corner_image = imagerotate($corner_image, 90, 0);

imagecopymerge(
    $source_image,
    $corner_image,
    0,
    $source_height - $radius,
    0,
    0,
    $radius,
    $radius,
    100
);

$corner_image = imagerotate($corner_image, 90, 0);

imagecopymerge(
    $source_image,
    $corner_image,
    $source_width - $radius,
    $source_height - $radius,
    0,
    0,
    $radius,
    $radius,
    100
);

$corner_image = imagerotate($corner_image, 90, 0);

imagecopymerge(
    $source_image,
    $corner_image,
    $source_width - $radius,
    0,
    0,
    0,
    $radius,
    $radius,
    100
);

for($i = 0; $i < 4; $i++){
    $source_image = imagerotate($source_image, 90, 0);
    imagesavealpha($source_image, true);
    $color = imagecolorallocatealpha($source_image, 0, 0, 0, 127);
    imagefill($source_image, 0, 0, $color);
}


header("Content-Type: image/png");

if(!isset($_GET["colour"])) {
    imagepng($source_image);
    imagedestroy($source_image);

    return;
}

$width = $border_width * 2 + $source_width;

$im = @imagecreate($width, $width) or die("Cannot Initialize new GD image stream");
$background_color = imagecolorallocate(
    $im, 
    hexdec(substr($colour, 0, 2)),
    hexdec(substr($colour, 2, 2)),
    hexdec(substr($colour, 4, 2))
);
$color = imagecolorallocatealpha($im, 0, 0, 0, 127);
imagefill($im, 0, 0, $color);
imagefilledellipse($im, $width / 2, $width / 2, $width - 2, $width - 2, $background_color);

imagecopymerge_alpha(
    $im,
    $source_image,
    $border_width,
    $border_width,
    0,
    0,
    $source_width,
    $source_width,
    100
);

imagepng($im);
imagedestroy($im);
imagedestroy($source_image);

return;
?>