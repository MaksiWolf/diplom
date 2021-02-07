<?php 
namespace App\controllers;
use Delight\Auth\Auth;
use League\Plates\Engine;
use App\Model\Posts as postData;
use \Tamtamchik\SimpleFlash\Flash;
use App\Model\User as userData;

class User {
   private $templates, $pdo, $auth, $error, $flash, $user;
   private $selector, $token;

   public function __construct(Auth $auth, Engine $engine, postData $db, Flash $flash, userData $user, Posts $post)
   {
      $this->templates = $engine;
      $this->db = $db;
      $this->auth = $auth;
      $this->flash = $flash;
      $this->user = $user;
      $this->post = $post;
   }

   public function index()
   {
      if ($this->auth->isLoggedIn()) {
         $this->user->getAllUsers();
         $result = $this->user->getResults();
         // Render a template
         echo $this->templates->render('users', ['results'=> $result, 'category'=>$this->db->getCategory(), 'auth'=>$this->auth]);
      } else {
         echo "Page not found";
      }
   }

   public function login()
   {
      if (!empty($_POST)) {
         try {
            $this->auth->login($_POST['email'], $_POST['password']);
      
            header('Location: '.SITE_HOST.PROJECT_FOLDER);
         }
         catch (\Delight\Auth\InvalidEmailException $e) {
         $this->flash->error('Wrong email address');
         }
         catch (\Delight\Auth\InvalidPasswordException $e) {
         $this->flash->error('Wrong password');
         }
         catch (\Delight\Auth\EmailNotVerifiedException $e) {
         $this->flash->error('Email not verified');
         }
         catch (\Delight\Auth\TooManyRequestsException $e) {
         $this->flash->error('Too many requests');
         }
      }

      echo $this->templates->render('login', ['category'=>$this->db->getCategory(), 'errors'=>$this->flash, 'auth'=>$this->auth]);
   }

   public function LogOut()
   {
      $this->auth->logOut();
      header('Location: '.SITE_HOST.PROJECT_FOLDER);
   }

   public function register()
   {  
      if (!empty($_POST)) {
         if($_POST['comfirmpassword'] <> $_POST['password']) {
            $this->flash->error('Password mismatch');
         } else {
            try {
               $userId = $this->auth->register($_POST['email'], $_POST['password'], $_POST['username'], function ($selector, $token)  {

               $this->selector = $selector;
               $this->token = $token;
               });
               $this->flash->success('Success registration');
            }
            catch (\Delight\auth\InvalidEmailException $e) {
               $this->flash->error('Invalid email address');
            }
            catch (\Delight\auth\InvalidPasswordException $e) {
               $this->flash->error('Invalid password');
            }
            catch (\Delight\auth\UserAlreadyExistsException $e) {
               $this->flash->error('User already exists');
            }
            catch (\Delight\auth\TooManyRequestsException $e) {
               $this->flash->error('Too many requests');
            }
         }
      }  
         
      echo $this->templates->render('register', ['category'=>$this->db->getCategory(), 'errors'=>$this->flash, 'auth'=>$this->auth]);
     
   }

   public function delete($id)
   {
      if ($id <> null) {   
         $this->user->deleteById($id);
         $this->user->getAllUsers();
         header('Location: '.SITE_HOST.PROJECT_FOLDER.'users');
     }
   }
}