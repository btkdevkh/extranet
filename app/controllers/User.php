<?php

namespace Controllers;

use Security;

class User extends Controller {
  protected $modelName = \Models\User::class;

  public function signin() {
    $title = "Connexion";
    $error = '';
    $mailUsername = $_POST['mailUsername'] ?? '';

    if(isset($_POST['login-submit'])) {
      if(!empty($_POST['mailUsername']) && !empty($_POST['pwd'])) {
        $userLogin = $this->model->login(Security::checkInput($_POST['mailUsername']));

        if(!$userLogin) {
          $error = 'No user exists';
        } elseif(!password_verify(Security::checkInput($_POST['pwd']), $userLogin['pass'])) {
          $error = 'Incorrect password';
        } elseif($userLogin['is_activated'] === 0) {
          $bytes = random_bytes(30);
          $token_validate = bin2hex($bytes);
          $_SESSION['token_validate'] = $token_validate;
          $_SESSION['userEmail'] = Security::checkInput($userLogin['email']);
          $_SESSION['authorize'] = "Authorize";

          $url = URL . "user/validateAccount/bearer/".$token_validate;
          $error = "Account inactivated ! <a style='color: blue;text-decoration: underline;' href=".$url.">Activate now</a>";
        } else {
          $_SESSION['access'] = "User";
          $_SESSION['authorize'] = "authorize";
          
          $_SESSION['userId'] = $userLogin['id'];
          $_SESSION['lastname'] = $userLogin['lastname'];
          $_SESSION['firstname'] = $userLogin['firstname'];
          
          \Location::redirect(URL . "partner/getAllPartners");
        }
      } else {
        $error = 'Fields required';
      }
    }

    \Vue::render("user/login", compact(
        'title',
        'error',
        'mailUsername'
      )
    );
  }

  public function signup() {
    $title = "Signup";

    $error = '';
    $success = '';
    $firstname = $_POST['firstname'] ?? '';
    $lastname = $_POST['lastname'] ?? '';
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $pwd = $_POST['pwd'] ?? '';
    $pwdRepeat = $_POST['pwd-repeat'] ?? '';
    $secretQuestion = $_POST['secretQuestion'] ?? '';
    $secretResponse = $_POST['secretResponse'] ?? '';

    if(isset($_POST['signup-submit'])) {
      if(
        !empty($firstname) &&
        !empty($lastname) && 
        !empty($username) &&
        !empty($email) &&
        !empty($pwd) &&
        !empty($pwdRepeat) &&
        !empty($secretQuestion) &&
        !empty($secretResponse)
      ) {
        if(Security::checkInput($pwd) !== Security::checkInput($pwdRepeat)) {
          $error = 'Password must be the same';
        } else {
          $hash = password_hash(Security::checkInput($pwd), PASSWORD_DEFAULT);
    
          $userNameExists = $this->model->findUserName(Security::checkInput($username));
          $userExists = $this->model->login(Security::checkInput($email));
    
          if($userNameExists) {
            $error = 'Username already exists';
          } elseif($userExists) {
            $error = 'Email already exists';
          } else {            
            $this->model->save(
              Security::checkInput($lastname), 
              Security::checkInput($firstname), 
              Security::checkInput($username), 
              Security::checkInput($email), 
              $hash, 
              Security::checkInput($secretQuestion), 
              Security::checkInput($secretResponse)
            );

            $bytes = random_bytes(30);
            $token_validate = bin2hex($bytes);
            $_SESSION['token_validate'] = $token_validate;
            $_SESSION['userEmail'] = Security::checkInput($email);
            $_SESSION['authorize'] = "Authorize";

            $url = URL . "user/validateAccount/bearer/".$token_validate;
      
            $to = Security::checkInput($email);
            $subject = 'Ativated Account for GBAF';
      
            $header = "From: GBAF <adidbk91@gmail.com>\r\n";
            $header .= "Reply-To: adidbk91@gmail.com\r\n";
            $header .= "Content-type: text/html\r\n";

            $message = "You are now member.\n";
            $message .= "Please validate this link to activate your account.\n";
            $message .= $url;
      
            mail($to, $subject, $message, $header);

            $success = 'Account successfully created. We sent you a link to your email';

            $firstname = '';
            $lastname = '';
            $username = '';
            $email = '';
            $secretResponse = '';
          }
        }
      } else {
        $error = 'Fields required';
      }
    } 
    
    \Vue::render("user/signup", compact(
        "title",
        'error',
        'success',
        'firstname',
        'lastname',
        'username',
        'email',
        'secretResponse'
      )
    );
  }

