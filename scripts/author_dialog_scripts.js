function openAuthorEditDialog(id, username, image, imageId, firstname, lastname, bio) {
    authorDialogTitle.innerText = "Edit author";
    authorDialogForm.action = "author_edit.php";
    authorDialogSubmitButton.innerText = "Edit";
    authorDialog.style.display = "flex";
    authorDialogId.value = id;
    authorDialogUsername.value = username;
    authorDialogImageLocation.src = image;
    authorDialogImageLocation.style.display = "block";
    authorDialogImageId.value = imageId;
    authorDialogPassword.required = false;
    authorDialogFirstname.value = firstname;
    authorDialogLastname.value = lastname;
    authorDialogBio.value = bio;
}
