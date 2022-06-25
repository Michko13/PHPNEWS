const imagePreview = document.querySelector("#image-preview");
const galleryImageLocation = document.querySelector("#image-from-gallery");
const galleryDialog = document.querySelector("#gallery-dialog");

function selectImageFromGallery(id, location) {
    imagePreview.src = location;
    imagePreview.style.display = "block";
    galleryImageLocation.value = id;
}

function selectImageFromUpload() {
    const fileReader = new FileReader();
    fileReader.readAsDataURL(document.querySelector("#upload-new-image").files[0]);

    fileReader.onload = function (event) {
        imagePreview.style.display = "block";
        imagePreview.src = event.target.result;
    };
}

function openGalleryDialog() {
    galleryDialog.style.display = "flex";
}