<?php
require_once 'components/header.php';
require_once 'autoloader.php';
AuthService::InitAuth();

?>
<body>
<?php require_once 'components/navbar.php' ?>
<div id="profile-page" class="page">
    <h1 class="page__title">Profile <a href="logout.php" class="button button-danger" style="font-size: 16px;">Logout</a></h1>
    <div id="profile-page__user-info">
        <form action="author_edit.php" method="post" enctype="multipart/form-data">
            <div class="profile-page__form__left-side">
                <img id="profile-page__picture" src="<?= $_SESSION["picture"] ?>"/>
                <label class="button">
                    <input type="file" accept="image/png, image/jpeg" id="add-user-picture-input" name="picture" onchange="previewImage()">
                    Add new profile picture
                </label>
            </div>
            <div class="profile-page_form__right-side">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" value="<?= $_SESSION['username'] ?>">
                <label for="role">Role</label>
                <input type="text" name="surname" id="surname" value="<?= $_SESSION['is_admin'] == 1 ? "Admin" : "Editor" ?>" disabled>
                <label for="name">Firstname</label>
                <input type="text" name="name" id="name" value="<?= $_SESSION['name'] ?>">
                <label for="surname">Surname</label>
                <input type="text" name="surname" id="surname" value="<?= $_SESSION['surname'] ?>">
                <label for="bio">Bio</label>
                <textarea name="bio" rows="4" id="bio"><?= $_SESSION['bio'] ?></textarea>
                <button class="button" type="submit">Save</button>
            </div>
        </form>
    </div>
</div>
</body>
<script>
    function previewImage() {
        const fileReader = new FileReader();
        fileReader.readAsDataURL(document.getElementById("add-user-picture-input").files[0]);

        fileReader.onload = function (event) {
            const imgTag = document.getElementById("profile-page__picture");
            imgTag.src = event.target.result;
        };
    }
</script>