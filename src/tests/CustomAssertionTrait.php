<?php

namespace App\Tests;

trait CustomAssertionTrait {
  public function assertUserData(array $array) {
    foreach(['nick', 'email', 'age'] as $key) {
      $this->assertArrayHasKey(
        $key,
        $array,
        "Array doesn't contain the $key key.");
    }
    $this->assertIsString(
      $array['nick'],
      'Nick field must be a string'
    );
    $this->assertMatchesRegularExpression(
      '/^.+\@\S+\.\S+$/', 
      $array['email'],
      'Email filed must meg a valid email'
    );

    $this->assertIsInt(
      $array['age'],
      'Age muist be an integer'
    );
  }

}
