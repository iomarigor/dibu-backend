<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->get('/');

        $this->assertEquals(
            '<h1>API REST</h1> </br> Lumen (7.2.2) (Laravel Components ^7.0)',
            $this->response->getContent()
        );
    }
}
