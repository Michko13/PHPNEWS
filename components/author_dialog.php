<div id="author-dialog" class="dialog">
    <div class="dialog__content" style="max-width: 440px">
        <div class="dialog__content__header">
            <h2 id="author-dialog__title" class="dialog__title"></h2>
            <span class="material-icons close-button" onclick="onDialogClose('author-dialog')">close</span>
        </div>
        <form id="author-dialog__form" class="dialog__content__body" method="post" enctype="multipart/form-data">
            <input id="author-dialog__id" type="hidden" name="id" required>
            <div>
                <label for="username">Username</label>
                <input id="author-dialog__username" type="text" name="username" required>
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
                <input id="author-dialog__password" type="password" name="password" required>
            </div>
            <div>
                <label for="firstname">Firstname</label>
                <input id="author-dialog__firstname" type="text" name="firstname" required>
            </div>
            <div>
                <label for="lastname">Lastname</label>
                <input id="author-dialog__lastname" type="text" name="lastname" required>
            </div>
            <div>
                <label for="bio">Bio</label>
                <textarea id="author-dialog__bio" name="bio" rows="4"></textarea required>
            </div>
            <div class="dialog__content__body__actions">
                <button class="button button-danger" type="button" onclick="onDialogClose('author-dialog')">Cancel</button>
                <button id="author-dialog__submit-button" class="button" type="submit">Add</button>
            </div>
        </form>
    </div>
</div>
<?php require_once 'components/gallery_dialog.php' ?>
<script src="image_picking_scripts.js"></script>
