<div id="category-edit-dialog" class="dialog">
    <div class="dialog__content">
        <div class="dialog__content__header">
            <h2 class="dialog__title">Upravit kategorii</h2>
            <span class="material-icons close-button" onclick="onDialogClose()">close</span>
        </div>
        <form action="category_edit.php" method="post" class="dialog__content__body">
            <input type="hidden" name="id" id="category-edit-id" required>
            <label for="name">Jméno</label>
            <input type="text" name="name" id="category-edit-name" required>
            <label for="description">Popisek</label>
            <textarea name="description" rows="4" id="category-edit-description" required></textarea>
            <div class="dialog__content__body__actions">
                <button class="button button-danger" type="button" onclick="onDialogClose()">Zrušit</button>
                <button class="button" type="submit">Uložit</button>
            </div>
        </form>
    </div>
</div>