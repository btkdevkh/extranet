<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" type="image/png" href="public/img/favicon.png">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/jgthms/minireset.css@master/minireset.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
    <link rel="stylesheet" href="public/css/style.css">
    <title>GBAF | Extranet | <?= $title ?></title>
  </head>
<body>
  <header class="topbar">
    <diV class="wrapper">
      <?php if (isset($_SESSION['access'])) : ?>
        <a href="index.php?controller=partner&task=getAllPartners" class="topbar-logo"><img src="public/img/logo.png" alt="Gbaf Logo"></a>
        <div class="info-user">
          <div class="avatar"><img src="public/img/user.png" alt="Profile Photo"></div>
          <div class="last-name"><?= $_SESSION['lastname'] ?></div>
          <div class="user-name"><?= $_SESSION['firstname'] ?></div>
        </div> 
        <diV class="logout">
          <form action="index.php?controller=user&task=logoutUser" method="POST">
            <button type="submit" class="logout-button" name="logout-submit" title="Log Out"><i class="fas fa-sign-out-alt"></i></button>
          </form>
        </div>
      <?php else : ?>
        <a href="index.php" class="topbar-logo-outside"><img src="public/img/logo.png" alt="Gbaf Logo"></a>
      <?php endif; ?>
    </diV>
  </header>

  <div>
    <?= $content ?>
  </div>
  
  <footer>
    <a href="#">Legal Notice</a>
    <a href="#">Contact</a>
  </footer>
  <script type="module" src="public/js/script.js"></script>
</body>
</html>