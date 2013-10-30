Simple-Service-Locator
======================

Simple Symfony2 like Service locator

Helpful for managing different classes
if you are using PDO, you can do this:


```php
$config = array(
...
    'Db1' => array(
        'class' => 'PDO',
        '_construct' => array(
            'mysql:dbname=testdb;host=127.0.0.1',
            'dbuser',
            'dbpass',
        ),
    ),
    'Db2' => array(
        'class' => 'PDO',
        '_construct' => array(
            'pgsql:dbname=testdb;host=127.0.0.1',
            'dbuser',
            'dbpass',
        ),
    ),
...
);
```

If you need to set dependency you can config:

```php
$config = array(
...
    'Dep' => array(
        'class' => 'lib.Dependency', //path to dependency
        'c' => 'C',
        'b' => 'B',
        '_construct'=>'A'
    ),
    'Test' => array(
        'class' => 'lib.Test', //path to service
        '_construct'=>array('A','B'),
        'c'=>'@Dep' //dependency
    ),
...
);
```

have a nice day ;)
