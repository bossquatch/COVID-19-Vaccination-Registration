<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Throwable;

class CreateUserTest extends DuskTestCase
{

    /**
     * A basic browser test to create a user account on register.polk.health.
     *
     * @test
     * @throws Throwable
     */

    public function createUser()
    {
//        {
////            $user = User::factory()->create([
//                /*'first_name' => 'Samuel',
//                'middle_name' => 'Lawrence',
//                'last_name' => 'Jackson',
//                'date_of_birth' => '01/31/1967',
//                'email' => 'zane.kapo@yahoo.com',
//                'phone' => '8631111111',
//                'password' => 'secret123',
//                'password_confirmation' => 'secret123'*/
//            ]);

                $this->browse(function ($browser) {
                    $browser->visit('http://localhost:8000')
                        ->assertPathIs('/')
                        ->click('@register-button')
                        ->assertPathIs('/register')
                        ->type('@firstName', 'Samuel')
                        ->type('lastName', 'Jackson')
                        ->select('@suffix', 'Jr.')
                        ->type('email', 'zane.kapo@yahoo.com')
                        ->type('phone', '8631111111')
                        ->type('password', 'secret123')
                        ->type('password_confirmation', 'secret123')
                        ->press('Register');
                });
            }

}

