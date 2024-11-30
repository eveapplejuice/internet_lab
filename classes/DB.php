<?

class DB
{
    const host = 'localhost';
    const user = 'root';
    const password = 'root';
    const dbname = 'internet_lab';
    const table = 'user';

    public static function connectDB(): false|mysqli
    {
        return mysqli_connect(self::host, self::user, self::password, self::dbname);
    }

    /**
     * WHERE ['столбец' => 'значение']
     * ORDER BY ['столбец' => 'способ сортировки'];
     */
    public static function get($tableName, $selectArray, $filter = [], $orderArray = [], $distinct = false)
    {
        $query = 'SELECT ';
        if ($distinct) $query .= 'DISTINCT ';

        $query .= implode(', ', $selectArray) . ' FROM ' . $tableName;

        if ($filter) {
            $query .= ' WHERE ' . self::generateWhereRow($filter);
        }
        if ($orderArray) {
            $query .= ' ORDER BY ' . self::generateOrderRow($orderArray);
        }
        $res_query = mysqli_query(self::connectDB(), $query) or die(mysqli_error(self::connectDB()));
        return mysqli_fetch_assoc($res_query);
    }

    /**
     * WHERE ['столбец' => 'значение']
     * ORDER BY ['столбец' => 'способ сортировки'];
    */
    public static function getAll($tableName, $selectArray, $filter = [], $orderArray = [], $distinct = false)
    {
        $query = 'SELECT ';
        if ($distinct) $query .= 'DISTINCT ';

        $query .= implode(', ', $selectArray) . ' FROM ' . $tableName;

        if ($filter) {
            $query .= ' WHERE ' . self::generateWhereRow($filter);
        }
        if ($orderArray) {
            $query .= ' ORDER BY ' . self::generateOrderRow($orderArray);
        }
        $res_query = mysqli_query(self::connectDB(), $query) or die(mysqli_error(self::connectDB()));
        $result = [];
        while ($row = mysqli_fetch_assoc($res_query)) {
            $result[] = $row;
        }
        return $result;
    }

    public static function delete($tableName, $filter)
    {
        $query = 'DELETE FROM ' .  $tableName . ' WHERE ' . self::generateWhereRow($filter);
        return mysqli_query(self::connectDB(), $query) or die(mysqli_error(self::connectDB()));
    }

    /**
     * SET ['столбец' => 'значение']
     */
    public static function add($tableName, $valuesArray)
    {
        $query = 'INSERT INTO ' . $tableName . ' SET ' . self::generateSetRow($valuesArray);
        return mysqli_query(self::connectDB(),$query) or die(mysqli_error(self::connectDB()));
    }

    public static function update($tableName, $valuesArray, $filter)
    {
        $query = 'UPDATE ' . $tableName . ' SET ' . self::generateSetRow($valuesArray) . ' WHERE ' . self::generateWhereRow($filter);
        return mysqli_query(self::connectDB(),$query) or die(mysqli_error(self::connectDB()));
    }

    public static function generateWhereRow($array): string
    {
        $row = '';
        foreach ($array as $key => $value)
        {
            if ($row == '') {
                $row .= $key . ' = ';
            } else {
                $row .= ' AND ' . $key . ' = ';
            }
            if (gettype($value) == 'integer') {
                $row .= $value;
            } else {
                $row .= '"' . $value . '"';
            }
        }
        return $row;
    }

    public static function generateOrderRow($array): string
    {
        $row = '';
        foreach ($array as $key => $value) {
            if ($row == '') {
                $row .= $key . '  ' . $value;
            } else {
                $row .= ', ' . $key . '  ' . $value;
            }
        }
        return $row;
    }
    public static function generateSetRow($array): string
    {
        $row = '';
        foreach ($array as $key => $value) {
            if ($row == '') {
                $row .= $key . ' = ';
            } else {
                $row .= ', ' . $key . ' = ';
            }
            if (gettype($value) == 'integer') {
                $row .= $value;
            } else {
                $row .= '"' . htmlspecialchars($value) . '"';
            }
        }
        return $row;
    }

}