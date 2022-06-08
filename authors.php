<?php
require_once 'components/header.php';
require_once 'autoloader.php';

$authorRepository = new AuthorRepository();
$authors = $authorRepository->get_all_authors();
?>
<body>
<?php require_once 'components/navbar.php' ?>
<div id="authors-page" class="page">
    <h1 class="page__title">Authors</h1>
    <div id="authors">
        <?php foreach ($authors as $author): ?>
            <a class="author" href="articles_by_author.php?id=<?= $author['id'] ?>">
                <img class="author__picture" src="<?= $author['picture'] ?>" />
                <div class="author__name"><?= $author['name']?> <?= $author['surname']?></div>
                <div class="author__bio"><?= $author['bio'] ?></div>
                <div class="author__article-count">Articles: <span style="font-weight: 500"><?= $author['article_count'] ?></span></div>
            </a>
        <?php endforeach; ?>
    </div>
</div>
</body>