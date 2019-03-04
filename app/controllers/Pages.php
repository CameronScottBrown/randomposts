<?php
  class Pages extends Controller {
    public function __construct(){

    }

    public function index(){

      if(isLoggedIn()){
        redirect('posts'); //Home -> Posts for logged in users
      }


      //shows default index page
      $data = [
        'title' => 'RandomPosts',
        'description' => "We're all <span class='switch'>weird</span> at heart.<br>Register today and share <em>your</em> random."];

      $this->view('pages/index', $data);
    }

    public function about(){
      //shows about page
      $data = [
        'title' => 'About',
        'description' => 'RandomPosts is a way to share your random stories, thoughts, or jokes with the community.<br>You can post about anything you want!<br><br>Cameron Brown &#xa9; 2018-2019'
      ];

      $this->view('pages/about', $data);
    }
  }

?>