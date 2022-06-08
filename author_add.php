<?php
require_once 'autoloader.php';
AuthService::InitAuth();

$authorRepository = new AuthorRepository();
if (!empty($_POST['username']) && !empty($_POST['name']) && !empty($_POST['surname']) && !empty($_POST['bio']) && !empty($_FILES['picture'])
    && $_SESSION['is_admin'] == 1) {
    move_uploaded_file($_FILES['picture']['tmp_name'], 'X:/www/PHPNEWS/uploads/' . $_FILES['picture']['name']);
    $authorRepository->add_author($_POST['username'], hash("sha256", $_POST['password']), $_POST['name'],
        $_POST['surname'], $_POST['bio'], 'uploads/' . $_FILES['picture']['name']);
}

header('Location: administration_index.php');
die();
