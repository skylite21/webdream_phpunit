<?php

use PHPUnit\Framework\TestCase;
use App\{Queue, QueueException};

/**
 * @covers Queue
 */
class QueueFixtureTest extends TestCase {

  protected function setUp(): void {
    $this->queue = new Queue();
  }

  protected function tearDown(): void {
    unset($this->queue);
  }

  public function testNewQueueIsEmpty() {
    $this->assertEquals(0, $this->queue->getCount());
  }

  public function testAddAnItemToTheQueue() {
    $this->queue->push('green');
    $this->assertEquals(1, $this->queue->getCount());
  }

  public function testRemoveAnItemFromTheQueue() {
    $this->queue->push('green');
    $item = $this->queue->pop();
    $this->assertEquals(0, $this->queue->getCount());
    $this->assertEquals('green', $item);
  }

  public function testMaxNumberOfQueueItemsCanBeAdded() {
    for ($i = 0; $i < Queue::MAX_ITEMS; $i++) {
      $this->queue->push($i);
    }
    $this->assertEquals(Queue::MAX_ITEMS, $this->queue->getCount());
    $this->expectException(QueueException::class);
    $this->expectExceptionMessage('Queue is full');
    $this->queue->push('waffles');
  }

}
