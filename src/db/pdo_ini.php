<?php

//Sets the connection and switches to database
$config = require_once './config.php';

try {
    if (!in_array("mysql", PDO::getAvailableDrivers(), true)) {
        die("Cannot work without a proper database setting up");
    }
} catch (PDOException $pdoEx) {
    die("Database Error .. Details :<br /> {$pdoEx->getMessage()}");
}

try {
    $pdo = new \PDO(
    //    sprintf('mysql:host=%s;dbname=%s', $config['host'], $config['dbname']),
        sprintf('mysql:host=%s', $config['host']),
        $config['user'],
        $config['pass'],
        array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING)
    );
    // create if not exists database
    $pdo->exec(sprintf('CREATE DATABASE IF NOT EXISTS %s ;', $config['dbname']));
    //Use database
    $pdo->exec(sprintf('USE %s ;', $config['dbname']));
} catch (PDOException $e) {
    die("DB ERROR: " . $e->getMessage());
}
