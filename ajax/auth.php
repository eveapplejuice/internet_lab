<?

require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/DB.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/User.php';


if (!empty($_POST['login']) && !empty($_POST['password'])) {
    $login = $_POST['login'];
    $password = $_POST['password'];
    if (preg_match('/^[a-zA-Z0-9\-_]+/', $login)) {
        if (User::isExist($login)) {
            if (User::authByPass($login, $password)) {
                echo 'Y';
            } else {
                echo '<div class="warning-label">Неправильный логин или пароль</div>';
            }
        } else {
            echo '<div class="warning-label">Неправильный логин или пароль</div>';
        }
    } else {
        echo '<div class="warning-label">Логин содержит недопустимые символы</div>';
    }
} else {
    echo '<div class="warning-label">Логин или пароль не должны быть пустыми</div>';
}
