<?php
if (!isset($page_name)) $page_name = '';
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Navbar</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active  <?= $page_name == 'Product List' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= WEB_ROOT ?>/code/list.php">Product List</a></li>
      <li class="nav-item <?= $page_name == 'Insert' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= WEB_ROOT ?>/code/insert.php">Add</a></li>
      <li class="nav-item active  <?= $page_name == 'Product List' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= WEB_ROOT ?>/code/bidding.php">Bidding</a></li>
    </ul>
    <ul class="navbar-nav">
      <?php if (isset($_SESSION['admin'])) : ?>
        <li class="nav-item">
          <a class="nav-link"><?= $_SESSION['admin']['nickname'] ?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= WEB_ROOT ?>/logout.php">登出</a>
        </li>

      <?php else : ?>
        <li class="nav-item <?= $page_name == 'login' ? 'active' : '' ?>">
          <a class="nav-link" href="<?= WEB_ROOT ?>/login.php">登入</a>
        </li>
      <?php endif; ?>

    </ul>
    </form>
  </div>
</nav>