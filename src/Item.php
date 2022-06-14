<?php

namespace App;
class Item {

  private $product_id;
  public function __construct() {
    $this->product_id = rand();
  }
  public function getDescription() {
    return $this->getID() . $this->getToken();
  }
  protected function getID() {
    return rand();
  }
  private function getToken() {
    return uniqid();
  }
  private function getPrefixedToken(string $prefix) {
    return uniqid($prefix);
  }

}
