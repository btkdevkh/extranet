<section class="section-form">
  <diV class="wrapper">
    <h1 class="login-title">Reset your password</h1>
    </br>  
    <form action="<?= URL ?>user/resetPassword" method="post" class="form-general">
      <input type="hidden" name="bearer" value="<?= isset($bearer) ? $bearer : null ?>">
      <div class="post-block">
        <label>Enter a new password <span>*</span></label>
        <input type="password" name="pwd">
      </div>
      <div class="post-block">
        <label>Repeat new password <span>*</span></label>
        <input type="password" name="pwd-repeat">
      </div>
      <button type="submit" class="submit-button" name="reset-pass-submit">Reset password</button>
    </form>
    <p class="errors"><?= isset($error) ? $error : null ?></p>
    <p class="success">
      <?= isset($success) ? $success : null ?>
      <a class="succ" href="<?= URL . 'user/signin' ?>">Go to Login</a>
    </p>
  </div>
</section>
