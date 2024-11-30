<?

class User
{
    const tableName = 'users';

    /**
     * @param $selectArray - массив искомых столбцов
     */
    public static function getById($selectArray, $id): false|array|null
    {
        return \DB::get(self::tableName, $selectArray, ['id' => $id], $orderArray = [], $distinct = false);
    }

    public static function deleteById($id): ?bool
    {
        return \DB::delete(self::tableName, ['id' => $id]);
    }
    /**
     * @param $valuesArray - формат ['столбец' => 'значение']
    */
    public static function updateById($id, $valuesArray): ?bool
    {
        return \DB::update(self::tableName, $valuesArray, ['id' => $id]);
    }

    public static function isExist($login): bool
    {
        if (DB::get(self::tableName, ['id'], ['login' => $login])) {
            return true;
        } else {
            return false;
        }
    }
    public static function authByPass($login, $password): bool
    {
        if ($idArray = DB::get(self::tableName, ['id'], ['login' => $login, 'password' => $password])) {
            return self::autorize(+$idArray['id']);
        } else {
            return false;
        }
    }
    public static function autorize($userId): true
    {
        $user_info = self::getById(['*'], $userId);
        $_SESSION['USER'] = [
            'ID' => $user_info['id'],
            'LOGIN' => $user_info['login'],
            'NAME' => $user_info['name']
        ];
        return true;
    }

    public static function isAuthorized(): bool
    {
        if (isset($_SESSION['USER']) && $_SESSION['USER']['ID']) {
            return true;
        }
        return false;
    }

    public static function register($login, $password, $name): bool
    {
        return DB::add(self::tableName, [
            'login' => $login,
            'password' => $password,
            'name' => $name
        ]);
    }

    public static function getAllUsers(): array
    {
        return DB::getAll(self::tableName, ['*']);
    }
}
