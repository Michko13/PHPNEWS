function onDialogClose() {
    Array.from(document.querySelectorAll(".dialog")).forEach(dialog => {
        dialog.style.display = "none";
    })
}