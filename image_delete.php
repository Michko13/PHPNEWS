<?php
require_once 'autoloader.php';
AuthService::InitAuth();

$galleryRepository = new GalleryRepository();
if(!empty($_GET['id']) && count(array_column($galleryRepository->image_usages($_GET['id']), 'id')) === 0) {
    $galleryRepository->delete_image($_GET['id']);
}

header('Location: administration_gallery.php');
die();
