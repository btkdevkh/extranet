<section class="section-form">
  <diV class="wrapper" style="text-align: center;">
    <h1 class="login-title"><?= isset($success) ? $success : null ?></h1>
    </br>  
    <p class="errors"><?= isset($error) ? $error : null ?></p>
    <p class="success">
      <a class="succ" href="<?= URL . 'user/signin' ?>">Go to Login</a>
    </p>
  </div>
</section>