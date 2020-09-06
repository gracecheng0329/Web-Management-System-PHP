<?php

$db_host = "localhost"; //要連線到不同台電腦要打IP或Domain name
$db_name = "project"; //資料表名稱
$db_user = "grace";
$db_pass = "12345";

$dsn = "mysql:host={$db_host};dbname={$db_name}"; //Data Source Name

// ATTR = attribute
$pdo_options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"
];
$pdo = new PDO($dsn, $db_user, $db_pass, $pdo_options);

// 連線到MySQL

// 若要使用web_root建立絕對路徑,要在兩邊檔案打以下指令連接起來
// require __DIR__ . '/part/__connect db.php';

define('WEB_ROOT', '/project');

if (!isset($_SESSION)) {
    session_start();
}
