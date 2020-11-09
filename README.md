MarlinDatabase

## Использование Database()


#### **query() - Выполнение всех запросов в базу данных с неподготовленным SQL запросом.**

<h4>Принимает</h4> 
1.sql - SQL запрос (тип строка).
2.params - массив с параметрами для SQL запроса.
query(string $sql [$params])

<h4>Использования:</h4>
$sql = "SELECT * FROM users WHERE id = ?";
$params = [ 'id' => 'user_id' ];
$users = $db->query($sql, $params);

<h4>Возврашает:</h4>

PDO объект с результатом


#### **results() - Возвращает результат из выполненного SQL запроса.Метод используется после выполнения метода query().**

<h4> Не принимает никаких параметров </h4> 

<h4>Использования:</h4>

$sql = "SELECT * FROM users WHERE id = ?";
$params = [ 'id' => 'user_id' ];
$users = $db->query($sql, $params)->results();

<h4>Возврашает:</h4>

PDO объект с результатом или NULL в случае возникновения ошибки.

#### **insert() - Подготовка и выполниние SQL запроса для сохранения данных в бд**

<h4>Принимает</h4> 
1.table - Название таблицы.
2.params - массив с параметрами для SQL запроса.
insert(string $table, [$params])

<h4>Использования:</h4>

$params = ['name' => 'email', 'email' => 'user_email'];<br>
$users = $db->insert('users', $params);

<h4>Возврашает:</h4>

Возвращает TRUE или FALSE в случае возникновения ошибки.

#### **update() - Подготовка и выполниние SQL запроса для обновления данных в базе данных по ID**

<h4>Принимает</h4> 
1.table - Название таблицы.
2.id(тип число).
3.params - массив с параметрами для SQL запроса. В качестве параметров передаётся ключ (имя столбца в базе данных) и значение.
update($table,  $id [$params])

<h4>Использования:</h4>
$params = ['name' => 'email', 'email' => 'user_email'];
$id = 1;
$users = $db->update('users', $id, $params)

<h4>Возврашает:</h4>
Возвращает TRUE или FALSE в случае возникновения ошибки.

#### **delete() - Подготовка и выполниние SQL запроса для удаления данных из базе данных по ID**

<h4>Принимает</h4> 
1.table - Название таблицы.
2.id(тип число).
query($table,$id)

<h4>Использования:</h4>
$id = 1;
$users = $db->delete('users', $id);

<h4>Возврашает:</h4>
Возвращает TRUE или FALSE в случае возникновения ошибки.

#### **first() - Возвращает первый элемент из выполненного SQL запроса**

<h4> Не принимает никаких параметров </h4> 

<h4>Использования:</h4>
$users = $db->query('SELECT * FROM users')->first();

<h4>Возврашает:</h4>

Возвращает PDO объект с результатом или пустой массив в случае если нету никаких данных.

#### **count() - Возвращает количество элементов из выполненного SQL запроса**

<h4> Не принимает никаких параметров </h4> 

<h4>Использования:</h4>
$users = $db->query('SELECT * FROM users')->count();

<h4>Возврашает:</h4>

Возвращает количество элементов или false в случае если нету никаких данных.


