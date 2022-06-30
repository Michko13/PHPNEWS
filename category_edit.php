<?php
require_once 'autoloader.php';
AuthService::InitAuth();

if(!empty($_POST['id']) && $_SESSION['is_admin'] == 1) {
    $categoryRepository = new CategoryRepository();
    if($categoryRepository->does_category_exist($_POST['id']) && !empty($_POST['name']) && !empty($_POST['description'])) {
        $categoryRepository->edit_category($_POST['id'], $_POST['name'], $_POST['description']);
    }
}

header('Location: administration_categories.php');
die();
