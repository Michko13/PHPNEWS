<?php
require_once 'autoloader.php';
AuthService::InitAuth();

$articleRepository = new ArticleRepository();
if(!empty($_GET['id']) && $articleRepository->does_article_exist($_GET['id']) &&
    ($_SESSION['is_admin'] == 1 || $articleRepository->get_article_author($_GET['id']) == $_SESSION['id'])) {
    $articleRepository->delete_article($_GET['id']);
}

header('Location: administration.php');
die();
