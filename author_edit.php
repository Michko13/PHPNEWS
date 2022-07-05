<?php
require_once 'autoloader.php';
AuthService::InitAuth();

if (((!empty($_FILES['profile-image-from-upload']) && $_FILES['profile-image-from-upload']['full_path'] > 0) || !empty($_POST['profile-image-from-gallery']))
    && !empty($_POST['id']) && !empty($_POST['username']) && !empty($_POST['firstname']) && !empty($_POST['lastname']) && !empty($_POST['bio'])) {

    $imageId = $_POST['profile-image-from-gallery'];

    $galleryRepository = new GalleryRepository();
    $authorRepository = new AuthorRepository();
    if((!empty($_FILES['profile-image-from-upload']) && $_FILES['profile-image-from-upload']['full_path'] > 0)) {
        $imageId = $galleryRepository->save_image_to_disk($_FILES['profile-image-from-upload'], $_POST['username']);
    }

    $authorRepository->edit_author($_POST['id'], $_POST['username'], !empty($_POST['password']) ? hash("sha256", $_POST['password']) : null,
        $_POST['firstname'], $_POST['lastname'], $_POST['bio'], $imageId);

    if($_POST['id'] == $_SESSION['id']) {
        $_SESSION['username'] = $_POST['username'];
        $_SESSION['firstname'] = $_POST['firstname'];
        $_SESSION['lastname'] = $_POST['lastname'];
        $_SESSION['bio'] = $_POST['bio'];
        $_SESSION['profile_image'] = $galleryRepository->get_image_location_by_id($imageId);
        $_SESSION['profile_image_id'] = $imageId;
    }
}

header('Location: administration_authors.php');
die();
