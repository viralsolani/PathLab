<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{
    /**
     * Test if login page renders properly
     *
     * @return void
     */
    public function test_login_page_loads_properly()
    {
        $this->visit('/')
            ->see("Email")
            ->see("Password")
            ->see("Login")
            ->dontSee('You are logged in!');
    }

    /**
     * Test Case : if i redirect to login if i try to check any other page
     *      *
     * @return void
     */
    public function test_i_am_redirect_to_login_if_i_try_to_view_report_lists_without_logging_in()
    {
        $this->visit('/reports')->see('Login');
    }

    /**
     * Test Case : Press 'Login' on the homepage without inputs
     *
     */
    public function test_login_failure_without_inputs()
    {
        $this->visit('/')
            ->press('Login')
            ->seePageIs('/login')
            ->see('The email field is required.')
            ->see('The password field is required.');
    }

    /**
     * Test Case : Press 'Login' with worng inputs
     *
     */
    public function test_login_failure_with_wrong_inputs_1()
    {
        $this->visit('/login')
            ->type('test@111.com', 'email')
            ->press('Login')
            ->seePageIs('/login')
            ->see('The password field is required.');
    }

    /**
     * Test Case : Press 'Login' with worng inputs
     *
     */
    public function test_login_failure_with_wrong_inputs_2()
    {
        $this->visit("/")
            ->type('wrongusername@wrongpassword.com', 'email')
            ->type('wrongpassword', 'password')
            ->press('Login')
            ->seePageIs('/login')
            ->see('These credentials do not match our records.');
    }

    /**
     * Test Case : Login with operator
     *
     */
    public function test_if_i_can_do_log_in_with_operator()
    {
        $this->visit("/")
            ->type('operator@operator.com', 'email')
            ->type('password', 'password')
            ->press('Login')
            ->seePageIs('/home')
            ->see('You are logged in!');
    }

    /**
     * Test Case : Login with patient
     *
     */
    public function test_if_i_can_do_log_in_with_patient()
    {
        $this->visit("/")
            ->type('patient@gmail.com', 'email')
            ->type('password', 'password')
            ->press('Login')
            ->seePageIs('/home')
            ->see('You are logged in!')
            ->dontSee('User Management');
    }

}
