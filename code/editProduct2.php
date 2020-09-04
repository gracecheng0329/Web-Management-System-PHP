<?php

require __DIR__ . '/part/__connect db.php';
if (!empty($_POST['sid'])) {
    $sql = "UPDATE `products` SET `bookname`=?, `category_sid`=?, `price`=?, `introduction`=? WHERE `sid`=?";
    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        $_POST['bookname'],
        $_POST['category_sid'],
        $_POST['price'],
        json_encode($_POST['hobbies'] ?? []),
        // '[3,6]',
        $_POST['sid'],
    ]);

    if ($stmt->rowCount()) {
        $modified = true;
    }
}

$row = $pdo->query("SELECT * FROM products WHERE sid=2")->fetch();
$h_sids = json_decode($row['introduction'], true);
if ($h_sids === null)
    $h_sids = [];

$c_sql = "SELECT * FROM categories WHERE parent_sid=0 ORDER BY sid DESC";

$cates = $pdo->query($c_sql)->fetchAll();

$h_sql = "SELECT * FROM `hobbies` WHERE `visible`=1 ORDER BY `seq`";
$hobbies = $pdo->query($h_sql)->fetchAll();
?>
<?php require __DIR__ . '/part/__html header.php'; ?>
<?php include __DIR__ . '/part/__navbar.php'; ?>
<div class="container">
    <?php if (isset($modified)) : ?>
        <div class="alert alert-success" role="alert">
            修改成功
        </div>
    <?php endif ?>
    <form action="" method="post" name="form1">
        <input type="hidden" name="sid" value="2">
        <div class="form-group">
            <label for="bookname">bookname</label>
            <input type="text" class="form-control" id="bookname" name="bookname" value="<?= $row['bookname'] ?>">
        </div>

        <div class="form-group">
            <label for="category_sid">分類</label>
            <select class="form-control" id="category_sid" name="category_sid" data-val="<?= $row['category_sid'] ?>">
                <?php foreach ($cates as $c) : ?>
                    <option value="<?= $c['sid'] ?>"><?= $c['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="">Hobbies</label><br>
            <?php foreach ($hobbies as $h) : ?>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="hobbies[]" <?= in_array($h['sid'], $h_sids) ? 'checked' : '' ?> id="hobbies<?= $h['sid'] ?>" value="<?= $h['sid'] ?>">
                    <label class="form-check-label" for="hobbies<?= $h['sid'] ?>"><?= $h['name'] ?></label>
                </div>
            <?php endforeach; ?>
        </div>

        <!--            <input type="text" class="form-control" id="category_sid" name="category_sid" value="-->
        <?//= $row['category_sid'] ?>
        <!--">-->

        <div class="form-group">
            <label for="price">price</label>
            <input type="text" class="form-control" id="price" name="price" value="<?= $row['price'] ?>">
        </div>


        <div class="d-flex justify-content-end">
            <input type="submit" value="修改" class="btn btn-primary">
        </div>

    </form>

    <input type="file" id="file_input" style="display: none">

</div>
<?php include __DIR__ . '/part/__script.php'; ?>
<script>
    // const file_input = document.querySelector('#file_input');
    // const avatar = document.querySelector('#avatar');
    const $category_sid = document.querySelector('#category_sid');
    let val = $category_sid.getAttribute('data-val')
    $category_sid.value = val
    // document.form1.category_sid3.value = val;
</script>

<?php include __DIR__ . '/part/__html footer.php'; ?>