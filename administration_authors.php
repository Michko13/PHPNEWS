<?php
require_once 'components/header.php';
require_once 'autoloader.php';
AuthService::InitAuth();

$articleRepository = new ArticleRepository();
$categoryRepository = new CategoryRepository();
$authorRepository = new AuthorRepository();
$articles = $articleRepository->get_articles_for_administration();
$categories = $categoryRepository->get_categories_for_administration();
?>
<body>
<?php require_once 'components/navbar.php' ?>
<?php require_once 'components/author_add_dialog.php' ?>
<?php require_once 'components/category_add_dialog.php' ?>
<?php require_once 'components/category_edit_dialog.php' ?>
<?php require_once 'components/alert_dialog.php' ?>
<script>
    const authorAddDialog = document.getElementById("author-add-dialog");
    const categoryAddDialog = document.getElementById("category-add-dialog");
    const alertDialog = document.getElementById("alert-dialog");
    const alertDialogMessage = document.getElementById("alert-dialog__message");
    const categoryEditDialog = document.getElementById("category-edit-dialog");
    const categoryEditId = document.getElementById("category-edit-id");
    const categoryEditName = document.getElementById("category-edit-name");
    const categoryEditDescription = document.getElementById("category-edit-description");

    function openCategoryAddDialog() {
        categoryAddDialog.style.display = "flex";
    }

    function openAuthorAddDialog() {
        authorAddDialog.style.display = "flex";
    }

    function onDialogClose() {
        Array.from(document.getElementsByClassName("dialog")).forEach(dialog => {
            dialog.style.display = "none";
        })
    }

    function editCategory(id, name, description) {
        categoryEditId.value = id;
        categoryEditName.value = name;
        categoryEditDescription.value = description;
        categoryEditDialog.style.display = "flex";
    }

    function deleteCategory(id, articleCount) {
        if (articleCount > 0) {
            alertDialogMessage.innerText = "You cannot delete a category that has articles";
            alertDialog.style.display = "flex";
        } else {
            window.location.href = `category_delete.php?id=${id}`
        }
    }
</script>
<div id="administration-page" class="page">
    <h1 class="page__title">Administration</h1>
    <div id="administration__subpages">
        <a class="button-text" href="administration_index.php">ARTICLES</a>
        <a class="button-text" href="administration_categories.php">CATEGORIES</a>
        <a class="button-text" href="administration_gallery.php">GALLERY</a>
        <a class="button-text button-text-selected" href="administration_authors.php">AUTHORS</a>
        <a class="button-text" href="administration_customization.php">CUSTOMIZATION</a>
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
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($articles as $article): ?>
            <tr>
                <td class="administration-article__title"><?= $article['title'] ?></td>
                <td class="administration-article__author"><?= $article['author_name'] ?> <?= $article['author_surname'] ?></td>
                <td class="administration-article__category"><?= $article['category_name'] ?></td>
                <td class="administration-article__date-added"><?= $article['date_added'] ?></td>
                <td class="administration-article__date-added"><?= $article['views'] ?></td>
                <td class="administration-article__date-added"><?= $article['is_published'] == 1 ? 'Ano' : 'Ne' ?></td>
                <td class="administration-article__actions">
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
