<?php
require_once 'autoloader.php';
AuthService::InitAuth();

if(!empty($_GET['comment_id']) && !empty($_GET['article_id'])) {
    $commentRepository = new CommentRepository();
    $articleRepository = new ArticleRepository();
    if($_SESSION['is_admin'] == 1 ||$articleRepository->get_article_author($_GET['article_id']) == $_SESSION['id']){
        $commentRepository->delete_comment($_GET['comment_id']);
    }
}

header('Location: article_detail.php?id=' . $_GET['article_id'] . '#comments');
die();