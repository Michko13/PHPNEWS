<div id="author-add-dialog" class="dialog">
    <div class="dialog__content" style="max-width: 440px">
        <div class="dialog__content__header">
            <h2 class="dialog__title">Přidat autora</h2>
            <span class="material-icons close-button" onclick="onDialogClose()">close</span>
        </div>
        <form class="dialog__content__body" action="author_add.php" method="post" enctype="multipart/form-data">
            <label for="username">Uživatelské jméno</label>
            <input type="text" name="username" required>
            <label for="surname">Heslo</label>
            <input type="password" name="password" required>
            <label for="name">Jméno</label>
            <input type="text" name="name" required>
            <label for="surname">Příjmení</label>
            <input type="text" name="surname" required>
            <label for="bio">Bio</label>
            <textarea name="bio" rows="4"></textarea required>
            <label for="picture">Profilová fotka</label>
            <input type="file" accept="image/png, image/jpeg" id="add-author-picture" name="picture" onchange="previewPicture()" required>
            <img id="picture-preview" src="#" style="display: none;">
            <div class="dialog__content__body__actions">
                <button class="button button-danger" type="button" onclick="onDialogClose()">Zrušit</button>
                <button class="button" type="submit">Přidat</button>
            </div>
        </form>
    </div>
</div>
<script>
    function previewPicture() {
        const fileReader = new FileReader();
        fileReader.readAsDataURL(document.getElementById("add-author-picture").files[0]);

        fileReader.onload = function (event) {
            const imgTag = document.getElementById("picture-preview");
            imgTag.style.display = "block";
            imgTag.src = event.target.result;
        };
    }
</script>