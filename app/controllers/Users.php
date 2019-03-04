<?php

    class Users extends Controller {
        public function __construct(){
            $this->userModel = $this->model('User');
        }

        public function index(){
            redirect(''); //redirect from users page to site index
        }

        public function register(){
            //check for POST
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                //process form

                //sanitize POST data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                //init data
                $data = [
                    'name' => trim($_POST['name']),
                    'email' => trim($_POST['email']),
                    'password' => trim($_POST['password']),
                    'confirm_password' => trim($_POST['confirm_password']),
                    'name_err' => '',
                    'email_err' => '',
                    'password_err' => '',
                    'confirm_password_err' => ''
                ];

                //validate email
                if(empty($data['email'])){
                    $data['email_err'] = 'Please enter email.';
                } else {
                    //they entered something - is it taken?
                    if($this->userModel->findUserByEmail($data['email'])){
                        $data['email_err'] = 'That email is already taken.';
                    }
                } 

                //validate name
                if(empty($data['name'])){
                    $data['name_err'] = 'Please enter your name.';
                }
                
                //validate password
                if(empty($data['password'])){
                    $data['password_err'] = 'Please enter a valid password.';
                } else if (strlen($data['password']) < 6){
                    $data['password_err'] = 'Your password must be at least 6 characters.';
                }

                //validate confirm password
                if(empty($data['confirm_password'])){
                    $data['confirm_password_err'] = 'Please confirm your password.';
                } else {
                    if($data['password'] != $data['confirm_password']){
                        $data['confirm_password_err'] = 'Your passwords do not match.';
                    }
                }

                //check that all errors are empty
                if(empty($data['email_err']) && empty($data['name_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])){
                    //validated inputs

                    //hash password
                    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT); //hashing algorithm

                    //register user via model
                    if($this->userModel->register($data)){
                        //show flash message
                        flash('register_success','You have been successfully registered. You can now log in!');
                        //redirect user to login page
                        redirect('users/login'); //helper
                    } else {
                        die('Something went wrong.'); //failed register::execute()
                    }

                } else {
                    //load view with errors
                    $this->view('users/register', $data);
                }

            } else {
                //init data
                $data = [
                    'name' => '',
                    'email' => '',
                    'password' => '',
                    'confirm_password' => '',
                    'name_err' => '',
                    'email_err' => '',
                    'password_err' => '',
                    'confirm_password_err' => ''
                ];

                //load view
                $this->view('users/register', $data);
            }
        }

        public function login(){
            //check for POST
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                //process form

                //sanitize POST data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                //init data
                $data = [
                    'email' => trim($_POST['email']),
                    'password' => trim($_POST['password']),
                    'email_err' => '',
                    'password_err' => '',
                ];

                //validate email
                if(empty($data['email'])){
                    $data['email_err'] = 'Please enter email.';
                } 

                //validate password
                if(empty($data['password'])){
                    $data['password_err'] = 'Please enter password.';
                }

                //check for user/email
                if($this->userModel->findUserByEmail($data['email'])){
                    //user found
                    
                } else {
                    $data['email_err'] = 'No user with that email exists.'; //set error message
                }

                //check that errors are empty
                if(empty($data['email_err']) && empty($data['password_err'])){
                    //inputs valid
                    //check and set logged in user
                    $loggedInUser = $this->userModel->login($data['email'], $data['password']);

                    if($loggedInUser){
                        //create session for user
                        $this->createUserSession($loggedInUser);
                    } else {
                        //incorrect password
                        $data['password_err'] = 'Password incorrect.';
                        
                        //reload view
                        $this->view('users/login', $data);
                    }

                } else {
                    //load view with errors
                    $this->view('users/login', $data);
                }

            } else {
                //init data
                $data = [
                    'email' => '',
                    'password' => '',
                    'email_err' => '',
                    'password_err' => '',
                ];

                //load view
                $this->view('users/login', $data);
            }
        }

        //create session for logged in user
        //takes the row passed from User model query
        public function createUserSession($user){
            $_SESSION['user_id'] = $user->id;
            $_SESSION['user_email'] = $user->email;
            $_SESSION['user_name'] = $user->name;

            //send to posts page
            redirect('posts');

        }

        //logout user
        public function logout(){
            unset($_SESSION['user_id']);
            unset($_SESSION['user_email']);
            unset($_SESSION['user_name']);
            session_destroy();

            //redirect to login page
            redirect('users/login');
        }


    }



?>