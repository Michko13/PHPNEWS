<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/PHPNEWS/autoloader.php';

$page = 1;
if (!empty($_GET['page']) && is_numeric($_GET['page']) && !empty($_GET['currentPath'])) {
    $page = $_GET['page'];
    $articleRepository = new ArticleRepository();
    switch ($_GET['currentPath']) {
        case 'index.php':
            $articles = $articleRepository->get_articles_for_home_page($page);
            break;
        case 'articles_by_author.php':
            if(!empty($_GET['authorId'])) {
                $articles = $articleRepository->get_articles_by_author($page, $_GET['authorId']);
            } else {
                $articles = [];
            }
            break;
        case 'articles_by_category.php':
            if(!empty($_GET['categoryId'])) {
                $articles = $articleRepository->get_articles_by_category($page, $_GET['categoryId']);
            } else {
                $articles = [];
            }
            break;
        default:
            $articles = [];
            break;
    }

} else if (!isset($articles)) {
    require_once  $_SERVER['DOCUMENT_ROOT'] . '/PHPNEWS/components/header.php';
    $articles = [];
}

?>
<?php foreach ($articles as $i => $article): ?>
    <div class="article" <?php if($i === 0 && $page === 1) { echo "id='first-article'"; } ?> onclick="window.location.href='article_detail.php?id=<?= $article['article_id'] ?>'">
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