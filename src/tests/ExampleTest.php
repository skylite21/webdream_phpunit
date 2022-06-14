<?php

use PHPUnit\Framework\TestCase;

/**
 * @coversNothing
 */
class ExampleTest extends TestCase {

  public function testAddingTwoPlusTwoTogether() {
    $this->assertEquals(4, 2+2);
  }

  public function testTestFunction() {
    $this->assertEquals(4, testFunction());
  }

  /**
   * @test
   */
  public function AddingTwoPlusOneTogether() {
    $this->assertEquals(3, 1+2);
  }
}
