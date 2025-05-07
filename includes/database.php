<?php
$db = new PDO('mysql:host=localhost;dbname=tanulok;charset=utf8', 
             'root', 
             '', 
             [
                 PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                 PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
             ]);

// Táblák létrehozása
$db->exec("CREATE TABLE IF NOT EXISTS students (
    id INT PRIMARY KEY AUTO_INCREMENT,
    om_azonosito CHAR(11) UNIQUE NOT NULL,
    lastname VARCHAR(50) NOT NULL,
    firstname VARCHAR(50) NOT NULL,
    birthdate DATE NOT NULL,
    class VARCHAR(10) NOT NULL
)");
