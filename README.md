# MySqlDriver
A improved mysql driver for PhP
## Connect to your database
```php
$mysql = new ownMysql(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DATABASE);

$mysql->connect();
```
## Run a query
```php
$mysql->query("SELECT `id` FROM `user` WHERE `name` = 'Test';");
```
## Insert some data
```php
$mysql->insert(array(
	'id' => NULL,
	'name' => 'Thomas',
	'mail' => 'test@example.com'.
	'phone' => 1516474747
	), 'user');
```
## Error logging
If some query fails, the system will automaticly throw an exception with some further details.
If you want to disable those error messages, exclude `E_STRICT` from error logging.
