<?php
require_once 'components/header.php';
require_once 'autoloader.php';
AuthService::InitAuth();

$categoryRepository = new CategoryRepository();
$categories = $categoryRepository->get_categories_for_administration();
?>
<body>
<?php
require_once 'components/navbar.php';
require_once 'components/category_dialog.php';
require_once 'components/alert_dialog.php';
?>
<script>
    const alertDialog = document.querySelector("#alert-dialog");
    const alertDialogMessage = document.querySelector("#alert-dialog__message");
    const categoryDialog = document.querySelector("#category-dialog");
    const categoryDialogTitle = document.querySelector("#category-dialog__title");
    const categoryDialogForm = document.querySelector("#category-dialog__form");
    const categoryDialogId = document.querySelector("#category-dialog__id");
    const categoryDialogName = document.querySelector("#category-dialog__name");
    const categoryDialogDescription = document.querySelector("#category-dialog__description");
    const categoryDialogSubmitButton = document.querySelector("#category-dialog__submit-button");

    function openCategoryAddDialog() {
        categoryDialogTitle.innerText = "Add category";
        categoryDialogForm.action = "category_add.php";
        categoryDialogSubmitButton.innerText = "Add";
        categoryDialog.style.display = "flex";
        categoryDialogId.value = null;
        categoryDialogName.value = null;
        categoryDialogDescription.value = null;
    }

    function openCategoryEditDialog(id, name, description) {
        categoryDialogTitle.innerText = "Edit category";
        categoryDialogForm.action = "category_edit.php";
        categoryDialogSubmitButton.innerText = "Edit";
        categoryDialog.style.display = "flex";
        categoryDialogId.value = id;
        categoryDialogName.value = name;
        categoryDialogDescription.value = description;
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
        <a class="button-text" href="administration_authors.php">AUTHORS</a>
        <a class="button-text" href="administration_gallery.php">GALLERY</a>
    </div>
    <hr class="horizontal-line">
    <div id="administration__actions">
        <div class="button" onclick="openCategoryAddDialog()">Add category</div>
    </div>
    <table id="administration__categories">
        <thead>
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Articles</th>
            <?php if ($_SESSION['is_admin'] == 1): ?>
                <th class="actions-header-cell">Actions</th>
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
                    <td class="administration-table__actions">
                        <a class="button"
                           onclick="openCategoryEditDialog(<?= $category['id'] ?>, '<?= $category['name'] ?>', '<?= $category['description'] ?>')">Edit</a>
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
