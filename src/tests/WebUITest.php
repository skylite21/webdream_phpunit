<?php

use PHPUnit\Framework\TestCase;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Exception\NoSuchElementException;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\RemoteWebElement;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverCheckboxes;
use Facebook\WebDriver\WebDriverExpectedCondition;

// https://github.com/php-webdriver/php-webdriver/wiki/Example-command-reference
// https://github.com/php-webdriver/php-webdriver/blob/main/example.php

/**
 * @covers user interface on websites
 */
class WebUITest extends TestCase {

  private RemoteWebDriver $driver;

  public function setUp() : void {
    $options = new ChromeOptions();
    $options->addArguments(['headless', 'window-size=1920,1080']);
    // $options->addArguments(['ignore-certificate-errors']);
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
    /** @var RemoteWebElement $page_title  */
    $page_title = $this->driver->findElement(WebDriverBy::cssSelector('h1'));
    $this->assertMatchesRegularExpression('/Informatika/', $page_title->getText());
  }

  public function testFormDisplay() : void {
    $this->expectException(NoSuchElementException::class);
    $this->driver->findElement(WebDriverBy::cssSelector('[data-text="Elküldöm"]'));
    $this->driver->findElement(WebDriverBy::xpath('//button[text()="Üzenetküldés"]'))->click();
    $submit_button = $this->driver->findElement(WebDriverBy::cssSelector('[data-text="Elküldöm"]'));
    $this->assertEquals('Elküldöm', $submit_button->getText());

  }

  public function FormSubmit() : void {
    $this->driver->get('https://www.prompt.hu');
    $this->driver->findElement(WebDriverBy::xpath('//button[text()="Üzenetküldés"]'))->click();
    // sleep(1);
    $this->driver->findElement(WebDriverBy::cssSelector('.header-right input[name="nev"]'))
                 ->sendKeys('Lengyel Zsolt');
    $this->driver->findElement(WebDriverBy::cssSelector('.header-right input[name="e_mail"]'))
                 ->sendKeys('zsolt.lengyel@prompt.hu');
    $this->driver->findElement(WebDriverBy::cssSelector('.header-right textarea[name="uzenet"]'))
                 ->sendKeys('testing form submission from selenium');
    $checkbox_elem = $this->driver->findElement(WebDriverBy::cssSelector('.header-right input[name="elfogadom_az_adatkezelesi_tajekoztatot_"]'));
    $checkbox      = new WebDriverCheckboxes($checkbox_elem);
    $checkbox->selectByIndex(0);
    $this->driver->findElement(WebDriverBy::cssSelector('[data-text="Elküldöm"]'))->click();
    $this->driver->wait(10, 500)->until(function (RemoteWebDriver $driver) {
      return $driver->getCurrentURL() === 'https://www.prompt.hu/koszonjuk';
    });

    $this->assertMatchesRegularExpression('/Köszönjük/', $this->driver->getTitle());

  }

  public function testPermission() : void {
    $this->driver->get('https://readinclub.itstudy.hu/en/user/login');
    $this->driver->findElement(WebDriverBy::cssSelector('.user-login-form input[name="name"]'))
                 ->sendKeys('skylite');
    $this->driver->findElement(WebDriverBy::cssSelector('.user-login-form input[name="pass"]'))
                 ->sendKeys('ssda12');
    $this->driver->findElement(WebDriverBy::cssSelector('.user-login-form input[type="submit"]'))
                 ->click();
    $this->driver->wait()->until(
      WebDriverExpectedCondition::visibilityOfAnyElementLocated(WebDriverBy::xpath('//*[@id="block-readingclub-page-title"]/h1[text()="skylite"]'))
    );
    $this->driver->findElement(WebDriverBy::cssSelector('a[data-drupal-link-system-path="clubs"]'))->click();
    $button = $this->driver->findElement(WebDriverBy::xpath('//a[text()="Create a Club"]'));
    $this->assertEquals('CREATE A CLUB', $button->getText());
  }

}


