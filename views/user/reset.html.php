<section class="section-form">
  <diV class="wrapper">
    <h1 class="login-title">Reset your password</h1>
    </br>  
    <form action="<?= $_SERVER['PHP_SELF'] ?>?controller=user&task=resetPassword" method="post" class="form-general">
      <input type="hidden" name="validator" value="<?php if(isset($_GET['validator'])) echo $_GET['validator'] ?>">
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
    <p class="errors"><?php if(isset($_GET['err'])) echo $_GET['err'] ?></p>
    <p class="success"><?php if(isset($_GET['success'])) echo $_GET['success'] . ' <a class="succ" href="./index.php">Go to Login<a/>'  ?></p>
  </div>
</section>
