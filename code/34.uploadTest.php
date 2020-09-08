<?php
require __DIR__ . '/parts/__connect_db.php';

if (!empty($_FILES) && !empty($_FILES['myfile']['name'])) {
    // header('Content-Type: text/plain');
    echo '<pre>';
    var_dump($_FILES);
    echo '</pre>';
    move_uploaded_file(
        $_FILES['myfile']['tmp_name'],
        __DIR__ . '/upload/' . $_FILES['myfile']['name']
    );
    echo "<img src='./upload/{$_FILES['myfile']['name']}'>";
    exit;
}

?>

<?php require __DIR__ . '/parts/__html_head.php'; ?>
<?php include __DIR__ . '/parts/__navbar.php'; ?>
<div class="container">
    <!-- 傳送圖檔一定要用post傳送,並加上enctype="multipart/form-data -->
    <form action="" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="exampleFormControlFile1">Example file input</label>
            <!-- image/*可以接收各種類型的檔案 -->
            <input type="file" class="form-control-file" id="myfile" name="myfile" accept="image/*">
        </div>
        <input class="btn btn-primary" type="submit" value="上傳">
    </form>

</div>
<?php include __DIR__ . '/parts/__scripts.php'; ?>
<?php include __DIR__ . '/parts/__html_foot.php'; ?>