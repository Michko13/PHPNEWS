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
    $sql = 'SELECT * FROM author WHERE username = :username AND password = :password';

    $result = DatabaseManager::get_instance()->selectOne($sql, [
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
        <h2>Přihlašte se</h2>
        <form action="" method="post">
            <div>
                <label for="username">Uživatelské jméno</label>
                <input type="text" name="username" id="username">
            </div>
            <div>
                <label for="password">Heslo</label>
                <input type="password" name="password" id="password">
            </div>
            <button class="button" type="submit">Přihlásit se</button>
        </form>
        <div class="error"><?= $error ?></div>
    </div>
</div>
</body>