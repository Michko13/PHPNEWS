<?php
require_once 'autoloader.php';

if(!empty($_POST['article_id'])) {
    $articleRepository = new ArticleRepository();
    if($articleRepository->does_article_exist($_POST['article_id']) && isset($_POST['username']) && isset($_POST['content'])) {
        $commentRepository = new CommentRepository();
        $commentRepository->add_comment($_POST['article_id'], $_POST['username'], $_POST['content'], date(date("d. n. Y | H:i")));
    }
}

header('Location: article_detail.php?id=' . $_POST['article_id'] . '#comments');
die();
