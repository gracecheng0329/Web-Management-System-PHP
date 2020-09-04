<?php
$page_title = 'Edit';
$page_name = 'Edit';
require __DIR__ . '/parts/__connect_db.php';
require __DIR__. '/parts/__admin_required.php';

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;
if (empty($sid)) {
    header('Location: list.php');
    exit;
}

$sql = " SELECT * FROM `products` WHERE sid=$sid";
$row = $pdo->query($sql)->fetch();
if (empty($row)) {
    header('Location: list.php');
    exit;
}
?>

<?php require __DIR__ . '/parts/__html_head.php'; ?>
<style>
    span.red-stars {
        color: red;
    }

    small.error-msg {
        color: red;
    }
</style>
<?php include __DIR__ . '/parts/__navbar.php'; ?>
<div class="container">
    <div class="row">
        <div class="col">
            <div id="infobar" class="alert alert-success" role="alert" style="display: none">
                A simple success alert—check it out!
            </div>
            <div class="card" style="width: 40rem;">
                <div class="card-body">
                    <h5 class="card-title">ADD</h5>
                    <!-- 加上novalidate 會使HTML驗證功能屬性失效 -->
                    <form name="form1" onsubmit="checkForm(); return false;" novalidate>
                        <input type="hidden" name="sid" value="<?= $row['sid'] ?>">
                        <div class="form-group">
                            <label for="name"><span class="red-stars">**</span> name</label>
                            <input type="text" class="form-control" id="name" name="name" required value="<?= htmlentities($row['name']) ?>">
                            <small class=" form-text error-msg"></small>
                        </div>
                        <div class="form-group">
                            <label for="email"><span class="red-stars">**</span> email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= htmlentities($row['email']) ?>">
                            <small class=" form-text error-msg"></small>
                        </div>
                        <div class="form-group">
                            <label for="cell"><span class="red-stars">**</span> cell</label>
                            <input type="tel" class="form-control" id="cell" name="cell" pattern="^09\d{2}-?\d{3}-?\d{3}$" value="<?= htmlentities($row['cell']) ?>">
                            <small class=" form-text error-msg"></small>
                        </div>
                        <div class="form-group">
                            <label for="DOB">birthday</label>
                            <input type="date" class="form-control" id="DOB" name="DOB" value="<?= htmlentities($row['DOB']) ?>">
                        </div>
                        <div class=" form-group">
                            <label for="address">address</label>
                            <textarea class="form-control" name="address" id="address" cols="30" rows="3"><?= htmlentities($row['address']) ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/parts/__scripts.php'; ?>
<script>
    const email_pattern = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
    const cell_pattern = /^09\d{2}-?\d{3}-?\d{3}$/;
    const $name = document.querySelector('#name')
    const $email = document.querySelector('#email')
    const $cell = document.querySelector('#cell')
    const r = [$name, $email, $cell]
    const infobar = document.querySelector('#infobar')
    const submitBtn = document.querySelector('button[type=submit]');

    const checkForm = () => {
        let isPass = true

        r.forEach((el) => {
            el.style.borderColor = '#cccccc';
            el.nextElementSibling.innerHTML = '';
        });
        submitBtn.style.display = 'none';

        if ($name.value.length < 2) {
            isPass = false;
            $name.style.borderColor = 'red';
            $name.nextElementSibling.innerHTML = 'Please input your name correctly';
        };
        if (!email_pattern.test($email.value)) {
            isPass = false;
            $email.style.borderColor = 'red';
            $email.nextElementSibling.innerHTML = 'Please input your email correctly';
        };
        if (!cell_pattern.test($cell.value)) {
            isPass = false;
            $cell.style.borderColor = 'red';
            $cell.nextElementSibling.innerHTML = 'Please input your cellphone correctly';
        };

        if (isPass) {
            const fd = new FormData(document.form1);

            fetch('dataEditAPI.php', {
                    method: 'POST',
                    body: fd
                })
                .then(r => r.json())
                .then(obj => {
                    console.log(obj);
                    if (obj.success) {
                        infobar.innerHTML = '修改成功';
                        // infobar.className = "alert alert-success";
                        if (infobar.classList.contains('alert-danger')) {
                            infobar.classList.replace('alert-danger', 'alert-success')
                            setTimeout(() => {
                                location.href = '<?= $_SERVER['HTTP_REFERER'] ?? "dataList3.php" ?>';
                            }, 3000);
                        };
                    } else {
                        infobar.innerHTML = obj.error || '資料未修改';
                        // infobar.className = "alert alert-danger";
                        if (infobar.classList.contains('alert-success')) {
                            infobar.classList.replace('alert-success', 'alert-danger')
                            submitBtn.style.display = 'block';
                        }
                    }
                    infobar.style.display = 'block';
                });

        } else {
            submitBtn.style.display = 'block';
        }
    }
</script>
<?php include __DIR__ . '/part/__html footer.php'; ?>