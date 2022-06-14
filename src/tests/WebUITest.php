<?php

use PHPUnit\Framework\TestCase;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;

/**
 * @covers user interface on websites
 */
class WebUITest extends TestCase {
  public function setUp() : void {
    $options = new ChromeOptions();
    $options->addArguments(['headless']);
    $capabilities = DesiredCapabilities::chrome();
    $capabilities->setCapability(ChromeOptions::CAPABILITY, $options);
    $this->driver = RemoteWebDriver::create(desired_capabilities:$capabilities);
  }

  protected function tearDown(): void {
    $this->driver->quit();
  }

  public function testTitle() : void {
    $this->driver->get('https://www.prompt.hu');
    $this->assertMatchesRegularExpression('/Prompt/', $this->driver->getTitle());
  }

}


