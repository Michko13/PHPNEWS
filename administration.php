<?php
include_once 'components/header.php';
require_once 'autoloader.php';
AuthService::InitAuth();

$articleRepository = new ArticleRepository();
$categoryRepository = new CategoryRepository();
$authorRepository = new AuthorRepository();
$articles = $articleRepository->get_articles_for_administration();
$categories = $categoryRepository->get_categories_for_administration();
?>
<body>
<?php include_once 'components/navbar.php' ?>
<?php include_once 'components/author_add_dialog.php' ?>
<?php include_once 'components/category_add_dialog.php' ?>
<?php include_once 'components/category_edit_dialog.php' ?>
<?php include_once 'components/alert_dialog.php' ?>
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
            alertDialogMessage.innerText = "Nemůžete smazat kategorii, která má v sobě nějaké články";
            alertDialog.style.display = "flex";
        } else {
            window.location.href = `category_delete.php?id=${id}`
        }
    }
</script>
<div id="administration-page" class="page">
    <h1 class="page__title">Administrace</h1>
    <div id="administration__actions">
        <a class="button" href="article_add.php">Přidat článek</a>
        <a class="button" onclick="openCategoryAddDialog()">Přidat kategorii</a>
        <?php if ($_SESSION['is_admin'] == 1): ?>
            <a class="button" onclick="openAuthorAddDialog()">Zaregistrovat nového autora</a>
        <?php endif; ?>
    </div>
    <h2>Články</h2>
    <table id="administration__articles">
        <thead>
        <tr>
            <th>Titulek</th>
            <th>Autor</th>
            <th>Kategorie</th>
            <th>Datum přidání</th>
            <th>Zveřejněn</th>
            <th>Akce</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($articles as $article): ?>
            <tr>
                <td class="administration-article__title"><?= $article['title'] ?></td>
                <td class="administration-article__author"><?= $article['author_name'] ?> <?= $article['author_surname'] ?></td>
                <td class="administration-article__category"><?= $article['category_name'] ?></td>
                <td class="administration-article__date-added"><?= $article['date_added'] ?></td>
                <td class="administration-article__date-added"><?= $article['is_published'] == 1 ? 'Ano' : 'Ne' ?></td>
                <td class="administration-article__actions">
                    <?php if ($_SESSION['is_admin'] == 1 || $article['author_id'] == $_SESSION['id']): ?>
                        <a class="button" href="article_edit.php?id=<?= $article['article_id'] ?>">Upravit</a>
                        <a class="button button-danger"
                           href="article_delete.php?id=<?= $article['article_id'] ?>">Smazat</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <h2>Kategorie</h2>
    <table id="administration__categories">
        <thead>
        <tr>
            <th>Jméno</th>
            <th>Popis</th>
            <th>Článků</th>
            <?php if ($_SESSION['is_admin'] == 1): ?>
                <th>Akce</th>
            <?php endif; ?>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($categories as $category): ?>
            <tr>
                <td class="administration-category__name"><?= $category['name'] ?></td>
                <td class="administration-category__description"><?= $category['description'] ?></td>
                <td class="administration-article__category"><?= $category['article_count'] ?></td>
                <?php if ($_SESSION['is_admin'] == 1): ?>
                    <td class="administration-article__actions">
                        <a class="button"
                           onclick="editCategory(<?= $category['id'] ?>, '<?= $category['name'] ?>', '<?= $category['description'] ?>')">Upravit</a>
                        <a class="button button-danger"
                           onclick="deleteCategory(<?= $category['id'] ?>, <?= $category['article_count'] ?>)">Smazat</a>
                    </td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
