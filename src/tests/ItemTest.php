<?php

use PHPUnit\Framework\TestCase;
use App\{Item};

/**
 * @covers Item
 */
class ItemTest extends TestCase {
  // private vagy protected property tesztelése
  public function testIDIsAnInteger() {
    $product   = new Item();
    $reflector = new ReflectionClass(Item::class); 
    $property  = $reflector->getProperty('product_id');
    $property->setAccessible(true);
    $value = $property->getValue($product);
    $this->assertIsInt($value);
  }
  // private vagy protected metódus tesztelése
  public function testTokenIsAString() {
    $product   = new Item();
    $reflector = new ReflectionClass(Item::class); 
    $method    = $reflector->getMethod('getToken');
    $method->setAccessible(true);
    $result = $method->invoke($product);
    $this->assertIsString($result);
  }

  // private vagy protected metódus tesztelése argumentummal
  public function testPrefixedTokenStartsWithPrefix() {
    $product   = new Item();
    $reflector = new ReflectionClass(Item::class); 
    $method    = $reflector->getMethod('getPrefixedToken');
    $method->setAccessible(true);
    $result = $method->invokeArgs($product, ['example']);
    $this->assertStringStartsWith('example', $result);
  }

}


