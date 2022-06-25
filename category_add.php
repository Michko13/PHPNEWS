<?php
require_once 'autoloader.php';
AuthService::InitAuth();

if(!empty($_POST['name']) && !empty($_POST['description']) && $_SESSION['is_admin'] == 1) {
    $categoryRepository = new CategoryRepository();
    $categoryRepository->add_category($_POST['name'], $_POST['description']);
}

header('Location: administration_categories.php');
die();
