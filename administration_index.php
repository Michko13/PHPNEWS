<?php
require_once 'components/header.php';
require_once 'components/navbar.php';
require_once 'autoloader.php';
AuthService::InitAuth();

$articleRepository = new ArticleRepository();
$articles = $articleRepository->get_articles_for_administration();
?>
<body>
<div id="administration-page" class="page">
    <h1 class="page__title">Administration</h1>
    <div id="administration__subpages">
        <a class="button-text button-text-selected" href="administration_index.php">ARTICLES</a>
        <a class="button-text" href="administration_categories.php">CATEGORIES</a>
        <a class="button-text" href="administration_authors.php">AUTHORS</a>
        <a class="button-text" href="administration_gallery.php">GALLERY</a>
        <a class="button-text" href="administration_customization.php">CUSTOMIZATION</a>
    </div>
    <hr class="horizontal-line">
    <div id="administration__actions">
        <a class="button" href="article_add.php">Add article</a>
    </div>
    <table id="administration__articles">
        <thead>
        <tr>
            <th>Title</th>
            <th>Author</th>
            <th>Category</th>
            <th>Date added</th>
            <th>Views</th>
            <th>Published</th>
            <th class="actions-header-cell">Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($articles as $article): ?>
            <tr>
                <td class="administration-article__title"><?= $article['title'] ?></td>
                <td class="administration-article__author"><?= $article['author_name'] ?> <?= $article['author_lastname'] ?></td>
                <td class="administration-article__category"><?= $article['category_name'] ?></td>
                <td class="administration-article__date-added"><?= $article['date_added'] ?></td>
                <td class="administration-article__date-added"><?= $article['views'] ?></td>
                <td class="administration-article__date-added"><?= $article['is_published'] == 1 ? 'Ano' : 'Ne' ?></td>
                <td class="administration-table__actions">
                    <?php if ($_SESSION['is_admin'] == 1 || $article['author_id'] == $_SESSION['id']): ?>
                        <a class="button" href="article_edit.php?id=<?= $article['article_id'] ?>">Edit</a>
                        <a class="button button-danger"
                           href="article_delete.php?id=<?= $article['article_id'] ?>">Delete</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
