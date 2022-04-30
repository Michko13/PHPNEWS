<?php
include_once 'components/header.php';
require_once 'autoloader.php';
AuthService::InitAuth();

if(empty($_POST['username']) || empty($_POST['name']) || empty($_POST['surname']) || empty($_POST['bio']) || !isset($_FILES['picture'])) {
    header('Location: user_profile.php');
    die();
}

$authorRepository = new AuthorRepository();
move_uploaded_file($_FILES['picture']['tmp_name'], 'X:/www/PHPNEWS/uploads/' . $_FILES['picture']['name']);
$authorRepository->edit_author($_POST['username'], $_POST['name'], $_POST['surname'], $_POST['bio'],
    strlen($_FILES['picture']['tmp_name']) > 0 ? 'uploads/' . $_FILES['picture']['name'] : $_SESSION['picture']);

header('Location: user_profile.php');
die();