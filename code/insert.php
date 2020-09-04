<?php
$page_title = 'Insert';
$page_name = 'Insert';
require __DIR__ . '/parts/__connect_db.php';
require __DIR__ . '/parts/__admin_required.php';
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
        <div class="col-lg-6">
            <div id="infobar" class="alert alert-success" role="alert" style="display: none">
                A simple success alert—check it out!
            </div>
            <div class="card" style="width: 40rem;">
                <div class="card-body">
                    <h5 class="card-title">ADD</h5>
                    <form name="form1" onsubmit="checkForm(); return false;" novalidate>
                        <div class="form-group">
                            <label for="productName"><span class="red-stars">**</span> Product Name</label>
                            <input type="text" class="form-control" id="productName" name="productName" required>
                            <small class="form-text error-msg"></small>
                        </div>
                        <div class="form-group">
                            <label for="designer"><span class="red-stars">**</span> Designer</label>
                            <input type="text" class="form-control" id="designer" name="designer">
                            <small class="form-text error-msg"></small>
                        </div>
                        <div class="form-group">
                            <label for="description"><span class="red-stars">**</span> Description</label>
                            <textarea type="text" class="form-control" id="description" name="description" cols="30" rows="3"></textarea>

                        </div>
                        <div class="form-group">
                            <label for="origin">Origin</label>
                            <input type="text" class="form-control" id="origin" name="origin">
                            <small class="form-text error-msg"></small>
                        </div>
                        <div class="form-group">
                            <label for="dimensions">Dimensions</label>
                            <textarea class="form-control" name="dimensions" id="dimensions" cols="30" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="detailPics">Detail Pics</label>
                            <input type="text" class="form-control" id="detailPics" name="detailPics">
                        </div>
                        <div class="form-group">
                            <label for="price"><span class="red-stars">**</span> Price</label>
                            <input type="text" class="form-control" id="price" name="price">
                            <small class="form-text error-msg"></small>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/parts/__scripts.php'; ?>
<!-- `sid`, `product_sid`, `designer_sid`, `productName`, `designer`, `description`, `Origin`, `Dimensions`, `detailPics`, `price`, `favorite`, `visible`  -->
<script>
    const productName_pattern = /^[A-Z]/;
    const designer_pattern = /^[A-Z]/;
    const origin_pattern = /^[A-Z]/;
    const price_pattern = /\d/;

    const $productName = document.querySelector('#productName')
    const $designer = document.querySelector('#designer')
    const $origin = document.querySelector('#origin')
    const $price = document.querySelector('#price')
    const r = [$productName, $designer, $origin, $price]
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
        if (!designer_pattern.test($designer.value)) {
            isPass = false;
            $designer.style.borderColor = 'red';
            $designer.nextElementSibling.innerHTML = 'Please input your designer correctly';
        };
        if (!origin_pattern.test($origin.value)) {
            isPass = false;
            $origin.style.borderColor = 'red';
            $origin.nextElementSibling.innerHTML = 'Please input your origin correctly';
        };

        if (!price_pattern.test($price.value)) {
            isPass = false;
            $price.style.borderColor = 'red';
            $price.nextElementSibling.innerHTML = 'Please input your price correctly';
        };

        if (isPass) {
            const fd = new FormData(document.form1);

            fetch('insert_API.php', {
                    method: 'POST',
                    body: fd
                })
                .then(r => r.json())
                .then(obj => {
                    console.log(obj);
                    if (obj.success) {
                        infobar.innerHTML = '新增成功';
                        // infobar.className = "alert alert-success";
                        if (infobar.classList.contains('alert-danger')) {
                            infobar.classList.replace('alert-danger', 'alert-success')
                            setTimeout(() => {
                                location.href = 'list.php';
                            }, 3000);
                        };
                    } else {
                        infobar.innerHTML = obj.error || '新增失敗';
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