<?php

use PHPUnit\Framework\TestCase;
// require __DIR__.'/../User.php';
use App\{User, Mailer};

/**
 * @covers User
 */
class UserTest extends TestCase {
  
  use App\Tests\CustomAssertionTrait;

  public function testReturnsFullName() {
    $user             = new User();
    $user->first_name = 'Teresa';
    $user->surname    = 'Green';

    $this->assertEquals('Teresa Green', $user->getFullName());
  }

  public function testFullNameIsEmptyByDefault() {
    $user = new User();
    $this->assertEquals('', $user->getFullName());
  }

  public function testNotificationIsSent() {
    $user        = new User();
    $user->email = 'dave@example.com';
    /** @var \PHPUnit\Framework\MockObject\MockObject&Mailer $mock_mailer */
    $mock_mailer = $this->createMock(Mailer::class);
    // $mock_mailer->method('sendMessage')->willReturn(true);
    // https://phpunit.readthedocs.io/en/9.5/test-doubles.html#test-doubles-mock-objects-tables-matchers
    $mock_mailer->expects($this->once())
      ->method('sendMessage')
    // https://phpunit.readthedocs.io/en/9.5/assertions.html#appendixes-assertions-assertthat-tables-constraints
      ->with($this->equalTo('dave@example.com'), $this->equalTo('Hello'))
      ->willReturn(true);

    $user->setMailer($mock_mailer);

    $this->assertTrue($user->notify('Hello'));
  }

  public function testCannotNotifyUserWithNoEmail() {
    $user = new User();
    /** @var \PHPUnit\Framework\MockObject\MockObject&Mailer $mock_mailer */
    $mock_mailer = $this->getMockBuilder(Mailer::class)
    // ->setMethods(['sendMessage'])
      ->setMethods(null)
      ->getMock();

    $user->setMailer($mock_mailer);
    $this->expectException(Exception::class);
    $user->notify('Hello');

  }

  public function testCustomDataStructure() {
    $data = [
      'nick' => 'Donald',
      'email'=> 'donald@trump.com',
      'age'  => 70
    ];

    $this->assertUserData($data);

  }

}
