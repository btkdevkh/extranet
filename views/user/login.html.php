<section class="section-form">
  <diV class="wrapper">
    <h1 class="login-title">Log In</h1>
    <form action="<?= $_SERVER['PHP_SELF'] ?>?controller=user&task=signin" method="POST" id="login" class="form-general">
      <div class="post-block">
        <label for="mailUsername">Username <span>*</span></label>
        <input type="text" name="mailUsername" id="mailUsername"/>
      </div>
      <div class="post-block">
        <label for="pwd">Password <span>*</span></label>
        <input type="password" name="pwd" id="pwd"/>
      </div>
      <a href="index.php?controller=user&task=forgotPassword" class="forgot-password">Forgot password ?</a>  
      <label><span>*</span> Required fields</label>
      <button type="submit" class="submit-button" name="login-submit">Log In</button>
      <a class="create-account" href="index.php?controller=user&task=signup">Create Account</a>
    </form>
    <p class="errors"><?php if(isset($_GET['err'])) echo $_GET['err']; ?></p>
  </div>
</section>
