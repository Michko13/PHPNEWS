<?php
require_once 'components/header.php';
require_once 'autoloader.php';
AuthService::InitAuth();

$authorRepository = new AuthorRepository();
$authors = $authorRepository->get_all_authors();
?>
<body>
<?php require_once 'components/navbar.php' ?>
<?php require_once 'components/author_add_dialog.php' ?>
<script>
    const authorAddDialog = document.getElementById("author-add-dialog");

    function openAuthorAddDialog() {
        authorAddDialog.style.display = "flex";
    }
</script>
<div id="administration-page" class="page">
    <h1 class="page__title">Administration</h1>
    <div id="administration__subpages">
        <a class="button-text" href="administration_index.php">ARTICLES</a>
        <a class="button-text" href="administration_categories.php">CATEGORIES</a>
        <a class="button-text button-text-selected" href="administration_authors.php">AUTHORS</a>
        <a class="button-text" href="administration_gallery.php">GALLERY</a>
        <a class="button-text" href="administration_customization.php">CUSTOMIZATION</a>
    </div>
    <hr class="horizontal-line">
    <div id="administration__actions">
        <a class="button" onclick="openAuthorAddDialog()">Add author</a>
    </div>
    <table id="administration__authors">
        <thead>
        <tr>
            <th>Username</th>
            <th>Firstname</th>
            <th>Lastname</th>
            <th>Bio</th>
            <th>Articles</th>
            <?php if ($_SESSION['is_admin'] == 1): ?>
                <th class="actions-header-cell">Actions</th>
            <?php endif; ?>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($authors as $author): ?>
            <tr>
                <td class="administration-author__username"><?= $author['username'] ?></td>
                <td class="administration-author__firstname"><?= $author['firstname'] ?></td>
                <td class="administration-author__lastname"><?= $author['lastname'] ?></td>
                <td class="administration-author__bio"><?= $author['bio'] ?></td>
                <td class="administration-author__articles"><?= $author['article_count'] ?></td>
                <td class="administration-table__actions">
                    <?php if ($_SESSION['is_admin'] == 1 || $author['id'] == $_SESSION['id']): ?>
                        <a class="button" href="author_edit.php?id=<?= $author['id'] ?>">Edit</a>
                        <a class="button button-danger"
                           href="article_delete.php?id=">Delete</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
