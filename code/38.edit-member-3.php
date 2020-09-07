<?php

require __DIR__ . '/part/__connect db.php';
//$member_id = 3;
if (!empty($_POST['id'])) {
    $sql = "UPDATE `members` SET `mobile`=?, `hash`=?, `nickname`=? WHERE `id`=?";
    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        $_POST['mobile'],
        $_POST['avatar'],
        $_POST['nickname'],
        $_POST['id'],
    ]);

    if ($stmt->rowCount()) {
        $modified = true;
    }
}

$row = $pdo->query("SELECT * FROM members WHERE id=3")->fetch();

?>
<?php require __DIR__ . '/part/__html header.php'; ?>
<?php include __DIR__ . '/part/__navbar.php'; ?>
<div class="container">
    <?php if (isset($modified)) : ?>
        <div class="alert alert-success" role="alert">
            修改成功
        </div>
    <?php endif ?>
    <form action="" method="post">
        <input type="hidden" name="id" value="3">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" value="<?= $row['email'] ?>" disabled>
        </div>
        <div class="form-group">
            <label for="nickname">nickname</label>
            <input type="text" class="form-control" id="nickname" name="nickname" value="<?= $row['nickname'] ?>">
        </div>
        <div class="form-group">
            <label for="mobile">mobile</label>
            <input type="text" class="form-control" id="mobile" name="mobile" value="<?= $row['mobile'] ?>">
        </div>

        <button type="button" class="btn btn-warning" onclick="file_input.click()">更換頭貼</button>
        <input type="hidden" id="avatar" name="avatar" value="<?= $row['hash'] ?>">
        <img src="./photo/<?= $row['hash'] ?>" alt="" id="myimg" width="250px">
        <br>
        <div class="d-flex justify-content-end">
            <input type="submit" value="修改" class="btn btn-primary">
        </div>
    </form>

    <input type="file" id="file_input" style="display: none">

</div>
<?php include __DIR__ . '/part/__script.php'; ?>
<script>
    const file_input = document.querySelector('#file_input');
    const avatar = document.querySelector('#avatar');

    file_input.addEventListener('change', function(event) {
        console.log(file_input.files)
        const fd = new FormData();
        fd.append('myfile', file_input.files[0]);

        fetch('upload-single-api.php', {
                method: 'POST',
                body: fd
            })
            .then(r => r.json())
            .then(obj => {
                avatar.value = obj.filename;
                document.querySelector('#myimg').src = './photo/' + obj.filename;
            });
    });
</script>

<?php include __DIR__ . '/part/__html footer.php'; ?>