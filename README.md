# Mysqli
Before you can get content out of your MySQL database, you must know how to establish a connection to MySQL from inside a PHP script. To perform basic queries from within MySQL is very easy. This article will show you how to get up and running.

Let's get started. The first thing to do is connect to the database.The function to connect to MySQL is called mysql_connect. This function returns a resource which is a pointer to the database connection. It's also called a database handle, and we'll use it in later functions. Don't forget to replace your connection details.

------------
```php
require_once(db.php);

$db = DB::getInstance();
$db->query("SELECT * FROM `TABLE`");
```

------------

# PDO

```php
require('db.pdo.php');
$db = DB::getInstance();

    $visitor_data = $db->query("SELECT * FROM users WHERE id = :id", array(
      'id' => 5  
    ));
```
