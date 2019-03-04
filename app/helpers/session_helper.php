<?php
  session_start();

  //flash message helper
  //example call: flash('register_success', 'You are now registered!');
  //then, in a view: in php tags--> echo flash('register_success')
  function flash($name = '', $message = '', $class = 'alert alert-success'){
    if(!empty($name)){ //name entered
      if(!empty($message) && empty($_SESSION[$name])){ //msg exists + session name does not

        //if there is data in session class, destroy it
        if(!empty($_SESSION[$name . '_class'])){
          unset($_SESSION[$name . '_class']);
        }

        //assign session name and class
        $_SESSION[$name] = $message; //set name to message passed in
        $_SESSION[$name . '_class'] = $class;

      } elseif(empty($message) && !empty($_SESSION[$name])){ //msg doesnt exist + s-name does
        //set class if one was passed in
        $class = !empty($_SESSION[$name . '_class']) ? $_SESSION[$name . '_class'] : '';
        //create flash message div
        echo '<div class="'. $class .'" id="msg-flash">' . $_SESSION[$name] . '</div>';
        //destroy variables
        unset($_SESSION[$name]);
        unset($_SESSION[$name . '_class']);
      }
    }
  }


  //check if user is logged in
  function isLoggedIn(){
    if(isset($_SESSION['user_id'])){
        return true;
    } else {
        return false;
    }
  }


?>