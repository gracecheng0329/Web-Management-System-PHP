<?php
require __DIR__ . '/part/__connect db.php';
header('Content-Type: application/json');
$path = __DIR__ . '/photo/';
$output = [
    'success' => false,
    'error' => 'no file uploaded',
    'filenames' => []
];

if (!empty($_FILES) and is_array($_FILES['myfiles']['name'])) {
    foreach ($_FILES['myfiles']['name'] as $k => $v) {
        $ext = '';
        $filename1 = md5($_FILES['myfiles']['name'][$k] . uniqid());
        switch ($_FILES['myfiles']['type'][$k]) {
            case 'image/png':
                $ext = '.png';
                break;
            case 'image/jpeg':
                $ext = '.jpg';
                break;
            case 'image/gif':
                $ext = '.gif';
                break;
        }
        if (empty($ext)) continue;
        $filename = $filename1 . $ext;
        if (move_uploaded_file(
            $_FILES['myfiles']['tmp_name'][$k],
            $path . $filename1
        )) {
            $output['filenames'][] = $filename;
            $output['success'] = true;
            $output['error'] = '';
        }
    }
}
echo json_encode($output, JSON_UNESCAPED_UNICODE);
