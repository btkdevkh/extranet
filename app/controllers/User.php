<?php

namespace Controllers;

use Security;

class User extends Controller {

  protected $modelName = \Models\User::class;

  public function signin() {

    if(isset($_POST['login-submit'])) {

      if(!empty($_POST['mailUsername']) && !empty($_POST['pwd'])) {

        $userLogin = $this->model->login(Security::checkInput($_POST['mailUsername']));

        if(!$userLogin) {
          \Location::redirect("index.php?controller=user&task=signin&err=No user exists");
          exit;
        } elseif(!password_verify(Security::checkInput($_POST['pwd']), $userLogin['pass'])) {
          \Location::redirect("index.php?controller=user&task=signin&err=Password incorrect");
        } else {
        
          $_SESSION['access'] = "User";
          $_SESSION['userId'] = $userLogin['id'];
          $_SESSION['lastname'] = $userLogin['lastname'];
          $_SESSION['firstname'] = $userLogin['firstname'];
          
          \Location::redirect("index.php?controller=partner&task=getAllPartners");
        }
        
      } else {
        \Location::redirect("index.php?err=Fields required");
      }
    }

    $title = "Connexion";
    \Vue::render("user/login", compact('title'));
    
  }

  public function signup() {

    if(isset($_POST['signup-submit'])) {
  
      if(
        !empty($_POST['lastname']) && 
        !empty($_POST['firstname']) &&
        !empty($_POST['username']) &&
        !empty($_POST['email']) &&
        !empty($_POST['pwd']) &&
        !empty($_POST['pwd-repeat']) &&
        !empty($_POST['secretQuestion']) &&
        !empty($_POST['secretResponse'])
      ) {
    
        if($_POST['pwd'] !== $_POST['pwd-repeat']) {
          \Location::redirect("index.php?controller=user&task=signup&err=Password must be the same");
        } else {
          
          $lastName = Security::checkInput($_POST['lastname']);
          $firstname = Security::checkInput($_POST['firstname']);
          $username = Security::checkInput($_POST['username']);
          $email = Security::checkInput($_POST['email']);
          $pwd = Security::checkInput($_POST['pwd']);
          $pwdRepeat = Security::checkInput($_POST['pwd-repeat']);
          $secretQuestion = Security::checkInput($_POST['secretQuestion']);
          $secretResponse = Security::checkInput($_POST['secretResponse']);
    
          $hash = password_hash($pwd, PASSWORD_DEFAULT);
    
          $userNameExists = $this->model->findUserName($username);
          $userExists = $this->model->login($email);
    
          if($userNameExists) {
            \Location::redirect("index.php?controller=user&task=signup&err=Username already exists");
          } elseif($userExists) {
            \Location::redirect("index.php?controller=user&task=signup&err=Email already exists");
          } else {
            $this->model->save($lastName, $firstname, $username, $email, $hash, $secretQuestion, $secretResponse);
            \Location::redirect("index.php?controller=user&task=signup&success=Account successfully created");
          }
    
        }
        
      } else {
        \Location::redirect("index.php?controller=user&task=signup&err=Fields required");
      }
    
    } 
    
    $title = "Signup";
    \Vue::render("user/signup", compact("title"));

  }

  public function forgotPassword() {

    if(isset($_POST['forgot-pass-submit'])) {
  
      if(!empty($_POST['email'])) {
    
        $userLogin = $this->model->login(Security::checkInput($_POST['email']));
    
        if(!$userLogin) {
          \Location::redirect("index.php?controller=user&task=forgotPassword&err=No user exists");
        } else {
    
          // session_start();
    
          $userEmail = $userLogin['email'];
    
          $token = random_bytes(32);
          $hashedToken = password_hash($token, PASSWORD_DEFAULT);
          $_SESSION['token'] = $hashedToken;
          $_SESSION['userEmail'] = $userEmail;
          $_SESSION['authorize'] = "Authorize";

          $urlLocalHost = "http://localhost/gbaf/index.php?controller=user&task=resetPassword&validator=" . $hashedToken;
    
          $to = $userEmail;
          $subject = 'Reset your password for GBAF';
    
          $message = '<p>We recieved a password request. The link to reset your password make this request is below, if you did not make this request, you can ignore this email</p>';
          $message .= '<p>Here is your password reset link: </br>';
          $message .= '<a href="' . $urlLocalHost . '">' . $urlLocalHost . '</a></p>';
    
          $header = "From: GBAF <adidbk91@gmail.com>\r\n";
          $header .= "Reply-To: adidbk91@gmail.com\r\n";
          $header .= "Content-type: text/html\r\n";
    
          mail($to, $subject, $message, $header);
          
          \Location::redirect("index.php?controller=user&task=forgotPassword&success=Verify in your email, we sent you a link");
        }
        
      } else {
        \Location::redirect("index.php?controller=user&task=forgotPassword&err=Field required");
      }
    }

    $title = "Forgot password";
    \Vue::render("user/forgot", compact("title"));

  }

  public function resetPassword() {
    \Auth::authentification();

    if (isset($_POST['reset-pass-submit'])) {

      $validator = Security::checkInput($_POST['validator']);
      $password = Security::checkInput($_POST['pwd']);
      $passwordRepeat = Security::checkInput($_POST['pwd-repeat']);
    
      if (empty($password) || empty($passwordRepeat)) {
        \Location::redirect("index.php?controller=user&task=resetPassword&err=Fields required&validator=".$validator);
      } else if ($password != $passwordRepeat) {
        \Location::redirect("index.php?controller=user&task=resetPassword&err=Password must be the same&validator=".$validator);
      } else {
    
        if($validator !== $_SESSION['token']) {
          \Location::redirect("index.php?controller=user&task=resetPassword&err=You need to make a new request");
        } else {
      
          $emailFromUser = $_SESSION['userEmail'];
          $userLogin = $this->model->login($emailFromUser);
      
          if(!$userLogin) {
            \Location::redirect("index.php?controller=user&task=resetPassword&err=You need to make a new request");
          } else {
            $newPwdHash = password_hash($password, PASSWORD_DEFAULT);
            $this->model->updateUserPassword($newPwdHash, $emailFromUser);
            \Location::redirect("index.php?controller=user&task=resetPassword&success=Your new password has been reset");
          }
        }
      }
    } 

    $title = "Reset password";
    \Vue::render("user/reset", compact("title"));

  }

  public function logoutUser() {

    session_start();
    session_unset();
    session_destroy();

    \Location::redirect("index.php");
  }

}
