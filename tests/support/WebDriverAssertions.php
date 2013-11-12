<?php
trait WebDriverAssertions {

    protected function assertElementNotFound($by)
    {
        try {
            $this->webDriver->findElement($by);
        } catch (\NoSuchElementWebDriverError $e) {
            $this->assertTrue(true);
            return;
        }
        $this->fail("Unexpectedly element was found");
        
    }
    
}