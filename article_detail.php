<?php
require_once 'components/header.php';
require_once 'components/navbar.php';
require_once 'autoloader.php';

$articleRepository = new ArticleRepository();
if (empty($_GET['id']) || !$articleRepository->does_article_exist($_GET['id'])) {
    header('Location: index.php');
    die();
}

$commentRepository = new CommentRepository();
$article = $articleRepository->get_article($_GET['id']);
$comments = $commentRepository->get_article_comments($article['article_id']);
$recommendedArticles = $articleRepository->get_recommended_articles($article['category_id'], 5);
$articleRepository->add_view($_GET['id']);
?>
<body>
<div id="article-detail-page" class="page">
    <div id="article-detail-page__left-side">
        <div id="article-detail">
            <h1 id="article-detail__title"><?= $article['title'] ?></h1>
            <img id="article-detail__title-image"
                 src="<?= $article['title_image'] ?>">
            <div id="article-detail__info">
                <div>
                    <a id="article-detail__category"
                       href="articles_by_category.php?id=<?= $article['category_id'] ?>"><?= $article['category_name'] ?></a>
                    <div id="article-detail__date-added"><?= $article['date_added'] ?></div>
                </div>
                <a id="article-detail__author" href="articles_by_author.php?id=<?= $article['author_id'] ?>">
                    <img id="article-detail__author__picture"
                         src="<?= $article['author_image'] ?>"/>
                    <div id="article-detail__author__name"><?= $article['author_name'] ?> <?= $article['author_lastname'] ?></div>
                </a>
            </div>
            <div id="article-detail__perex"><?= $article['perex'] ?></div>
            <div id="article-detail__content"><?= $article['content'] ?></div>
        </div>
        <hr class="horizontal-line">
        <h2 class="comments-title">Comments (<?= count($comments) ?>)</h2>
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
                                   class="button button-danger">Delete</a>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
                <?php if (array_search($comment, $comments) != count($comments) - 1): ?>
                    <hr>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
        <h2 class="comments-title">Add comment</h2>
        <form id="add-comment-form" action="comment_add.php" method="post">
            <input type="hidden" value="<?= $article['article_id'] ?>" name="article_id">
            <input type="text" placeholder="Name" name="username" required>
            <textarea placeholder="Write something..." rows="10" name="content" required></textarea>
            <button class="button" type="submit">Add</button>
        </form>
    </div>
    <div id="article-detail-page__right-side">
        <?php if(count($recommendedArticles) > 1): ?>
        <div id="article-recommendations">
            <h4 id="article-recommendations__title">Recommended</h4>
            <div id="article-recommendations__articles">
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
        <?php endif; ?>
        <div class="advert">
            <h4 class="advert__title">Ad</h4>
            <a href="https://www.sssvt.cz"><img class="advert__image" src="https://i.imgur.com/g6pNCyy.png"></a>
        </div>
    </div>
</div>
</body>