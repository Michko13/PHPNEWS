<?php
require_once 'components/header.php';
require_once 'autoloader.php';

$articleRepository = new ArticleRepository();
$articles = $articleRepository->get_articles_for_home_page();
$main_article = $articles[0];
?>
<body>
<?php require_once 'components/navbar.php' ?>
<?php if(!empty($main_article)): ?>
    <div id="index-page" class="page">
        <div id="main-article" onclick="window.location.href='article_detail.php?id=<?= $main_article['article_id'] ?>'">
            <div id="main-article__title-image-container">
                <img id="main-article__title-image" src="<?= $main_article["title_image"] ?>"/>
            </div>
            <div id="main-article__right-side">
                <div>
                    <div id="main-article__title"><?= $main_article['title'] ?></div>
                    <div id="main-article__perex"><?= $main_article['perex'] ?></div>
                </div>
                <div id="main-article__info">
                    <div>
                        <a id="main-article__category" href="articles_by_category.php?id=<?= $main_article['category_id']?>"><?= $main_article['category_name'] ?></a>
                        <div id="main-article_date-added"><?= $main_article['date_added'] ?></div>
                    </div>
                    <a id="main-article__author" href="articles_by_author.php?id=<?= $main_article['author_id'] ?>"><?= $main_article['author_name'] ?> <?= $main_article['author_lastname'] ?></a>
                </div>
            </div>
        </div>
        <hr class="horizontal-line">
        <div id="articles">
            <?php require_once("components/articles.php") ?>
        </div>
    </div>
    <script>
        const mainArticle = document.getElementById("main-article");
        const horizontalLines = document.getElementsByClassName("horizontal-line");
        const articles = document.getElementsByClassName("article");
        checkWindowWidth();

        window.addEventListener("resize", () => {
            checkWindowWidth();
        })

        function checkWindowWidth() {
            const breakpoint = window.innerWidth < 801;
            mainArticle.style.display = breakpoint ? "none" : "flex";
            Array.from(horizontalLines).forEach((line) => {
                line.style.display = breakpoint ? "none" : "flex";
            })
            articles[0].style.display = breakpoint ? "block" : "none";
        }
    </script>
<?php endif; ?>
</body>