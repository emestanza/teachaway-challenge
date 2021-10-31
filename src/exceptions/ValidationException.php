<?php
class ValidationException extends Exception {
  protected $details;

  public function __construct($details) {
      $this->details =  $details;
      parent::__construct();
     
  }

  public function errorMessage() {
    //error message
    return $this->details;
  }


  public function __toString() {
    return $this->details;
  }
}