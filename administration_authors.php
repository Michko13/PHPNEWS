<?php
require_once 'components/header.php';
require_once 'components/navbar.php';
require_once 'components/author_dialog.php';
require_once 'autoloader.php';
AuthService::InitAuth();

$authorRepository = new AuthorRepository();
$authors = $authorRepository->get_all_authors();
?>
<body>
<script>
    const authorDialog = document.querySelector("#author-dialog");
    const authorDialogTitle = document.querySelector("#author-dialog__title");
    const authorDialogForm = document.querySelector("#author-dialog__form");
    const authorDialogId = document.querySelector("#author-dialog__id");
    const authorDialogUsername = document.querySelector("#author-dialog__username");
    const authorDialogImageLocation = document.querySelector("#image-preview");
    const authorDialogImageId = document.querySelector("#image-from-gallery");
    const authorDialogPassword = document.querySelector("#author-dialog__password");
    const authorDialogFirstname = document.querySelector("#author-dialog__firstname")
    const authorDialogLastname = document.querySelector("#author-dialog__lastname")
    const authorDialogBio = document.querySelector("#author-dialog__bio")
    const authorDialogSubmitButton = document.querySelector("#author-dialog__submit-button");


    function openAuthorAddDialog() {
        authorDialogTitle.innerText = "Add author";
        authorDialogForm.action = "author_add.php";
        authorDialogSubmitButton.innerText = "Add";
        authorDialog.style.display = "flex";
        authorDialogId.value = null;
        authorDialogUsername.value = null;
        authorDialogImageLocation.src = null;
        authorDialogImageLocation.style.display = "none";
        authorDialogImageId.value = null;
        authorDialogPassword.required = true;
        authorDialogFirstname.value = null;
        authorDialogLastname.value = null;
        authorDialogBio.value = null;
    }

    function openAuthorEditDialog(id, username, image, imageId, firstname, lastname, bio) {
        authorDialogTitle.innerText = "Edit author";
        authorDialogForm.action = "author_edit.php";
        authorDialogSubmitButton.innerText = "Edit";
        authorDialog.style.display = "flex";
        authorDialogId.value = id;
        authorDialogUsername.value = username;
        authorDialogImageLocation.src = image;
        authorDialogImageLocation.style.display = "block";
        authorDialogImageId.value = imageId;
        authorDialogPassword.required = false;
        authorDialogFirstname.value = firstname;
        authorDialogLastname.value = lastname;
        authorDialogBio.value = bio;
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
                        <a class="button"
                           onclick="openAuthorEditDialog('<?= $author['id'] ?>', '<?= $author['username'] ?>', '<?= $author['profile_image'] ?>',
                                   '<?= $author['profile_image_id'] ?>', '<?= $author['firstname'] ?>', '<?= $author['lastname'] ?>',
                                   '<?= escapeJavaScriptText($author['bio']) ?>')">Edit</a>
                        <a class="button button-danger"
                           href="author_delete.php?id=<?= $author['id'] ?>">Delete</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
