<?php

use PHPUnit\Framework\TestCase;
use App\{Queue};

/**
 * @covers Queue
 */
class QueueTest extends TestCase {
  public function testNewQueueIsEmpty() {
    $queue = new Queue();
    $this->assertEquals(0, $queue->getCount());
    return $queue;
  }

  /**
   * @depends testNewQueueIsEmpty
   */
  public function testAddAnItemToTheQueue(Queue $queue) {
    $queue->push('green');
    $this->assertEquals(1, $queue->getCount());
    return $queue;
  }

  /**
   * @depends testAddAnItemToTheQueue
   */
  public function testRemoveAnItemFromTheQueue(Queue $queue) {
    $item = $queue->pop();
    $this->assertEquals(0, $queue->getCount());
    $this->assertEquals('green', $item);
  }

}
