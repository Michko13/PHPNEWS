<div id="category-add-dialog" class="dialog">
    <div class="dialog__content">
        <div class="dialog__content__header">
            <h2 class="dialog__title">Přidat kategorii</h2>
            <span class="material-icons close-button" onclick="onDialogClose()">close</span>
        </div>
        <form action="category_add.php" method="post" class="dialog__content__body">
            <label for="name">Jméno</label>
            <input type="text" name="name" required>
            <label for="description">Popisek</label>
            <textarea name="description" rows="4" required></textarea>
            <div class="dialog__content__body__actions">
                <button class="button button-danger" type="button" onclick="onDialogClose()">Zrušit</button>
                <button class="button" type="submit">Přidat</button>
            </div>
        </form>
    </div>
</div>