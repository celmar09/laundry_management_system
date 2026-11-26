<?php
require_once __DIR__.'/config.php';
try {
    $server = new PDO('mysql:host='.DB_HOST.';charset=utf8mb4', DB_USER, DB_PASS, [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
    $server->exec("CREATE DATABASE IF NOT EXISTS `".DB_NAME."` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    $server->exec("USE `".DB_NAME."`");
    $sql = file_get_contents(__DIR__.'/database.sql');
    $server->exec($sql);
    $q=$server->prepare("SELECT id FROM users WHERE username=?");
    $q->execute(['ghelo123']);
    if (!$q->fetch()) {
        $q=$server->prepare("INSERT INTO users(name,username,password_hash,role) VALUES(?,?,?,?)");
        $q->execute(['System Administrator','ghelo123',password_hash('admin123', PASSWORD_DEFAULT),'super_admin']);
    }
    $server->exec("INSERT IGNORE INTO services(name,description,unit,price,active) VALUES
      ('Washing Only','Washing service','kg',35,1),
      ('Drying Only','Drying service','kg',25,1),
      ('Washing and Drying','Wash and dry','kg',55,1),
      ('Washing, Drying and Folding','Complete laundry care','kg',65,1),
      ('Additional Spinning','Extra spinning','kg',10,1),
      ('Folding','Folding service','kg',15,1)");
    echo '<h2>Laundry System installed successfully.</h2><p>Database: '.e(DB_NAME).'</p><p>Admin username: <b>ghelo123</b></p><p>Temporary password: <b>admin123</b></p><p><a href="login.php">Go to admin login</a></p><p>Delete or rename install.php after installation.</p>';
} catch(Throwable $e) { http_response_code(500); echo '<h2>Installation failed</h2><pre>'.e($e->getMessage()).'</pre>'; }
