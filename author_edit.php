<?php
require_once 'autoloader.php';
AuthService::InitAuth();

if (((!empty($_FILES['profile-image-from-upload']) && $_FILES['profile-image-from-upload']['full_path'] > 0) || !empty($_POST['profile-image-from-gallery']))
    && !empty($_POST['id']) && !empty($_POST['username']) && !empty($_POST['firstname']) && !empty($_POST['lastname']) && !empty($_POST['bio'])) {

    $imageId = $_POST['profile-image-from-gallery'];

    $authorRepository = new AuthorRepository();
    if((!empty($_FILES['profile-image-from-upload']) && $_FILES['profile-image-from-upload']['full_path'] > 0)) {
        $galleryRepository = new GalleryRepository();
        $imageId = $galleryRepository->save_image_to_disk($_FILES['profile-image-from-upload'], $_POST['username']);
    }

    $authorRepository->edit_author($_POST['id'], $_POST['username'], !empty($_POST['password']) ? hash("sha256", $_POST['password']) : null,
        $_POST['firstname'], $_POST['lastname'], $_POST['bio'], $imageId);
}

header('Location: administration_authors.php');
die();
