<?php
require_once 'services/AuthService.php';
AuthService::StartSession();

$current_path = substr($_SERVER["SCRIPT_NAME"], strrpos($_SERVER["SCRIPT_NAME"], "/") + 1);
?>
<header>
    <nav>
        <div class="nav__links">
            <a class="nav__logo" href="index.php">PHPNEWS</a>
            <a class="nav__link <?php echo($current_path == "index.php" ? "nav__selected" : "") ?>" href="index.php">HOME</a>
            <a class="nav__link <?php echo($current_path == "categories.php" ? "nav__selected" : "") ?>" href="categories.php">CATEGORIES</a>
            <a class="nav__link <?php echo($current_path == "authors.php" ? "nav__selected" : "") ?>" href="authors.php">AUTHORS</a>
        </div>
        <div class="nav__login">
            <?php if (isset($_SESSION["username"])): ?>
                <a href="administration_index.php" class="<?php echo(str_starts_with($current_path, "administration") ? "nav__selected" : "") ?>">Administration</a>
                <a href="article_add.php" class="<?php echo($current_path == "article_add.php" ? "nav__selected" : "") ?>">Add article</a>
                <a href="user_profile.php" class="nav__user">
                    <img src="<?= $_SESSION["image"] ?>"/>
                    <span><?= $_SESSION["username"] ?></span>
                </a>
            <?php else: ?>
                <a href="login.php">LOGIN</a>
            <?php endif; ?>
        </div>
        <div id="nav__mobile-menu" class="hide">
            <a href="index.php" class="nav__link">HOME</a>
            <a href="categories.php" class="nav__link">CATEGORIES</a>
            <a href="authors.php" class="nav__link">AUTHORS</a>
            <div id="mobile-menu__horizontal-line"></div>
            <?php if (isset($_SESSION["username"])): ?>
                <a href="administration_index.php">Administration</a>
                <a href="article_add.php">Add article</a>
                <a href="user_profile.php" class="nav__user">
                    <img src="<?= $_SESSION["image"] ?>"/>
                    <span><?= $_SESSION["username"] ?></span>
                </a>
            <?php else: ?>
                <a href="login.php">LOGIN</a>
            <?php endif; ?>
        </div>
        <div id="hamburger">
            <span class="hamburger__bar"></span>
            <span class="hamburger__bar"></span>
            <span class="hamburger__bar"></span>
        </div>
    </nav>
    <script>
        const hamburgerBtn = document.querySelector("#hamburger");
        const mobileMenu = document.querySelector("#nav__mobile-menu");
        const marginTop = <?= isset($_SESSION['username']) ? "'265px'" : "'174px'" ?>

        hamburgerBtn.addEventListener("click", () => {
            mobileMenu.classList.contains("hide") ? mobileMenu.classList.remove("hide") : mobileMenu.classList.add("hide");
            const page = document.querySelector(".page");
            page.style.marginTop !== marginTop ? page.style.marginTop = marginTop : page.style.marginTop = "0";
        })
    </script>
</header>