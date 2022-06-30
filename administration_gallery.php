<?php
require_once 'components/header.php';
require_once 'autoloader.php';
AuthService::InitAuth();
?>
<body>
<?php require_once 'components/navbar.php' ?>
<div id="administration-page" class="page">
    <h1 class="page__title">Administration</h1>
    <div id="administration__subpages">
        <a class="button-text" href="administration_index.php">ARTICLES</a>
        <a class="button-text" href="administration_categories.php">CATEGORIES</a>
        <a class="button-text" href="administration_authors.php">AUTHORS</a>
        <a class="button-text button-text-selected" href="administration_gallery.php">GALLERY</a>
        <a class="button-text" href="administration_customization.php">CUSTOMIZATION</a>
    </div>
    <hr class="horizontal-line">
    <div id="administration__actions">
        <div class="button" onclick="openImageAddDialog()">Add image</div>
    </div>
    <?php require_once 'components/gallery.php' ?>
</div>
</body>
