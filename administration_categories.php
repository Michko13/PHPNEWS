<?php
require_once 'components/header.php';
require_once 'autoloader.php';
AuthService::InitAuth();

$categoryRepository = new CategoryRepository();
$categories = $categoryRepository->get_categories_for_administration();
?>
<body>
<?php require_once 'components/navbar.php' ?>
<?php require_once 'components/category_add_dialog.php' ?>
<?php require_once 'components/category_edit_dialog.php' ?>
<?php require_once 'components/alert_dialog.php' ?>
<script>
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
        <a class="button-text button-text-selected" href="administration_categories.php">CATEGORIES</a>
        <a class="button-text" href="administration_gallery.php">GALLERY</a>
        <a class="button-text" href="administration_authors.php">AUTHORS</a>
        <a class="button-text" href="administration_customization.php">CUSTOMIZATION</a>
    </div>
    <hr class="horizontal-line">
    <div id="administration__actions">
        <a class="button" onclick="openCategoryAddDialog()">Add category</a>
    </div>
    <table id="administration__categories">
        <thead>
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Articles</th>
            <?php if ($_SESSION['is_admin'] == 1): ?>
                <th>Actions</th>
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
                           onclick="editCategory(<?= $category['id'] ?>, '<?= $category['name'] ?>', '<?= $category['description'] ?>')">Edit</a>
                        <a class="button button-danger"
                           onclick="deleteCategory(<?= $category['id'] ?>, <?= $category['article_count'] ?>)">Delete</a>
                    </td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
