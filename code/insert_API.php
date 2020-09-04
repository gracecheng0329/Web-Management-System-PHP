<?php

require __DIR__ . '/parts/__connect_db.php';
require __DIR__ . '/parts/__admin_required.php';
header('Content-Type: application/json');

$output = [
    'success' => false,
    'postData' => $_POST,
    'code' => 0,
    'error' => ''
];

if (!preg_match('^[A-Z]', $_POST['productName'])) {
    $output['code'] = 410;
    $output['error'] = '請輸入正確品名';
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}
if (!preg_match('^[A-Z]', $_POST['designer'])) {
    $output['code'] = 420;
    $output['error'] = '請輸入正確設計師';
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}
if (!preg_match('^[A-Z]', $_POST['origin'])) {
    $output['code'] = 430;
    $output['error'] = '請輸入正確產地';
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}
if (!preg_match('\d', $_POST['price'])) {
    $output['code'] = 440;
    $output['error'] = '請輸入正確金額';
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

$sql = "INSERT INTO `products`(`productName`, `designer`, `description`, `Origin`, `Dimensions`, `detailPics`, `price`) VALUES (?,?,?,?,?,?,?)";
// MySQL只能用雙引號

$stmt = $pdo->prepare($sql);
$stmt->execute([
    $_POST['productName'],
    $_POST['designer'],
    $_POST['description'],
    $_POST['Origin'],
    $_POST['Dimensions'],
    $_POST['detailPics'],
    $_POST['price']
]);

if ($stmt->rowCount()) {
    $output['success'] = true;
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);
