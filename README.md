# REST API для для работы с пользователями (реализовано внутри класса User с использованием класса DB):

## 1. Создание пользователя.
**Метод:** add
**Параметры:** tableName, valuesArray
**Описание:** Функция добавляет значения из массива ['столбец' => 'значение'] в указанную таблицу.
**Ответ:** true/false

**Метод:** register
**Параметры:** name, login, password
**Описание:** Функция принимает необходимые параметры и добавляет нового пользователя в БД через метод add (class DB).
**Ответ:** true/false

## 2. Обновление информации пользователя.
**Метод:** update
**Параметры:** tableName, valuesArray, filter
**Описание:** Функция обновляет строку из указанной таблицы, соответствующую сгенерированному через filter WHERE-запросу, значениями из массива ['столбец' => 'значение'].
**Ответ:** true/false

**Метод:** updateById
**Параметры:** id, valuesArray
**Описание:** Функция обновляет строку из таблицы пользователей, соответствующую id пользователя, значениями из массива ['столбец' => 'значение'] через метод update (class DB).
**Ответ:** true/false

## 3. Удаление пользователя.
**Метод:** delete
**Параметры:** tableName, filter
**Описание:** Функция удаляет строку из указанной таблицы, соответствующую сгенерированному через filter WHERE-запросу.
**Ответ:** true/false

**Метод:** deleteById
**Параметры:** id
**Описание:** Функция удаляет пользователя из таблицы пользователей по его id с помощью функции delete (class DB).
**Ответ:** true/false

## 4. Получение информации о пользователе.
**Метод:** get
**Параметры:** tableName, selectArray, filter (необязательный), orderArray (необязательный), distinct (необязательный)
**Описание:** Функция получает значения указанных в массиве selectArray столбцов из указанной таблицы. При необходимости возможно указать массив ['столбец' => 'значение'] filter для генерации WHERE-запроса, массив ['столбец' => 'способ сортировки'] orderArray для добавления сортировки и задать значение distinct (true/false) для добавления данного параметра в запрос.
**Ответ:** array/null

**Метод:** getById
**Параметры:** selectArray, id
**Описание:** Функция получает значения указанных в массиве selectArray столбцов из строки таблицы пользователей по соответствующему id через метод get (class DB).
**Ответ:** array/null

## 5. Авторизация пользователя.
**Метод:** isExist
**Параметры:** login
**Описание:** Функция проверяет, существует ли указанный логин в БД через метод get (class DB).
**Ответ:** true/false

**Метод:** authByPass
**Параметры:** login, password
**Описание:** Функция вызывает метод authorize, передавая внутрь id пользователя, найденный по логину и паролю через метод get (class DB).
**Ответ:** true/false

**Метод:** authorize
**Параметры:** userId
**Описание:** Функция записывает информацию о пользователе, найденную в БД по id пользователя, в суперглобальную переменную $_SESSION
**Ответ:** true

## Примечания.
Данные методы используются серверной частью AJAX-запросов.