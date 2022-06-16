<div id="category-dialog" class="dialog">
    <div class="dialog__content">
        <div class="dialog__content__header">
            <h2 id="category-dialog__title" class="dialog__title"></h2>
            <span class="material-icons close-button" onclick="onDialogClose('category-dialog')">close</span>
        </div>
        <form id="category-dialog__form" method="post" class="dialog__content__body">
            <input id="category-dialog__id" type="hidden" name="id" required>
            <div>
                <label for="name">Name</label>
                <input id="category-dialog__name" type="text" name="name" required>
            </div>
            <div>
                <label for="description">Description</label>
                <textarea id="category-dialog__description" name="description" rows="4" required></textarea>
            </div>
            <div class="dialog__content__body__actions">
                <button class="button button-danger" type="button" onclick="onDialogClose('category-dialog')">Cancel</button>
                <button id="category-dialog__submit-button" class="button" type="submit">Add</button>
            </div>
        </form>
    </div>
</div>