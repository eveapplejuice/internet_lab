<?

require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/DB.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/User.php';


$result = [
    'success' => 'N',
];

if (!empty($_POST['name']) &&
    !empty($_POST['login']) &&
    !empty($_POST['password']))
{
    $login = $_POST['login'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    $validation = [
        'login' => [
            'pattern' => '/[a-zA-Z0-9_-]+/',
            'error_text' => 'Недействительный логин',
            'value' => $login
        ],
        'name' => [
            'pattern' => '/[А-ЯЁа-яёA-Za-z]+/u',
            'error_text' => 'Недействительное имя пользователя',
            'value' => $name
        ]
    ];

    if (User::isExist($login)) {
        $result['inputs_errors']['login'] = 'Данный логин занят';
    } else {
        foreach ($validation as $inputName => $arValid) {
            if (!preg_match($arValid['pattern'], $arValid['value'])) {
                $result['inputs_errors'][$inputName] = $arValid['error_text'];
            }
        }
        // дополнительная проверка пароля
        if (strlen($password) < 4) $result['inputs_errors']['password'] = 'Пароль должен содержать больше 4 символов';
        elseif (!preg_match('/[a-zA-Z0-9_-]+/', $password)) $result['inputs_errors']['password'] = 'Недействительный пароль';
        if (!isset($result['inputs_errors'])) {
            if (User::register($login, $password, $name)) {
                $result['success'] = 'Y';
                User::authByPass($login, $password);
            }
        }
    }
} else {
    $result = [
        'error' => 'Обязательные поля должны быть заполнены'
    ];
}

echo json_encode($result);

