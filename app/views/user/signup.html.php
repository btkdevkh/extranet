<section class="section-form">
  <diV class="wrapper">
    <h1 class="login-title">Registration</h1>
    <form action="<?= URL ?>/user/signup" method="POST" name="sign" id="formNewAccount" class="form-general">
      <div class="post-block">
        <label for="firstname">First name <span>*</span></label>
        <input type="text" name="firstname" id="firstname" value="<?= $firstname ?? null ?>"/>
      </div>
      <div class="post-block">
        <label for="lastname">Last name <span>*</span></label>
        <input type="text" name="lastname" id="lastname" value="<?= $lastname ?? null ?>"/>
      </div>
      <div class="post-block">
        <label for="username">Username <span>*</span></label>
        <input type="text" name="username" id="username" value="<?= $username ?? null ?>"/>
      </div>
      <div class="post-block">
        <label for="email">Email <span>*</span></label>
        <input type="email" name="email" id="email" value="<?= $email ?? null ?>"/>
      </div>
      <div class="post-block">
        <label for="pwd">Password <span>*</span></label>
        <input type="password" name="pwd" id="pwd"/>
      </div>
      <div class="post-block">
        <label for="pwd-repeat">Repeat password <span>*</span></label>
        <input type="password" name="pwd-repeat" id="pwd-repeat"/>
      </div>
        
      <div class="post-block">
        <label for="secretQuestion">Secret question <span>*</span></label>
        <select name="secretQuestion" id="secretQuestion">
            <option value="What is your first pet ?">What is your first pet ?</option>
            <option value="What is the first name of your first animal ?">What is the first name of your first animal ?</option>
        </select>
      </div>
      <div class="post-block">
        <label for="secretResponse">Response secret question <span>*</span></label>
        <input type="text" name="secretResponse" id="secretResponse" value="<?= $secretResponse ?? null ?>"/>
      </div>
      <label><span>*</span> Required fields</label>
      <button type="submit" class="submit-button" id="form_submit" name="signup-submit">Register</button>
    </form>
    <p class="errors"><?= isset($error) ? $error : null ?></p>
    <p class="success">
      <?= isset($success) ? $success : null ?>
      <a class='succ' href='<?= URL . 'user/signin'?>'>Go to Login</a>
    </p>
  </div>
</section>
