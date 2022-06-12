<div id="image-add-dialog" class="dialog">
    <div class="dialog__content">
        <div class="dialog__content__header">
            <h2 class="dialog__title">Add new image</h2>
            <span class="material-icons close-button" onclick="onDialogClose('image-add-dialog')">close</span>
        </div>
        <form action="image_add.php" method="post" enctype="multipart/form-data" class="dialog__content__body">
            <div>
                <label for="image">Image</label>
                <input type="file" accept="image/png, image/jpeg" id="add-image" name="image" onchange="previewImage()" required>
                <img id="add-image-preview" class="image-preview" src="#" style="display: none;">
            </div>
            <div>
                <label for="title">Title</label>
                <input type="text" name="title" required>
            </div>
            <div class="dialog__content__body__actions">
                <button class="button button-danger" type="button" onclick="onDialogClose('image-add-dialog')">Cancel</button>
                <button class="button" type="submit">Add</button>
            </div>
        </form>
    </div>
</div>
<script>
    function previewImage() {
        const fileReader = new FileReader();
        fileReader.readAsDataURL(document.querySelector("#add-image").files[0]);

        fileReader.onload = function (event) {
            const imgTag = document.querySelector("#add-image-preview");
            imgTag.style.display = "block";
            imgTag.src = event.target.result;

            let i = new Image();

            i.src = event.target.result;
        };
    }
</script>