<?php
require_once 'components/header.php';
require_once 'autoloader.php';

$articleRepository = new ArticleRepository();
if (empty($_GET['id']) || !$articleRepository->does_article_exist($_GET['id'])) {
    header('Location: index.php');
    die();
}

$commentRepository = new CommentRepository();
$article = $articleRepository->get_article($_GET['id']);
$recommendedArticles = $articleRepository->get_recommended_articles($article['category_id'], 5);
$comments = $commentRepository->get_article_comments($article['article_id']);
?>
<body>
<?php require_once 'components/navbar.php' ?>
<div id="article-detail-page" class="page">
    <div id="article-detail-page__left-side">
        <div class="article-detail">
            <h1 class="article-detail__title"><?= $article['title'] ?></h1>
            <img class="article-detail__title-image"
                 src="<?= $article['title_image'] ?>">
            <div class="article-detail__info">
                <div>
                    <a class="article-detail__category"
                       href="articles_by_category.php?id=<?= $article['category_id'] ?>"><?= $article['category_name'] ?></a>
                    <div class="article-detail__date-added"><?= $article['date_added'] ?></div>
                </div>
                <a class="article-detail__author" href="articles_by_author.php?id=<?= $article['author_id'] ?>">
                    <img class="article-detail__author__picture"
                         src="<?= $article['author_picture'] ?>"/>
                    <div class="article-detail__author__name"><?= $article['author_name'] ?> <?= $article['author_surname'] ?></div>
                </a>
            </div>
            <div class="article-detail__perex"><?= $article['perex'] ?></div>
            <div class="article-detail__content"><?= $article['content'] ?></div>
        </div>
        <hr class="horizontal-line">
        <h2 class="comments-title">Komentáře (<?= count($comments) ?>)</h2>
        <div id="comments">
            <?php foreach ($comments as $comment): ?>
                <div class="comment">
                    <div class="comment__content">
                        <div class="comment__username"><?= $comment['username'] ?></div>
                        <div class="comment__content"><?= $comment['content'] ?></div>
                        <div class="comment__date_added"><?= $comment['date_added'] ?></div>
                    </div>
                    <?php if (array_key_exists('is_admin', $_SESSION)): ?>
                        <?php if ($_SESSION['is_admin'] == 1 || $article['author_id'] == $_SESSION['id']): ?>
                            <div class="comment__actions">
                                <a href="comment_delete.php?comment_id=<?= $comment['id'] ?>&article_id=<?= $article['article_id'] ?>"
                                   class="button button-danger">Odstranit</a>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
                <?php if (array_search($comment, $comments) != count($comments) - 1): ?>
                    <hr>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
        <h2 class="comments-title">Přidat komentář</h2>
        <form id="add-comment-form" action="comment_add.php" method="post">
            <input type="hidden" value="<?= $article['article_id'] ?>" name="article_id">
            <input type="text" placeholder="Jméno a příjmení" name="username" required>
            <textarea placeholder="Napište něco..." rows="10" name="content" required></textarea>
            <button class="button" type="submit">Přidat</button>
        </form>
    </div>
    <div id="article-detail-page__right-side">
        <div id="article-recommendations">
            <h4 class="article-recommendations__title">Doporučujeme</h4>
            <div class="article-recommendations__articles">
                <?php foreach ($recommendedArticles as $recommendedArticle): ?>
                    <?php if ($recommendedArticle['article_id'] != $article['article_id']): ?>
                        <a class="recommended-article"
                           href="article_detail.php?id=<?= $recommendedArticle['article_id'] ?>">
                            <img class="recommended-article__title-image"
                                 src="<?= $recommendedArticle['title_image'] ?>">
                            <h4 class="recommended-article__title"><?= $recommendedArticle['title'] ?></h4>
                        </a>
                    <?php endif ?>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="advert">
            <h4 class="advert__title">Reklama</h4>
            <a href="https://www.sssvt.cz"><img class="advert__image" src="https://i.imgur.com/g6pNCyy.png"></a>
        </div>
    </div>
</div>
</body>