<div id="category-add-dialog" class="dialog">
    <div class="dialog__content">
        <div class="dialog__content__header">
            <h2 class="dialog__title">Add new category</h2>
            <span class="material-icons close-button" onclick="onDialogClose()">close</span>
        </div>
        <form action="category_add.php" method="post" class="dialog__content__body">
            <div>
                <label for="name">Name</label>
                <input type="text" name="name" required>
            </div>
            <div>
                <label for="description">Description</label>
                <textarea name="description" rows="4" required></textarea>
            </div>
            <div class="dialog__content__body__actions">
                <button class="button button-danger" type="button" onclick="onDialogClose()">Cancel</button>
                <button class="button" type="submit">Add</button>
            </div>
        </form>
    </div>
</div>