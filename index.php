<?
require_once 'classes/FileManager.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/DB.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/User.php';
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <? FileManager::linkCSS('/vendor/style.css');?>
    <script src="/vendor/js/jquery-3.7.1.min.js"></script>
    <title>Тестовое задание</title>
</head>
<body>
    <div class="wrapper">
        <div class="row">
            <table class="users-table">
                <tr>
                    <td><b>Имя пользователя</b></td>
                    <td><b>Логин</b></td>
                </tr>
                <?
                $users = User::getAllUsers();
                foreach ($users as $user) {?>
                    <tr data-user-id="<?=$user['id'];?>" class="user-info-tr">
                        <td><?=$user['name']?></td>
                        <td><?=$user['login']?></td>
                    </tr>
                    <?}
                require_once 'vendor/components/user_info/template.php';
                ?>
            </table>
        </div>
        <div class="row">
            <div id="register-btn" class="btn">Зарегистрироваться</div>
            <? require_once 'vendor/components/registration/template.php'?>

            <div id="auth-btn" class="btn">Авторизоваться</div>
            <? require_once 'vendor/components/authorize/template.php'?>
        </div>
    </div>
    <?
    if (isset($_SESSION['USER']['ID'])) {
        ?><div>Текущий пользователь:  <?=$_SESSION['USER']['LOGIN'];?></div><?
    } ?>
    <? FileManager::linkJS('/vendor/js/script.js'); ?>
</body>
</html>
