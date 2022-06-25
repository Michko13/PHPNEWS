<?php
require_once 'autoloader.php';
AuthService::InitAuth();


if (!empty($_GET['id'])) {
    $galleryRepository = new GalleryRepository();
    if (count(array_column($galleryRepository->image_author_usages($_GET['id']), 'id')) === 0 &&
        count(array_column($galleryRepository->image_article_usages($_GET['id']), 'id')) === 0) {
        $galleryRepository->delete_image($_GET['id']);
    }
}

header('Location: administration_gallery.php');
die();
