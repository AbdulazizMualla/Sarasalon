<?php

class User {


  public function isAdmin(){

    return isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin';

  }
  public function isEmp(){

    return isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'emp';

  }

  public function isLoggedin(){

    return isset($_SESSION['logged_in']);

  }

  public function userName(){

    if (isset($_SESSION['user_name'])) {

      return $_SESSION['user_name'];

    }
    return 'guest';


  }


}
