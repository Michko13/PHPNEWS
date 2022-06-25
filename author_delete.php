<?php
require_once 'autoloader.php';
AuthService::InitAuth();

$authorRepository = new AuthorRepository();
if (!empty($_GET['id']) && $authorRepository->does_author_exist($_GET['id']) &&
    !$authorRepository->does_author_have_any_articles($_GET['id']) && $_SESSION['is_admin'] == 1) {
    $authorRepository->delete_author($_GET['id']);
}

header('Location: administration_authors.php');
die();
