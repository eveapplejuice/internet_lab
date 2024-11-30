<?
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/DB.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/User.php';

$result = [
'success' => 'N',
];

if (!empty($_POST['action']))
{
    if ($_POST['action'] == 'open_modal') {
        if (!empty($_POST['id']))
        {
            $id = $_POST['id'];
            if (User::getById(['name', 'login'], $id)) {
                $result['success'] = 'Y';
                $result['user_info'] = User::getById(['*'], $id);
            }
        }
    }
    elseif ($_POST['action'] == 'change') {
        if (!empty($_POST['id']) && !empty($_POST['name']) && !empty($_POST['login'])) {
            if (User::updateById($_POST['id'], ['name' => $_POST['name'], 'login' => $_POST['login']])) {
                $result['success'] = 'Y';
            }
        } else {
            $result['error'] = 'Все поля должны быть заполнены';
        }
    }
    elseif ($_POST['action'] == 'delete') {
        if (!empty($_POST['id'])) {
            if (User::deleteById($_POST['id'])) {
                $result['success'] = 'Y';
                unset($_SESSION['USER']);
            }
        }
    }
}


echo json_encode($result);