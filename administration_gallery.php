<?php
require_once 'components/header.php';
require_once 'autoloader.php';
AuthService::InitAuth();

$page = 1;
if(!empty($_GET['page']) && is_numeric($_GET['page'])) {
    $page = $_GET['page'];
}

$galleryRepository = new GalleryRepository();
$amountOfPages = $galleryRepository->get_amount_of_pages_in_gallery();

if($page > $amountOfPages) {
    $page = $amountOfPages;
}
if($page < 1) {
    $page = 1;
}

$images = $galleryRepository->get_one_page_of_gallery($page);
?>
<body>
<?php require_once 'components/navbar.php' ?>
<?php require_once 'components/image_add_dialog.php' ?>
<?php require_once 'components/image_detail_dialog.php' ?>
<script>
    const imageDetailDialog = document.querySelector("#image-detail-dialog");
    const imageAddDialog = document.querySelector("#image-add-dialog");
    const imageDetail = document.querySelector("#image-detail__src");
    const imageDetailTitle = document.querySelector("#image-detail__metadata__title");
    const imageDetailDateAdded = document.querySelector("#image-detail__metadata__date-added");
    const imageDetailFileName = document.querySelector("#image-detail__metadata__file-name");
    const imageDetailFileType = document.querySelector("#image-detail__metadata__file-type");
    const imageDetailFileSize = document.querySelector("#image-detail__metadata__file-size");
    const imageDetailResolution = document.querySelector("#image-detail__metadata__resolution");

    function openImageAddDialog() {
        imageAddDialog.style.display = "flex";
    }

    function openImageDetailDialog(location, title, dateAdded, fileName, fileType, fileSize, resolution) {
        imageDetail.src = location;
        imageDetailTitle.innerHTML = "<strong>Title:&nbsp</strong>" + title;
        imageDetailDateAdded.innerHTML = "<strong>Date added:&nbsp</strong>" + new Date(parseInt(dateAdded) * 1000).toLocaleDateString("cs-CZ");
        imageDetailFileName.innerHTML = "<strong>File name:&nbsp</strong>" + fileName;
        imageDetailFileType.innerHTML = "<strong>File type:&nbsp</strong>" + fileType;
        imageDetailFileSize.innerHTML = "<strong>File size:&nbsp</strong>" + Math.round(parseInt(fileSize) / 1024) + " KB";
        imageDetailResolution.innerHTML = "<strong>Resolution:&nbsp</strong>" + resolution;
        imageDetailDialog.style.display = "flex";
    }
</script>
<div id="administration-page" class="page">
    <h1 class="page__title">Administration</h1>
    <div id="administration__subpages">
        <a class="button-text" href="administration_index.php">ARTICLES</a>
        <a class="button-text" href="administration_categories.php">CATEGORIES</a>
        <a class="button-text button-text-selected" href="administration_gallery.php">GALLERY</a>
        <a class="button-text" href="administration_authors.php">AUTHORS</a>
        <a class="button-text" href="administration_customization.php">CUSTOMIZATION</a>
    </div>
    <hr class="horizontal-line">
    <div id="administration__actions">
        <div class="button" onclick="openImageAddDialog()">Add image</div>
    </div>
    <div id="administration__gallery">
        <div id="administration__gallery-images">
            <?php foreach ($images as $image): ?>
                <?php $metadata = exif_read_data($image['location']) ?>
                <img src="<?= $image['location'] ?>" onclick="openImageDetailDialog(
                        '<?= $image['location'] ?>', '<?= $image['title'] ?>', '<?= $metadata['FileDateTime'] ?>',
                        '<?= $metadata['FileName'] ?>', '<?= $metadata['MimeType'] ?>', '<?= $metadata['FileSize'] ?>',
                        '<?= $metadata["COMPUTED"]['Width'] . ' x ' . $metadata["COMPUTED"]['Height'] . ' px' ?>')"/>
            <?php endforeach; ?>
        </div>
        <div id="administration__gallery-page-controller">
            <a class="material-icons left-arrow" href="administration_gallery.php?page=<?= $page - 1 != 0 ? $page - 1 : 1 ?>">chevron_left</a>
            <?= $page ?> / <?= $amountOfPages ?>
            <a class="material-icons right-arrow" href="administration_gallery.php?page=<?= !($page + 1 >= $amountOfPages) ? $page + 1 : $amountOfPages ?>">chevron_right</a>
        </div>
    </div>
</div>
</body>
