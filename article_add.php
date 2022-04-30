<?php
include_once 'components/header.php';
require_once 'autoloader.php';
AuthService::InitAuth();

$categoryRepository = new CategoryRepository();
$categories = $categoryRepository->get_all_categories_name();

if(!empty($_POST['title']) && !empty($_FILES['title-image']) && !empty($_POST['perex']) && !empty($_POST['category']) &&
    !empty($_POST['content'])) {
    $articleRepository = new ArticleRepository();
    move_uploaded_file($_FILES['title-image']['tmp_name'], 'X:/www/PHPNEWS/uploads/' . $_FILES['title-image']['name']);
    $articleRepository->add_article($_POST['title'], 'uploads/' . $_FILES['title-image']['name'],
        $_POST['perex'], $_SESSION['id'], $_POST['category'], $_POST['content'], date("d. n. Y | H:i"), isset($_POST['publish']) ? 1 : 0);
}
?>
<body>
<?php include_once 'components/navbar.php' ?>
<div id="article-add-page" class="page">
    <h1 class="page__title">Přidat článek</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <div>
            <label for="title-image">Titulní obrázek</label>
            <input type="file" accept="image/png, image/jpeg" id="add-article-image" name="title-image" onchange="previewImage()" required>
            <img id="image-preview" src="#" style="display: none;">
        </div>
        <div>
            <label for="title">Titulek</label>
            <input type="text" name="title" required>
        </div>
        <div>
            <label for="title">Perex</label>
            <textarea type="text" name="perex" required></textarea>
        </div>
        <div>
            <label for="category">Kategorie</label>
            <select name="category" required>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label for="publish">Zveřejnit</label>
            <input type="checkbox" name="publish">
        </div>
        <textarea class="editor" id="content" name="content" rows="30" cols="80"></textarea>
        <button class="button" type="submit">Uložit a zveřejnit</button>
    </form>
</div>
</body>
<script>
    function previewImage() {
        const fileReader = new FileReader();
        fileReader.readAsDataURL(document.getElementById("add-article-image").files[0]);

        fileReader.onload = function (event) {
            const imgTag = document.getElementById("image-preview");
            imgTag.style.display = "block";
            imgTag.src = event.target.result;

            let i = new Image();

            /*i.onload = function(){
                alert( i.width+", "+i.height );
            };*/

            i.src = event.target.result;
        };
    }
</script>