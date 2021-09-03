<section class="section-form">
  <diV class="wrapper">
    <h1 class="login-title">Forgot your password</h1>
    <form action="<?= $_SERVER['PHP_SELF'] ?>?controller=user&task=forgotPassword" method="POST" class="form-general">
      <div class="post-block">
        <label for="email">Email <span>*</span></label>
        <input type="email" name="email" id="email"/>
      </div>
      <label><span>*</span> Required fields</label>
      <button type="submit" class="submit-button" name="forgot-pass-submit">Submit</button>
    </form>
    <p class="errors"><?php if(isset($_GET['err'])) echo $_GET['err']; ?></p>
    <p class="success"><?php if(isset($_GET['success'])) echo $_GET['success'] . ' <a class="succ" href="./index.php">Go to Login<a/>'  ?></p>
  </div>
</section>
