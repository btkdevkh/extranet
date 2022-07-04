<section class="section-form">
  <diV class="wrapper">
    <h1 class="login-title">Forgot your password</h1>
    <form action="<?= URL ?>user/forgotPassword" method="POST" class="form-general">
      <div class="post-block">
        <label for="email">Email <span>*</span></label>
        <input type="email" name="email" id="email"/>
      </div>
      <label><span>*</span> Required fields</label>
      <button type="submit" class="submit-button" name="forgot-pass-submit">Submit</button>
    </form>
    <p class="errors"><?= isset($error) ? $error : null ?></p>
    <p class="success">
      <?= isset($success) ? $success : null ?>
      <a class="succ" href="<?= URL . 'user/signin' ?>">Go to Login</a>
    </p>
  </div>
</section>
