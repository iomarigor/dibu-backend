<?php
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Artisan;

class ExampleTest extends TestCase
{
    public function testTrueIsTrue(){
        $response=TRUE;
        $this->assertEquals(true, $response);
    }
}
