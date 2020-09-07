<?php
require __DIR__ . '/part/__connect db.php';

if (!empty($_FILES) && !empty($_FILES['myfile']['name'])) {
    // header('Content-Type: text/plain');
    echo '<pre>';
    var_dump($_FILES);
    echo '</pre>';
    move_uploaded_file(
        // foreach ($cates as  $v) :
        // for($i=0;i<myfile->length;i++){
            $_FILES['myfile']['tmp_name'],
        __DIR__ . '/photo/' . $_FILES['myfile']['name']
    );
    echo "<img src='./photo/{$_FILES['myfile']['name']}'>";
        // }
        
    exit;
}

?>

<?php require __DIR__ . '/part/__html header.php'; ?>
<?php include __DIR__ . '/part/__navbar.php'; ?>
<div class="container">
    <form action="" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="exampleFormControlFile1">Example file input</label>
            <input type="file" class="form-control-file" id="myfile" name="myfile[]" multiple accept="image/*">
        </div>
        <input class="btn btn-primary" type="submit" value="上傳">
    </form>

</div>
<?php include __DIR__ . '/part/__script.php'; ?>
<?php include __DIR__ . '/part/__html footer.php'; ?>