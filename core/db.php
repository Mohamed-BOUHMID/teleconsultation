<?php
    require __DIR__ . "../../vendor/Medoo/Medoo.php";
    use Medoo\Medoo;
    $db = new Medoo([
        'database_type' => 'mysql',
        'database_name' => 'teleconsultation',
        'server' => 'localhost',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8',


        'error' => PDO::ERRMODE_SILENT,
        'option' => [
            PDO::ATTR_CASE => PDO::CASE_NATURAL
        ]
    ]);
