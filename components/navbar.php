<?php

require_once 'repositories/AuthService.php';
AuthService::StartSession();

$current_path = substr($_SERVER["SCRIPT_NAME"], strrpos($_SERVER["SCRIPT_NAME"], "/") + 1);
?>
<header>
    <nav>
        <div class="nav__links">
            <a class="nav__logo" href="index.php">SSSVTNEWS</a>
            <a class="nav__link <?php echo($current_path == "index.php" ? "nav__selected" : "") ?>" href="index.php">ZPRÁVY</a>
            <a class="nav__link <?php echo($current_path == "categories.php" ? "nav__selected" : "") ?>" href="categories.php">KATEGORIE</a>
            <a class="nav__link <?php echo($current_path == "authors.php" ? "nav__selected" : "") ?>" href="authors.php">AUTOŘI</a>
        </div>
        <div class="nav__login">
            <?php if (isset($_SESSION["username"])): ?>
                <a href="administration.php" class="<?php echo($current_path == "administration.php" ? "nav__selected" : "") ?>">Administrace</a>
                <a href="article_add.php" class="<?php echo($current_path == "article_add.php" ? "nav__selected" : "") ?>">Přidat článek</a>
                <a href="user_profile.php" class="nav__user">
                    <img src="<?= $_SESSION["picture"] ?>"/>
                    <span><?= $_SESSION["username"] ?></span>
                </a>
            <?php else: ?>
                <a href="login.php">PŘÍHLÁŠENÍ</a>
            <?php endif; ?>
        </div>
        <div id="nav__mobile-menu" class="hide">
            <a href="index.php" class="nav__link">ZPRÁVY</a>
            <a href="categories.php" class="nav__link">KATEGORIE</a>
            <a href="authors.php" class="nav__link">AUTOŘI</a>
            <div id="mobile-menu__horizontal-line"></div>
            <?php if (isset($_SESSION["username"])): ?>
                <a href="administration.php">Administrace</a>
                <a href="article_add.php">Přidat článek</a>
                <a href="user_profile.php" class="nav__user">
                    <img src="<?= $_SESSION["picture"] ?>"/>
                    <span><?= $_SESSION["username"] ?></span>
                </a>
            <?php else: ?>
                <a href="login.php">PŘÍHLÁŠENÍ</a>
            <?php endif; ?>
        </div>
        <div id="hamburger">
            <span class="hamburger__bar"></span>
            <span class="hamburger__bar"></span>
            <span class="hamburger__bar"></span>
        </div>
    </nav>
    <script>
        const hamburgerBtn = document.getElementById("hamburger");
        const mobileMenu = document.getElementById("nav__mobile-menu");
        hamburgerBtn.addEventListener("click", () => {
            mobileMenu.classList.contains("hide") ? mobileMenu.classList.remove("hide") : mobileMenu.classList.add("hide");
        })
    </script>
</header>