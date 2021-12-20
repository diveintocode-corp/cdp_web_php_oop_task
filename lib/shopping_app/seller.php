<?php
include_once "user.php";

class Seller extends User{
  function __construct($name){
    $this->name = $name;
    parent::__construct($name);
    // $this->wallet = parent::wallet;
  }
  
}
