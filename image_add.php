<?php
require_once 'autoloader.php';
AuthService::InitAuth();

$galleryRepository = new GalleryRepository();
if(!empty($_FILES['image']) && !empty($_POST['title'])) {
    $galleryRepository->save_image_to_disk($_FILES['image'], $_POST['title']);
}

header('Location: administration_gallery.php');
die();
