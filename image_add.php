<?php
require_once 'autoloader.php';
AuthService::InitAuth();

$galleryRepository = new GalleryRepository();
if(!empty($_FILES['image']) && !empty($_POST['title'])) {
    $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $randomName = bin2hex(random_bytes(8)) . ".jpg";

    if($extension == 'png') {
        $image = imagecreatefrompng($_FILES['image']['tmp_name']);
        $bg = imagecreatetruecolor(imagesx($image), imagesy($image));
        imagefill($bg, 0, 0, imagecolorallocate($bg, 255, 255, 255));
        imagealphablending($bg, TRUE);
        imagecopy($bg, $image, 0, 0, 0, 0, imagesx($image), imagesy($image));
        imagedestroy($image);
        $quality = 100; // 0 = worst / smaller file, 100 = better / bigger file
        imagejpeg($bg, 'C:\xampp\htdocs\PHPNEWS\uploads\\' . $randomName, $quality);
        imagedestroy($bg);
    } else {
        move_uploaded_file($_FILES['image']['tmp_name'], 'C:\xampp\htdocs\PHPNEWS\uploads\\' . $randomName);
    }

    $galleryRepository->add_image($_POST['title'], 'uploads/' . $randomName);
}

header('Location: administration_gallery.php');
die();
