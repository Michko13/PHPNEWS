<?php
require_once 'autoloader.php';
AuthService::InitAuth();

$categoryRepository = new CategoryRepository();
if(!empty($_POST['name']) && !empty($_POST['description'])) {
    $categoryRepository->add_category($_POST['name'], $_POST['description']);
}

header('Location: administration.php');
die();
