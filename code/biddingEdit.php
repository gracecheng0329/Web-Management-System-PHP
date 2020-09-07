<?php
$page_title = 'Bidding Edit';
$page_name = 'Bidding Edit';
require __DIR__ . '/parts/__connect_db.php';
require __DIR__ . '/parts/__admin_required.php';

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;
if (empty($sid)) {
    header('Location: biddingList.php');
    exit;
}

$sql = " SELECT * FROM `bidding` WHERE sid=$sid";
$row = $pdo->query($sql)->fetch();
if (empty($row)) {
    header('Location: biddingList.php');
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
                    <h5 class="card-title">Edit</h5>
                    <form name="form1" onsubmit="checkForm(); return false;" novalidate>
                        <input type="hidden" name="sid" value="<?= $row['sid'] ?>">
                        <div class="form-group">
                            <label for="productName"><span class="red-stars">**</span> Product Name</label>
                            <input type="text" class="form-control" id="productName" name="productName" value="<?= htmlentities($row['productName']) ?>">
                            <small class="form-text error-msg"></small>
                        </div>
                        <div class="form-group">
                            <label for="pics"><span class="red-stars">**</span> Pictures</label>
                            <input type="text" class="form-control" id="pics" name="pics" value="<?= htmlentities($row['pics']) ?>">
                            <small class="form-text error-msg"></small>
                        </div>
                        <div class="form-group">
                            <label for="startingDate"><span class="red-stars">**</span> Starting date</label>
                            <input type="date" class="form-control" id="startingDate" name="startingDate" value="<?= htmlentities($row['startingDate']) ?>">
                            <small class="form-text error-msg"></small>
                        </div>
                        <div class="form-group">
                            <label for="startingTime"><span class="red-stars">**</span> Starting time</label>
                            <input type="time" class="form-control" id="startingTime" name="startingTime" value="<?= htmlentities($row['startingTime']) ?>">

                        </div>
                        <div class="form-group">
                            <label for="bidDate">Bid date</label>
                            <input type="date" class="form-control" id="bidDate" name="bidDate" value="<?= htmlentities($row['bidDate']) ?>">
                            <small class="form-text error-msg"></small>
                        </div>
                        <div class="form-group">
                            <label for="bidTime">Bid time</label>
                            <input type="time" class="form-control" id="bidTime" name="bidTime" value="<?= htmlentities($row['bidTime']) ?>">
                        </div>
                        <div class="form-group">
                            <label for="startedPrice"><span class="red-stars">**</span> Started price</label>
                            <input type="text" class="form-control" id="startedPrice" name="startedPrice" value="<?= htmlentities($row['startedPrice']) ?>">
                            <small class="form-text error-msg"></small>
                        </div>
                        <div class="form-group">
                            <label for="bidPrice"><span class="red-stars">**</span> Bid price</label>
                            <input type="text" class="form-control" id="bidPrice" name="bidPrice" value="<?= htmlentities($row['bidPrice']) ?>">
                            <small class=" form-text error-msg"></small>
                        </div>
                        <div class="form-group">
                            <label for="soldPrice"><span class="red-stars">**</span> Min sold price</label>
                            <input type="text" class="form-control" id="soldPrice" name="soldPrice" value="<?= htmlentities($row['soldPrice']) ?>">
                            <small class=" form-text error-msg"></small>
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
    const productName_pattern = /[a-zA-Z]/;
    const startedPrice_p = /\d/;
    const bidPrice_p = /\d/;
    const soldPrice_p = /\d/;

    const $productName = document.querySelector('#productName')
    const $startedPrice = document.querySelector('#startedPrice')
    const $bidPrice = document.querySelector('#bidPrice')
    const $soldPrice = document.querySelector('#soldPrice')
    const r = [$productName, $startedPrice, $bidPrice, $soldPrice]
    const infobar = document.querySelector('#infobar')
    const submitBtn = document.querySelector('button[type=submit]');

    const checkForm = () => {
        let isPass = true

        r.forEach((el) => {
            el.style.borderColor = '#cccccc';
            el.nextElementSibling.innerHTML = '';
        });
        submitBtn.style.display = 'none';

        if (!productName_pattern.test($productName.value)) {
            isPass = false;
            $productName.style.borderColor = 'red';
            $productName.nextElementSibling.innerHTML = 'Please input your product name correctly';
        };

        if (!startedPrice_p.test($startedPrice.value)) {
            isPass = false;
            $startedPrice.style.borderColor = 'red';
            $startedPrice.nextElementSibling.innerHTML = 'Please input your price correctly';
        };

        if (true) {
            const fd = new FormData(document.form1);

            fetch('biddingEditAPI.php', {
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
                                location.href = '<?= $_SERVER['HTTP_REFERER'] ?? "biddingList.php" ?>';
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
<?php include __DIR__ . '/parts/__html_foot.php'; ?>