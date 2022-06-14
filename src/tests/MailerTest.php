<?php

use PHPUnit\Framework\TestCase;
use App\{Mailer};

/**
 * @covers Mailer
 */
class MailerTest extends TestCase {
  public function testMock() {
    // $mailer = new Mailer();
    // $result = $mailer->sendMessage('dave@example.com', 'Hello');
    // $this->assertTrue($result);
    
    /** @var \PHPUnit\Framework\MockObject\MockObject&Mailer $mock */
    $mock = $this->createMock(Mailer::class);
    $mock->method('sendMessage')->willReturn(true);
    $result = $mock->sendMessage('dave@example.com', 'Hello');
    $this->assertTrue($result);
  }

}

