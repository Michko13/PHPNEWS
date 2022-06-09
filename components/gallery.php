<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/PHPNEWS/autoloader.php';

$current_path = empty($_GET['currentPath']) ? substr($_SERVER["SCRIPT_NAME"], strrpos($_SERVER["SCRIPT_NAME"], "/") + 1) : $_GET['currentPath'];

$page = 1;
if (!empty($_GET['page']) && is_numeric($_GET['page'])) {
    $page = $_GET['page'];
}

$galleryRepository = new GalleryRepository();
$amountOfPages = $galleryRepository->get_amount_of_pages_in_gallery();

if ($page > $amountOfPages) {
    $page = $amountOfPages;
}
if ($page < 1) {
    $page = 1;
}

$images = $galleryRepository->get_one_page_of_gallery($page);
?>
<div id="ajax-wrapper">
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/PHPNEWS/components/image_add_dialog.php' ?>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/PHPNEWS/components/image_detail_dialog.php' ?>
    <script>
        function openImageAddDialog() {
            const imageAddDialog = document.querySelector("#image-add-dialog");

            imageAddDialog.style.display = "flex";
        }

        function openImageDetailDialog(location, title, dateAdded, fileName, fileType, fileSize, resolution, canChoose) {
            const imageDetailDialog = document.querySelector("#image-detail-dialog");
            const imageDetail = document.querySelector("#image-detail__src");
            const imageDetailTitle = document.querySelector("#image-detail__metadata__title");
            const imageDetailDateAdded = document.querySelector("#image-detail__metadata__date-added");
            const imageDetailFileName = document.querySelector("#image-detail__metadata__file-name");
            const imageDetailFileType = document.querySelector("#image-detail__metadata__file-type");
            const imageDetailFileSize = document.querySelector("#image-detail__metadata__file-size");
            const imageDetailResolution = document.querySelector("#image-detail__metadata__resolution");
            const imageDetailDialogActions = document.querySelector("#image-detail-dialog__actions");

            imageDetail.src = location;
            imageDetailTitle.innerHTML = "<strong>Title:&nbsp</strong>" + title;
            imageDetailDateAdded.innerHTML = "<strong>Date added:&nbsp</strong>" + new Date(parseInt(dateAdded) * 1000).toLocaleDateString("cs-CZ");
            imageDetailFileName.innerHTML = "<strong>File name:&nbsp</strong>" + fileName;
            imageDetailFileType.innerHTML = "<strong>File type:&nbsp</strong>" + fileType;
            imageDetailFileSize.innerHTML = "<strong>File size:&nbsp</strong>" + Math.round(parseInt(fileSize) / 1024) + " KB";
            imageDetailResolution.innerHTML = "<strong>Resolution:&nbsp</strong>" + resolution;
            imageDetailDialog.style.display = "flex";

            if(canChoose) {
                imageDetailDialogActions.style.display = "flex";
            }

            const chooseButton = document.querySelector("#choose-button");
            chooseButton.addEventListener("click", () => {
                selectImage(location)
                const imageAddDialog = document.querySelector("#image-add-dialog");
                const galleryDialog = document.querySelector("#gallery-dialog");
                imageAddDialog.style.display = "none";
                imageDetailDialog.style.display = "none";
                galleryDialog.style.display = "none";
            })
        }
    </script>
    <div id="administration__gallery">
        <div id="administration__gallery-images">
            <?php foreach ($images as $image): ?>
                <?php $metadata = exif_read_data('C:\xampp\htdocs\PHPNEWS\\' . $image['location']) ?>
                <img src="<?= $image['location'] ?>" onclick="openImageDetailDialog(
                        '<?= $image['location'] ?>', '<?= $image['title'] ?>', '<?= $metadata['FileDateTime'] ?>',
                        '<?= $metadata['FileName'] ?>', '<?= $metadata['MimeType'] ?>', '<?= $metadata['FileSize'] ?>',
                        '<?= $metadata["COMPUTED"]['Width'] . ' x ' . $metadata["COMPUTED"]['Height'] . ' px' ?>',
                         <?= (str_starts_with($current_path, 'administration_gallery.php')) ? 'false' : 'true' ?>)"/>
            <?php endforeach; ?>
        </div>
        <div id="administration__gallery-page-controller">
            <div class="material-icons left-arrow" onclick="previousPage()">chevron_left</div>
            <input type="number" class="page-number-input" id="page-number-input" value="<?= $page ?>"
                   onchange="onPageNumberChange()"> / <?= $amountOfPages ?>
            <div class="material-icons right-arrow" onclick="nextPage()">chevron_right</div>
        </div>
        <script>
            let page = <?= $page ?>;
            let amountOfPages = <?= $amountOfPages ?>;

            function previousPage() {
                if (page - 1 > 0) {
                    page--;
                    sendReq();
                }
            }

            function nextPage() {
                if (page + 1 <= amountOfPages) {
                    page++;
                    sendReq();
                }
            }

            function sendReq() {
                let req = new XMLHttpRequest();

                req.onreadystatechange = function () {
                    if (this.readyState === 4 && this.status === 200) {
                        const wrapper = document.querySelector("#ajax-wrapper");
                        wrapper.innerHTML = this.responseText;
                        let docFrag = document.createDocumentFragment();
                        let child = wrapper.removeChild(wrapper.firstChild);
                        docFrag.appendChild(child);
                        wrapper.parentNode.replaceChild(docFrag, wrapper);
                    }
                };

                req.open("GET", `components/gallery.php?page=${page}&currentPath=<?= $current_path ?>`, true);
                req.send();
            }

            function onPageNumberChange() {
                const pageNumberInput = document.querySelector("#page-number-input");

                if (pageNumberInput.value > 0 && pageNumberInput.value <= amountOfPages) {
                    page = parseInt(pageNumberInput.value);
                    sendReq();
                } else {
                    pageNumberInput.value = page;
                }
            }
        </script>
    </div>

</div>