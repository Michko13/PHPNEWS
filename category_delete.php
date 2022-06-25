<?php
require_once 'autoloader.php';
AuthService::InitAuth();

if(!empty($_GET['id']) && $_SESSION['is_admin'] == 1) {
    $categoryRepository = new CategoryRepository();
    if($categoryRepository->does_category_exist($_GET['id']) && $categoryRepository->get_article_count_by_category($_GET['id'])['article_count'] == 0) {
        $categoryRepository->delete_category($_GET['id']);
    }
}

header('Location: administration_categories.php');
die();
