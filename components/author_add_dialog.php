<div id="author-add-dialog" class="dialog">
    <div class="dialog__content" style="max-width: 440px">
        <div class="dialog__content__header">
            <h2 class="dialog__title">Add new author</h2>
            <span class="material-icons close-button" onclick="onDialogClose('author-add-dialog')">close</span>
        </div>
        <form class="dialog__content__body" action="author_add.php" method="post" enctype="multipart/form-data">
            <div>
                <label for="username">Username</label>
                <input type="text" name="username" required>
            </div>
            <div>
                <label for="lastname">Profile image</label>
                <div id="profile-image-options">
                    <div class="button" onclick="openGalleryDialog()">Choose from gallery</div>
                    <label for="upload-new-image" class="button upload-new-image-button">
                        <span style="font-weight: 400">Upload new image</span>
                        <input type="file" accept="image/png, image/jpeg" name="profile-image-from-upload"
                               id="upload-new-image" style="display: none;" onchange="selectImageFromUpload()">
                    </label>
                    <input type="hidden" id="image-from-gallery" name="profile-image-from-gallery">
                </div>
                <img id="image-preview" src="#" style="display: none;">
            </div>
            <div>
                <label for="lastname">Password</label>
                <input type="password" name="password" required>
            </div>
            <div>
                <label for="name">Firstname</label>
                <input type="text" name="name" required>
            </div>
            <div>
                <label for="lastname">Surname</label>
                <input type="text" name="lastname" required>
            </div>
            <div>
                <label for="bio">Bio</label>
                <textarea name="bio" rows="4"></textarea required>
            </div>
            <div class="dialog__content__body__actions">
                <button class="button button-danger" type="button" onclick="onDialogClose('author-add-dialog')">Cancel</button>
                <button class="button" type="submit">Add</button>
            </div>
        </form>
    </div>
</div>
<?php require_once 'components/gallery_dialog.php' ?>
<script src="image_picking_scripts.js"></script>
