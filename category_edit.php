<?php
include_once 'components/header.php';
require_once 'autoloader.php';
AuthService::InitAuth();

$categoryRepository = new CategoryRepository();
if(!empty($_POST['id']) && $categoryRepository->does_category_exist($_POST['id']) && !empty($_POST['name']) && !empty($_POST['description'])
    && $_SESSION['is_admin'] == 1) {
    $categoryRepository->edit_category($_POST['id'], $_POST['name'], $_POST['description']);
}

header('Location: administration.php#administration__articles');
die();
