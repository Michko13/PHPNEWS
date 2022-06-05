<?php
require_once 'components/header.php';
require_once 'autoloader.php';
AuthService::InitAuth();

$articleRepository = new ArticleRepository();
if (empty($_GET['id']) || !$articleRepository->does_article_exist($_GET['id']) &&
    !($_SESSION['is_admin'] == 1 || $articleRepository->get_article_author($_GET['id']) == $_SESSION['id'])) {
    header('Location: administration.php');
    die();
}

$categoryRepository = new CategoryRepository();
$article = $articleRepository->get_article($_GET['id']);
$categories = $categoryRepository->get_all_categories_name();

if (isset($_GET['id']) && isset($_POST['title']) && isset($_FILES['title-image']) && isset($_POST['perex']) && isset($_POST['category']) &&
    isset($_POST['content'])) {
    $articleRepository = new ArticleRepository();
    move_uploaded_file($_FILES['title-image']['tmp_name'], 'X:/www/PHPNEWS/uploads/' . $_FILES['title-image']['name']);
    $articleRepository->edit_article($_GET['id'], $_POST['title'],
        strlen($_FILES['title-image']['tmp_name']) > 0 ? 'uploads/' . $_FILES['title-image']['name'] : $article['title_image'],
        $_POST['perex'], $_POST['category'], $_POST['content'], isset($_POST['publish']) ? 1 : 0);
    header('Location: article_edit.php?id=' . $_GET['id']);
}
?>
<body>
<?php require_once 'components/navbar.php' ?>
<div id="article-add-page" class="page">
    <h1 class="page__title">Upravit článek</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <div>
            <label for="title-image">Titulní obrázek</label>
            <input type="file" accept="image/png, image/jpeg" id="add-article-image" name="title-image"
                   onchange="previewImage()">
            <img id="image-preview" src=" <?= $article['title_image'] ?>">
        </div>
        <div>
            <label for="title">Titulek</label>
            <input type="text" name="title" value="<?= $article['title'] ?>" required>
        </div>
        <div>
            <label for="title">Perex</label>
            <textarea type="text" name="perex" required><?= $article['perex'] ?></textarea>
        </div>
        <div>
            <label for="category">Kategorie</label>
            <select name="category" required>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['id'] ?>"
                        <?php if ($category['id'] == $article['category_id']): ?> selected <?php endif; ?>
                    ><?= $category['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label for="publish">Zveřejnit</label>
            <input type="checkbox" name="publish" <?php echo($article['is_published'] == 1 ? "checked" : "") ?>>
        </div>
        <textarea class="editor" id="content" name="content" rows="30" cols="80"><?= $article['content'] ?></textarea>
        <button class="button" type="submit">Uložit</button>
    </form>
</div>
</body>
<script>
    function previewImage() {
        const fileReader = new FileReader();
        fileReader.readAsDataURL(document.getElementById("add-article-image").files[0]);

        fileReader.onload = function (event) {
            const imgTag = document.getElementById("image-preview");
            imgTag.src = event.target.result;
        };
    }
</script>