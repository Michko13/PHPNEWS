<?php
require_once 'autoloader.php';
AuthService::InitAuth();

$categoryRepository = new CategoryRepository();
if(!empty($_GET['id']) && $categoryRepository->does_category_exist($_GET['id']) && $_SESSION['is_admin'] == 1) {
    if($categoryRepository->get_article_count_by_category($_GET['id'])['article_count'] == 0) {
        $categoryRepository->delete_category($_GET['id']);
    }
}

header('Location: administration.php#administration__categories');
die();
