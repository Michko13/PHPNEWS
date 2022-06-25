<?php
require_once 'components/header.php';

if(!isset($articles)) {
    $articles = [];
}
?>
<?php foreach ($articles as $article): ?>
    <div class="article" onclick="window.location.href='article_detail.php?id=<?= $article['article_id'] ?>'">
        <div class="article__header">
            <img class="article__header__title-image" src="<?= $article['title_image'] ?>"
                 onclick="window.location.href='article_detail.php?id=<?= $article['article_id'] ?>'"/>
            <div style="position: relative">
                <a class="article__header__title" href="article_detail.php?id=<?= $article['article_id'] ?>"><?= $article['title'] ?> </a>
                <div class="article__header__info">
                    <div>
                        <a class="article__header__category" href="articles_by_category.php?id=<?= $article['category_id']?>"><?= $article['category_name'] ?></a>
                        <div class="article__header__date-added"><?= $article['date_added'] ?></div>
                    </div>
                    <a class="article__header__author" href="articles_by_author.php?id=<?= $article['author_id'] ?>"><?= $article['author_name'] ?> <?= $article['author_lastname'] ?></a>
                </div>
            </div>
        </div>
        <div class="article__perex"><?= $article['perex'] ?></div>
    </div>
<?php endforeach; ?>