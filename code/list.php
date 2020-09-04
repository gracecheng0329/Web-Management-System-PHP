<?php
$page_title = 'List';
$page_name = 'Product List';
require __DIR__ . '/parts/__connect_db.php';

$perPage = 5;
// $_GET['page']指的是URL?後面的內容
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

$t_sql = "SELECT COUNT(1) FROM `products`";
// 回傳資料總筆數,形式為陣列ex:[12],index:0
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];
// die('~~~'); //exit;
$totalPages = ceil($totalRows / $perPage);

$rows = [];
if ($totalRows > 0) {
    if ($page < 1) {
        header('Location: list.php');
        exit;
    }
    if ($page > $totalPages) {
        header('Location: list.php?page=' . $totalPages);
        exit;
    }
    // $page < 1 ? $page = 1 : '';
    // $page > $totalPages ? $page = $totalPages : '';

    $sql = sprintf("SELECT * FROM `products` LIMIT %s, %s", ($page - 1) * $perPage, $perPage);
    $stmt = $pdo->query($sql);
    // 回傳陣列
    $rows = $stmt->fetchAll();
};
?>

<?php require __DIR__ . '/parts/__html_head.php'; ?>
<style>
    .myTrash {
        color: burlywood;
        cursor: pointer;
    }
</style>
<?php include __DIR__ . '/parts/__navbar.php'; ?>
<div class="container">
    <div class="row">
        <div class="col-lg-6">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $page - 1 ?>">
                            <i class="fas fa-angle-double-left"></i>
                        </a>
                    </li>
                    <?php for ($i = $page - 3; $i <= $page + 3; $i++) :
                        if ($i < 1) continue;
                        if ($i > $totalPages) break;
                    ?>
                        <li class="page-item <?$i==$page ?'active':''?>">
                            <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>
                    <li class="page-item <?= $page == $totalPages ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $page + 1 ?>">
                            <i class="fas fa-angle-double-right"></i>
                        </a>
                    </li>
                </ul>
            </nav>

        </div>
    </div>
</div>
<table class="table table-striped">
    <thead>
        <tr>
            <?php if (isset($_SESSION['admin'])) : ?>
                <th><i class="fas fa-trash-alt"></i></th>
                <th scope="col"><i class="fas fa-user-times"></i></th>
            <?php endif; ?>
            <th scope="col">No.</th>
            <th scope="col">Product Name</th>
            <th scope="col">Designer</th>
            <th scope="col">Description</th>
            <th scope="col">Origin</th>
            <th scope="col">Dimensions</th>
            <th scope="col">DetailPics</th>
            <th scope="col">price</th>
            <?php if (isset($_SESSION['admin'])) : ?>

                <th scope="col"><i class="fas fa-edit"></i></th>
            <?php endif; ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($rows as $r) : ?>
            <tr>
                <?php if (isset($_SESSION['admin'])) : ?>
                    <td><a href="delete.php?sid=<?= $r['sid'] ?>" onclick="ifDel(event)" data-sid="<?= $r['sid'] ?>">
                            <i class="fas fa-trash-alt"></i></a></td>
                    <td><a href="javascript:delete_it(<?= $r['sid'] ?>)">
                            <i class="fas fa-user-times"></i> </a></td>
                <?php endif; ?>
                <!-- `sid`, `product_sid`, `designer_sid`, `productName`, `designer`, `description`, `Origin`, `Dimensions`, `detailPics`, `price`, `favorite`, `visible`  -->
                <td><?= $r['sid'] ?></td>
                <td><?= $r['productName'] ?></td>
                <td><?= $r['designer'] ?></td>
                <td><?= htmlentities($r['description']) ?></td>
                <td><?= $r['Origin'] ?></td>
                <td><?= $r['Dimensions'] ?></td>
                <td><?= $r['detailPics'] ?></td>
                <td><?= $r['price'] ?></td>
                <?php if (isset($_SESSION['admin'])) : ?>
                    <td><a href="edit.php?sid=<?= $r['sid'] ?>"><i class="fas fa-edit"></i></a></td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</div>
<?php include __DIR__ . '/parts/__scripts.php'; ?>
<script>
    function ifDel(event) {
        const a = event.currentTarget;
        console.log(event.target, event.currentTarget);
        const sid = a.getAttribute('data-sid');
        if (!confirm(`是否要刪除編號為 ${sid} 的資料?`)) {
            event.preventDefault(); //取消連往 href 的設定
        }
    }

    function delete_it(sid) {
        if (confirm(`是否要刪除編號為 ${sid} 的資料???`)) {
            location.href = 'delete.php?sid=' + sid;
        }
    }

    // const table = document.querySelector('table')

    // table.addEventListener('click', (event) => {
    //     // target可以是任何在table裡面的元素
    //     const t = event.target;

    //     console.log(t.classList)
    //     //定義target要找的元素
    //     if (t.classList.contains('myTrash')) {
    //         t.closest('tr').remove()
    //     }
    // })



    // const table = document.querySelector('table');

    // table.addEventListener('click', (event) => {
    //     const t = event.target;
    //     //console.log(t.classList);

    //     const ar = [...t.classList];

    //     // -1 表示找不到
    //     console.log(ar.indexOf('my-trash-i'));

    //     // 如果有找到
    //     if (ar.indexOf('my-trash-i') !== -1) {
    //         t.closest('tr').remove();
    //     }

    // })
</script>
<?php include __DIR__ . '/parts/__html_foot.php'; ?>