  public function validateAccount() {
    $title = "Activation";
    $error = "";
    $success = "";
    $bearer = Security::checkInput(explode('/', $_GET['page'])[3]);
    
    if (isset($bearer) && isset($_SESSION['token_validate'])) {
      if($bearer !== $_SESSION['token_validate']) {
        $error = 'You need to make a new request';
      } else {
        $this->model->validateUserAccount($_SESSION['userEmail']);
        $success = "Account Activated";
        unset($_SESSION['token_validate']);
        unset($_SESSION['userEmail']);
        unset($_SESSION['authorize']);
      }
    } 

    \Vue::render("user/validate_account", compact(
        "title",
        'error',
        'success',
      )
    );
  }

  public function forgotPassword() {
    $title = "Forgot password";
    $error = '';
    $success = '';

    if(isset($_POST['forgot-pass-submit'])) {
      if(!empty($_POST['email'])) {
        $userLogin = $this->model->login(Security::checkInput($_POST['email']));
    
        if(!$userLogin) {
          $error = 'No user exists';
        } else {    
          $userEmail = $userLogin['email'];
    
          $token = random_bytes(32);
          $hashedToken = password_hash($token, PASSWORD_DEFAULT);
          $_SESSION['token'] = $hashedToken;
          $_SESSION['userEmail'] = $userEmail;
          $_SESSION['authorize'] = "Authorize";

          $urlLocalHost = URL . "user/resetPassword/bearer/".$hashedToken;
    
          $to = $userEmail;
          $subject = 'Reset your password for GBAF';
    
          $header = "From: GBAF <adidbk91@gmail.com>\r\n";
          $header .= "Reply-To: adidbk91@gmail.com\r\n";
          $header .= "Content-type: text/html\r\n";

          $message = "We recieved a password request.\n";
          $message .= "If you did not make this request, you can ignore this email.\n";
          $message .= "The link to reset your password make this request is below.\n";
          $message .= "Here is your password reset link: \n";
          $message .= $urlLocalHost;
    
          mail($to, $subject, $message, $header);
          
          $success = 'Verify in your email, we sent you a link';
        }
      } else {
        $error = 'Field required';
      }
    }

    \Vue::render("user/forgot", compact(
        "title",
        'error',
        'success'
      )
    );
  }

  public function resetPassword($param) {
    \Auth::authentification();

    $title = "Reset password";
    $error = '';
    $success = '';
    $bearer = $param ?? '';
    
    if (isset($_POST['reset-pass-submit'])) {
      $bearer = Security::checkInput($_POST['bearer']);
      $password = Security::checkInput($_POST['pwd']);
      $passwordRepeat = Security::checkInput($_POST['pwd-repeat']);
      
      if (empty($password) || empty($passwordRepeat)) {
        $error = 'Fields required';
        
        // \Location::redirect(URL . 'user/resetPassword/bearer/' . $bearer);
      } else if ($password != $passwordRepeat) {
        $error = 'Password must be the same';
      } else {
        if($bearer !== $_SESSION['token']) {
          $error = 'You need to make a new request';
        } else {
          $emailFromUser = $_SESSION['userEmail'];
          $userLogin = $this->model->login($emailFromUser);
      
          if(!$userLogin) {
            $error = 'You need to make a new request';
          } else {
            $newPwdHash = password_hash($password, PASSWORD_DEFAULT);
            $this->model->updateUserPassword($newPwdHash, $emailFromUser);

            $success = 'Your new password has been reset';
          }
        }
      }
    } 

    var_dump('BEARER', $bearer);

    \Vue::render("user/reset", compact(
        "title",
        'error',
        'success',
        'bearer'
      )
    );
  }

  public function logoutUser() {
    session_start();
    session_unset();
    session_destroy();

    \Location::redirect(URL);
  }
}
