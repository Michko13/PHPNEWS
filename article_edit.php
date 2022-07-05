<?php
require_once 'components/header.php';
require_once 'autoloader.php';
AuthService::InitAuth();

$articleRepository = new ArticleRepository();
if (empty($_GET['id']) || !$articleRepository->does_article_exist($_GET['id']) &&
    !($_SESSION['is_admin'] == 1 || $articleRepository->get_article_author($_GET['id']) == $_SESSION['id'])) {
    header('Location: administration_index.php');
    die();
}

$categoryRepository = new CategoryRepository();
$article = $articleRepository->get_article($_GET['id']);
$categories = $categoryRepository->get_all_categories_name();

if (((!empty($_FILES['title-image-from-upload']) && $_FILES['title-image-from-upload']['full_path'] > 0) || !empty($_POST['title-image-from-gallery'])) &&
    !empty($_POST['title']) && !empty($_POST['perex']) && !empty($_POST['category']) && !empty($_POST['content'])) {

    $imageId = $_POST['title-image-from-gallery'];

    $articleRepository = new ArticleRepository();
    if(!empty($_FILES['title-image-from-upload']) && $_FILES['title-image-from-upload']['full_path'] > 0) {
        $galleryRepository = new GalleryRepository();
        $imageId = $galleryRepository->save_image_to_disk($_FILES['title-image-from-upload'], $_POST['title']);
    }

    $articleRepository->edit_article($_GET['id'], $_POST['title'], $imageId,
        $_POST['perex'], $_POST['category'], $_POST['content'], isset($_POST['publish']) ? 1 : 0);

    header('Location: article_edit.php?id=' . $_GET['id']);
}
?>
<?php
require_once 'components/navbar.php';
require_once 'components/gallery_dialog.php';
?>
<body>
<div id="article-add-page" class="page">
    <h1 class="page__title">Edit article</h1>
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
                <input type="hidden" id="image-from-gallery" name="title-image-from-gallery" value="<?= $article['title_image_id'] ?>">
            </div>
            <img id="image-preview" src="<?= $article['title_image'] ?>">
        </div>
        <div>
            <label for="title">Title</label>
            <input type="text" name="title" value="<?= $article['title'] ?>" required>
        </div>
        <div>
            <label for="title">Perex</label>
            <textarea type="text" name="perex" required><?= $article['perex'] ?></textarea>
        </div>
        <div>
            <label for="category">Category</label>
            <select name="category" required>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['id'] ?>"
                        <?php if ($category['id'] == $article['category_id']): ?> selected <?php endif; ?>
                    ><?= $category['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label for="publish">Publish</label>
            <input type="checkbox" name="publish" <?php echo($article['is_published'] == 1 ? "checked" : "") ?>>
        </div>
        <textarea class="editor" id="content" name="content" rows="30" cols="80"><?= $article['content'] ?></textarea>
        <div style="font-size: 1.1rem;" class="button" type="submit">Save</div>
    </form>
</div>
<script src="scripts/image_picking_scripts.js"></script>
</body>
