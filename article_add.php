<?php
require_once 'components/header.php';
require_once 'autoloader.php';
AuthService::InitAuth();

$categoryRepository = new CategoryRepository();
$categories = $categoryRepository->get_all_categories_name();

if (((!empty($_FILES['title-image-from-upload']) && $_FILES['title-image-from-upload']['full_path'] > 0) || !empty($_POST['title-image-from-gallery'])) &&
    !empty($_POST['title']) && !empty($_POST['perex']) && !empty($_POST['category']) && !empty($_POST['content'])) {

    $imageId = 0;

    $articleRepository = new ArticleRepository();
    if (!empty($_POST['title-image-from-gallery'])) {
        $imageId = $_POST['title-image-from-gallery'];
    } else {
        $galleryRepository = new GalleryRepository();
        $imageId = $galleryRepository->save_image_to_disk($_FILES['title-image-from-upload'], $_POST['title']);
    }

    $articleRepository->add_article($_POST['title'], $imageId,
        $_POST['perex'], $_SESSION['id'], $_POST['category'], $_POST['content'], date("d. n. Y | H:i"), isset($_POST['publish']) ? 1 : 0);
} else
?>
<body>
<?php
require_once 'components/navbar.php';
require_once 'components/gallery_dialog.php';
?>
<div id="article-add-page" class="page">
    <h1 class="page__title">Add article</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <div>
            <label for="title-image">Title image</label>
            <div id="title-image-options">
                <div class="button" onclick="openGalleryDialog()">Choose from gallery</div>
                <label for="upload-new-image" class="button upload-new-image-button">
                    <span style="font-weight: 400">Upload new image</span>
                    <input type="file" accept="image/png, image/jpeg" name="title-image-from-upload"
                           id="upload-new-image" style="display: none;" onchange="selectImageFromUpload()">
                </label>
                <input type="hidden" id="image-from-gallery" name="title-image-from-gallery">
            </div>
            <img id="image-preview" src="#" style="display: none;">
        </div>
        <div>
            <label for="title">Title</label>
            <input type="text" name="title" required>
        </div>
        <div>
            <label for="title">Perex</label>
            <textarea type="text" name="perex" required></textarea>
        </div>
        <div>
            <label for="category">Category</label>
            <select name="category" required>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label for="publish">Publish</label>
            <input type="checkbox" name="publish">
        </div>
        <textarea class="editor" id="content" name="content" rows="30" cols="80"></textarea>
        <button class="button" type="submit">Save and publish</button>
    </form>
</div>
<script src="scripts/image_picking_scripts.js"></script>
</body>
