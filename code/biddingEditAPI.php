<?php
require __DIR__ . '/parts/__connect db.php';
require __DIR__ . '/parts/__admin_required.php';

header('Content-Type: application/json');

$output = [
    'success' => false,
    'postData' => $_POST,
    'code' => 0,
    'error' => ''
];

if (empty($_POST['sid'])) {
    $output['code'] = 405;
    $output['error'] = '沒有 sid';
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

if (!preg_match('^[A-Z]', $_POST['productName'])) {
    $output['code'] = 410;
    $output['error'] = '請輸入正確品名';
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

if (!preg_match('\d', $_POST['startedPrice'])) {
    $output['code'] = 420;
    $output['error'] = '請輸入正確金額';
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}
if (!preg_match('\d', $_POST['bidPrice'])) {
    $output['code'] = 430;
    $output['error'] = '請輸入正確金額';
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}
if (!preg_match('\d', $_POST['soldPrice'])) {
    $output['code'] = 440;
    $output['error'] = '請輸入正確金額';
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

// roduct_sid`, `membership_sid`, `startingDate`, `startingTime`, `bidDate`, `bidTime`, `startedPrice(NT)`, `bidPrice`, `soldPrice(NT)`, 
$sql = "UPDATE `bidding` SET 
    `productName`=?,
    `startingDate`=?,
    `startingTime`=?,
    `bidDate`=?,
    `bidTime`=?
    `startedPrice`=?
    `bidPrice`=?
    `soldPrice`=?
    WHERE `sid`=?";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    $_POST['productName'],
    $_POST['startingDate'],
    $_POST['startingTime'],
    $_POST['bidDate'],
    $_POST['bidTime'],
    $_POST['startedPrice'],
    $_POST['bidPrice'],
    $_POST['soldPrice'],
    $_POST['sid'],
]);

if ($stmt->rowCount()) {
    $output['success'] = true;
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);
