<?php
require_once 'components/header.php';
require_once 'autoloader.php';
AuthService::StartSession();

$error = "";

if(isset($_SESSION['username'])) {
    header("Location: index.php");
    die();
}

if(!empty($_POST['username']) && !empty($_POST['password'])) {
    $sql = 'SELECT author.id, author.username, author.firstname, author.lastname, author.bio, author.is_admin,
            image.location AS profile_image, image.id as profile_image_id
            FROM author
            INNER JOIN image on image.id = author.image_id
            WHERE username = :username AND password = :password';

    $result = DatabaseService::get_instance()->selectOne($sql, [
        ':username' => $_POST['username'],
        ':password' => hash("sha256", $_POST['password'])
    ]);

    if(!empty($result)) {
        $_SESSION = $result;
        $_SESSION['logged_in'] = time();
        header("Location: index.php");
        die();
    } else {
        $error = "Neznámá kombinace uživatelského jména a hesla ";
    }
}
?>
<body>
<div id="login-page">
    <div class="form">
        <h2>Login</h2>
        <form action="" method="post">
            <div>
                <label for="username">Username</label>
                <input type="text" name="username" id="username">
            </div>
            <div>
                <label for="password">Password</label>
                <input type="password" name="password" id="password">
            </div>
            <button class="button" type="submit">Login</button>
        </form>
        <div class="error"><?= $error ?></div>
    </div>
</div>
</body>