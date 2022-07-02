<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/PHPNEWS/autoloader.php';

$current_path = empty($_GET['currentPath']) ? substr($_SERVER["SCRIPT_NAME"], strrpos($_SERVER["SCRIPT_NAME"], "/") + 1) : $_GET['currentPath'];

$page = 1;
if (!empty($_GET['page']) && is_numeric($_GET['page'])) {
    $page = $_GET['page'];
}

$galleryRepository = new GalleryRepository();
$amountOfPages = $galleryRepository->get_amount_of_pages_in_gallery($_GET['search'] ?? null);

if ($page > $amountOfPages) {
    $page = $amountOfPages;
}
if ($page < 1) {
    $page = 1;
}

$images = $galleryRepository->get_one_page_of_gallery($page, $_GET['search'] ?? null);
?>
<div id="ajax-wrapper">
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/PHPNEWS/components/image_add_dialog.php' ?>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/PHPNEWS/components/image_detail_dialog.php' ?>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/PHPNEWS/components/alert_dialog.php' ?>
    <script>
        function openImageAddDialog() {
            const imageAddDialog = document.querySelector("#image-add-dialog");
            imageAddDialog.style.display = "flex";
        }

        function openImageDetailDialog(id, location, title, dateAdded, fileName, fileType, fileSize, resolution, canChoose, canDelete, imageArticleUsages, imageAuthorUsages) {
            const imageDetailDialog = document.querySelector("#image-detail-dialog");
            const imageDetail = document.querySelector("#image-detail__src");
            const imageDetailTitle = document.querySelector("#image-detail__metadata__title");
            const imageDetailDateAdded = document.querySelector("#image-detail__metadata__date-added");
            const imageDetailFileName = document.querySelector("#image-detail__metadata__file-name");
            const imageDetailFileType = document.querySelector("#image-detail__metadata__file-type");
            const imageDetailFileSize = document.querySelector("#image-detail__metadata__file-size");
            const imageDetailResolution = document.querySelector("#image-detail__metadata__resolution");
            const imageDetailDialogActions = document.querySelector("#image-detail-dialog__actions");
            const imageDetailDialogAdministrationActions = document.querySelector("#image-detail-dialog__administration-actions");
            const imageDetailDeleteButton = document.querySelector("#delete-button");
            const alertDialog = document.querySelector("#alert-dialog");
            const alertDialogMessage = document.querySelector("#alert-dialog__message");

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
            } else {
                imageDetailDialogAdministrationActions.style.display = "flex";

                imageDetailDeleteButton.onclick = () => {
                    if(canDelete) {
                        window.location.href = `image_delete.php?id=${id}`;
                    } else {
                        alertDialogMessage.innerHTML = `<strong>Cannot delete an image that is being used</strong>`;

                        if(imageArticleUsages.length > 0) {
                            alertDialogMessage.innerHTML += `<p>Following articles are using this image:</p>`;
                        }
                        imageArticleUsages.forEach((id, index) => {
                            alertDialogMessage.innerHTML += `<a href="article_detail.php?id=${id}" style="margin-right: 4px">${index + 1},&nbsp</a>`
                        })

                        if(imageAuthorUsages.length > 0) {
                            alertDialogMessage.innerHTML += `<p>Following authors are using this image:</p>`;

                        }
                        imageAuthorUsages.forEach((id, index) => {
                            alertDialogMessage.innerHTML += `<a href="articles_by_author.php?id=${id}" style="margin-right: 4px">${index + 1},&nbsp</a>`
                        })

                        alertDialog.style.display = "flex";
                    }
                }
            }

            const chooseButton = document.querySelector("#choose-button");
            chooseButton.onclick = () => {
                selectImageFromGallery(id, location);
                const imageAddDialog = document.querySelector("#image-add-dialog");
                const galleryDialog = document.querySelector("#gallery-dialog");
                imageAddDialog.style.display = "none";
                imageDetailDialog.style.display = "none";
                galleryDialog.style.display = "none";
            }
        }
    </script>
    <div id="gallery">
        <div id="gallery__search">
            <input id="gallery__search__text" type="text" placeholder="Title of image..." value="<?= $_GET['search'] ?? '' ?>">
            <div id="gallery__search__close-button" class="material-icons" onclick="onSearchDelete()">close</div>
            <button id="gallery__search__confirm-button" class="button" onclick="onSearch()">Search</button>
        </div>
        <div id="gallery__images">
            <?php foreach ($images as $image): ?>
                <?php
                $metadata = exif_read_data('C:\xampp\htdocs\PHPNEWS\\' . $image['location']);
                $imageArticleUsages = $galleryRepository->image_article_usages($image['id']);
                $imageAuthorUsages = $galleryRepository->image_author_usages($image['id']);
                ?>

                <img src="<?= $image['location'] ?>" onclick="openImageDetailDialog(<?= $image['id'] ?>,
                        '<?= $image['location'] ?>', '<?= $image['title'] ?>', '<?= $metadata['FileDateTime'] ?>',
                        '<?= $metadata['FileName'] ?>', '<?= $metadata['MimeType'] ?>', '<?= $metadata['FileSize'] ?>',
                        '<?= $metadata["COMPUTED"]['Width'] . ' x ' . $metadata["COMPUTED"]['Height'] . ' px' ?>',
                         <?= !(str_starts_with($current_path, 'administration_gallery.php')) ? 'true' : 'false' ?>,
                         <?= (count($imageArticleUsages) === 0 && count($imageAuthorUsages) === 0) ? 'true' : 'false' ?>,
                         <?= json_encode(array_column($imageArticleUsages, 'id')) ?>,
                         <?= json_encode(array_column($imageAuthorUsages, 'id')) ?>)"/>
            <?php endforeach; ?>
        </div>
        <div id="gallery__page">
            <div class="material-icons left-arrow" onclick="previousPage()">chevron_left</div>
            <input type="number" class="gallery__page-number" id="gallery__page-number-input" value="<?= count($images) > 0 ? $page : 0 ?>"
                   onchange="onPageNumberChange()">
            <span>/</span>
            <input type="number" class="gallery__page-number" value="<?= $amountOfPages ?>" readonly>
            <div class="material-icons right-arrow" onclick="nextPage()">chevron_right</div>
        </div>
        <script>
            let page = <?= $page ?>;
            let amountOfPages = <?= $amountOfPages ?>;
            let search = <?= $_GET['search'] ?? "''" ?>;

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

                let url = `components/gallery.php?page=${page}&currentPath=<?= $current_path ?>`;
                if(search !== '') {
                    url += `&search=${search}`;
                }

                req.open("GET", url, true);
                req.send();
            }

            function onPageNumberChange() {
                const pageNumberInput = document.querySelector("#gallery__page-number-input");

                if (pageNumberInput.value > 0 && pageNumberInput.value <= amountOfPages) {
                    page = parseInt(pageNumberInput.value);
                    sendReq();
                } else {
                    pageNumberInput.value = page;
                }
            }

            function onSearch() {
                const searchText = document.querySelector("#gallery__search__text");
                if(searchText.value !== '') {
                    search = searchText.value;
                    sendReq();
                }
            }

            function onSearchDelete() {
                const searchText = document.querySelector("#gallery__search__text");
                if(searchText.value !== '') {
                    searchText.value = '';
                    search = '';
                    sendReq();
                }
            }
        </script>
    </div>

</div>