<?php

  class Posts extends Controller {
    
    public function __construct(){
      //check if logged in (via the session id)
      if(!isLoggedIn()){
        //redirect to prompt login
        redirect('users/login');
      }

      $this->postModel = $this->model('Post');
      $this->userModel = $this->model('User');

    }
    
    public function index(){
      
      //get posts
      $posts = $this->postModel->getPosts();
      

      // // FIX THIS LATER ... needs to be converted to an array?
      // //convert to more readable time date format
      // foreach($posts as $post){
      //   $time = strtotime($post['created_at']);
      //   $post['created_at'] = date("m/d/y g:i A", $time); //reassign each
      // }
      
      $data = [
        'posts' => $posts    

      ];

      
      $this->view('posts/index', $data);

    }

    //add post
    public function add(){

      //check for POST input
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        //sanitize POST array
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $data = [
          'title' => trim($_POST['title']),
          'body' => trim($_POST['body']),
          'user_id' => $_SESSION['user_id'],
          'title_err' => '',
          'body_err' => ''
        ];

        //validate title
        if(empty($data['title'])){
          $data['title_err'] = 'Please enter a post title.';
        }

        //validate body
        if(empty($data['body'])){
          $data['body_err'] = 'Please enter a body for your post.';
        }

        //check for no errors
        if(empty($data['title_err']) && empty($data['body_err'])){
          //validated 
          if($this->postModel->addPost($data)){
            flash('post_message', 'Post added!');
            redirect('posts'); //send to posts page
          } else {
            //addPost hit a problem
            die('Something went wrong.');
          }

        } else {
          //reload with errors
          $this->view('posts/add', $data);
        }

      } else {

        $data = [
          'title' => '',
          'body' => ''
        ];

        $this->view('posts/add', $data);
    }
  }


  public function show($id){

    $post = $this->postModel->getPostById($id);
    $user = $this->userModel->getUserById($post->user_id);

    $data = [
      'post' => $post,
      'user' => $user
    ];

    $this->view('posts/show', $data);


  }

  //add post
  public function edit($id){

    //check for POST input
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
      //sanitize POST array
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $data = [
        'id' => $id,
        'title' => trim($_POST['title']),
        'body' => trim($_POST['body']),
        'user_id' => $_SESSION['user_id'],
        'title_err' => '',
        'body_err' => ''
      ];

      //validate title
      if(empty($data['title'])){
        $data['title_err'] = 'Please enter a post title.';
      }

      //validate body
      if(empty($data['body'])){
        $data['body_err'] = 'Please enter a body for your post.';
      }

      //check for no errors
      if(empty($data['title_err']) && empty($data['body_err'])){
        //validated 
        if($this->postModel->updatePost($data)){
          flash('post_message', 'Post updated!');
          redirect('posts'); //send to posts page
        } else {
          //updatePost hit a problem
          die('Something went wrong.');
        }

      } else {
        //reload with errors
        $this->view('posts/edit', $data);
      }

    } else {

      //get existing post from model
      $post = $this->postModel->getPostById($id);

      //check for owner, otherwise send to posts
      if($post->user_id != $_SESSION['user_id']){
        redirect('posts');
      }

      $data = [
        'id' => $id,
        'title' => $post->title,
        'body' => $post->body
      ];

      $this->view('posts/edit', $data);
  }
}

//delete post
public function delete($id){

  //get existing post from model (for security - see below)
  $post = $this->postModel->getPostById($id);

  //check for POST input
  if($_SERVER['REQUEST_METHOD'] == 'POST'){
    //check for deletePost AND verify the post belongs to the user
          //protects from non-form POST requests 
    if($this->postModel->deletePost($id) && $post->user_id == $_SESSION['user_id']){
      //successful
      flash('post_message', 'Post removed.');
      redirect('posts');

    } else {
      //problem occurred
      die('Something went wrong');

    }


  } else {
    //redirect to posts page
    redirect('posts');
  }
}

  
    
}








?>
