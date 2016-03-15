<?php
class GitHubTest extends PHPUnit_Framework_TestCase {

    use WebDriverAssertions;
    use WebDriverDevelop;

    protected $url = 'http://github.com';
    /**
     * @var \RemoteWebDriver
     */
    protected $webDriver;

	public function setUp()
    {
        $capabilities = array(\WebDriverCapabilityType::BROWSER_NAME => 'firefox');
        $this->webDriver = RemoteWebDriver::create('http://localhost:4444/wd/hub', $capabilities);

    }

    public function tearDown()
    {
        $this->webDriver->quit();
    }

    public function testGitHubHome()
    {
        $this->webDriver->get($this->url);
        // checking that page title contains word 'GitHub'
        $this->assertContains('GitHub', $this->webDriver->getTitle());
    }

    public function testSearch()
    {
        $this->webDriver->get($this->url);

        // find search field by its id
        $search = $this->webDriver->findElement(WebDriverBy::cssSelector('.js-site-search-focus'));
        $search->click();

        // typing into field
        $this->webDriver->getKeyboard()->sendKeys('php-webdriver');

        // pressing "Enter"
        $this->webDriver->getKeyboard()->pressKey(WebDriverKeys::ENTER);

        $firstResult = $this->webDriver->findElement(
            // select link for php-webdriver
            WebDriverBy::partialLinkText('facebook')
        );

        $firstResult->click();

        // we expect that facebook/php-webdriver was the first result
        $this->assertContains("php-webdriver",$this->webDriver->getTitle());

        $this->assertEquals('https://github.com/facebook/php-webdriver', $this->webDriver->getCurrentURL());

        $this->assertElementNotFound(WebDriverBy::className('name'));

        // $this->waitForUserInput();
    }

}
