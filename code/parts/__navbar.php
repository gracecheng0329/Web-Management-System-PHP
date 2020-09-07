<?php
if (!isset($page_name)) $page_name = '';
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">競標後台管理系統</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item   <?= $page_name == 'Product List' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= WEB_ROOT ?>/code/list.php">Product List</a></li>
      <li class="nav-item <?= $page_name == 'Insert' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= WEB_ROOT ?>/code/insert.php">Add</a></li>
      <li class="nav-item   <?= $page_name == 'Bidding List' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= WEB_ROOT ?>/code/biddingList.php">Bidding List</a></li>
      <li class="nav-item   <?= $page_name == 'Bidding Add' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= WEB_ROOT ?>/code/biddingAdd.php">Bidding Add</a></li>
    </ul>
    <ul class="navbar-nav">
      <?php if (isset($_SESSION['admin'])) : ?>
        <li class="nav-item">
          <a class="nav-link"><?= $_SESSION['admin']['nickname'] ?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= WEB_ROOT ?>/code/logout.php">登出</a>
        </li>

      <?php else : ?>
        <li class="nav-item <?= $page_name == 'login' ? 'active' : '' ?>">
          <a class="nav-link" href="<?= WEB_ROOT ?>/code/login.php">登入</a>
        </li>
      <?php endif; ?>

    </ul>
    </form>
  </div>
</nav>