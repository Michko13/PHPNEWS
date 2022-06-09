<?php
require_once 'components/header.php';
require_once 'autoloader.php';
AuthService::InitAuth();

$categoryRepository = new CategoryRepository();
$categories = $categoryRepository->get_all_categories_name();

if(!empty($_POST['title']) && !empty($_FILES['title-image']) && !empty($_POST['title-image-title']) && !empty($_POST['perex']) && !empty($_POST['category']) &&
    !empty($_POST['content'])) {
    $articleRepository = new ArticleRepository();
    move_uploaded_file($_FILES['title-image']['tmp_name'], 'X:/www/PHPNEWS/uploads/' . $_FILES['title-image']['name']);
    $galleryRepository = new GalleryRepository();
    $imageId = $galleryRepository->add_image($_POST['title-image-title'], 'uploads/' . $_FILES['title-image']['name']);
    $articleRepository->add_article($_POST['title'], $imageId,
        $_POST['perex'], $_SESSION['id'], $_POST['category'], $_POST['content'], date("d. n. Y | H:i"), isset($_POST['publish']) ? 1 : 0);
}
?>
<?php require_once 'components/gallery_dialog.php' ?>
<script>
    const galleryDialog = document.querySelector("#gallery-dialog");

    function openGalleryDialog() {
        galleryDialog.style.display = "flex";
    }
</script>
<?php if(!empty($_GET['page'])): ?>
<script>
    openGalleryDialog();
</script>
<?php endif; ?>
<body>
<?php require_once 'components/navbar.php' ?>
<div id="article-add-page" class="page">
    <h1 class="page__title">Add article</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <div>
            <label for="title-image">Title image</label>
            <div class="button" onclick="openGalleryDialog()">Choose from gallery</div>
            <img id="article-image-preview" src="#" style="display: none;">
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
</body>
<script>
    const imagePreview = document.querySelector("#article-image-preview")

    function selectImage(location) {
        imagePreview.src = location;
        imagePreview.style.display = "block";
    }
</script>