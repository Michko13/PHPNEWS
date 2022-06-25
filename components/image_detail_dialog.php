<div id="image-detail-dialog" class="dialog">
    <div class="dialog__content">
        <div class="dialog__content__header">
            <h2 class="dialog__title">Image detail</span></h2>
            <span class="material-icons close-button" onclick="onDialogClose('image-detail-dialog')">close</span>
        </div>
        <div class="dialog__content__body">
            <div id="image-detail-container">
                <div id="image-detail__src-container">
                    <img src="" id="image-detail__src"/>
                </div>
                <div id="image-detail__metadata">
                    <div id="image-detail__metadata__title">
                    </div>
                    <div id="image-detail__metadata__date-added">
                    </div>
                    <div id="image-detail__metadata__file-name">
                    </div>
                    <div id="image-detail__metadata__file-type">
                    </div>
                    <div id="image-detail__metadata__file-size">
                    </div>
                    <div id="image-detail__metadata__resolution">
                    </div>
                </div>
            </div>
            <div class="dialog__content__body__actions" id="image-detail-dialog__actions">
                <button class="button button-danger" onclick="onDialogClose('image-detail-dialog')">Cancel</button>
                <button class="button" id="choose-button">Choose</button>
            </div>
            <div class="dialog__content__body__actions" id="image-detail-dialog__administration-actions">
                <button class="button button-danger" id="delete-button">Delete</button>
                <button class="button" onclick="onDialogClose('image-detail-dialog')">Go back</button>
            </div>
        </div>
    </div>
</div>