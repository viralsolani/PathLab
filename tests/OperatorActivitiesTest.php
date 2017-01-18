<?php

use App\Models\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class OperatorActivitiesTest extends TestCase
{

    /**
     * Test Validation - Create User
     */
    public function test_validation_of_create_patient()
    {
        $this->actingAs($this->operator)
            ->visit('/home')->seePageIs('/home')
            ->click('User Management')
            ->click('Users')->seePageIs('/users')
            ->click('Add new')->seePageIs('users/create')
            ->type("", "name")
            ->type("", "email")
            ->type("", "password")
            ->select("", "role_id")
            ->type("", "dob")
            ->type("", "phone")
            ->press('Save')->seePageIs("/users/create")
                ->see("The name field is required.")
                ->see("The email field is required.")
                ->see("The password field is required.")
                ->see("The role id field is required.");
    }

    /**
     * Test - Create patient with previously entered email
     * @return [type] [description]
     */
    public function test_create_patient_with_already_registered_email()
    {
        $this->actingAs($this->operator)
            ->visit('/home')->seePageIs('/home')
            ->click('User Management')
            ->click('Users')->seePageIs('/users')
            ->click('Add new')->seePageIs('users/create')
            ->type("Test Patient", "name")
            ->type("patient@gmail.com", "email")
            ->type("123456", "password")
            ->select("2", "role_id")
            ->type("05-07-1986", "dob")
            ->type("9016608346", "phone")
            ->press('Save')->seePageIs("/users/create")->see("The email has already been taken");
    }

    /**
     * Test Create patient
     *
     */
    public function test_create_patient()
    {
        $this->actingAs($this->operator)
            ->visit('/home')->seePageIs('/home')
            ->click('User Management')
            ->click('Users')->seePageIs('/users')
            ->click('Add new')->seePageIs('users/create')
            ->type("Test Patient", "name")
            ->type("test@test.com", "email")
            ->type("123456", "password")
            ->select("2", "role_id")
            ->type("05-07-1986", "dob")
            ->type("9016608346", "phone")
            ->press('Save')->seePageIs("/users")->see("Test Patient");
    }

    /**
     * Test Edit patient
     *
     */
    public function test_edit_patient()
    {
        // delete this user
        $patient = User::where('email', '=', 'test@test.com')->first();

        $this->actingAs($this->operator)
            ->visit("/users/$patient->id/edit")
            ->see("Edit")->see($patient->name)->see($patient->email)
            ->type("Test Patient Updated", "name")
            ->type("test@test.com", "email")
            ->type("123456", "password")
            ->select("2", "role_id")
            ->type("05-07-1984", "dob")
            ->type("9016608345", "phone")
            ->press('Update')->seePageIs("/users")->see("Test Patient Updated");

            // delete this user
            User::where('email', '=', 'test@test.com')->forceDelete();
    }

    /**
     * Test Edit patient
     *
     */
    /*public function test_delete_patient()
    {
        // delete this user
        $patient = User::where('email', '=', 'test@test.com')->first();

        $this->withoutMiddleware();
        $response = $this->call('DELETE', "/users/$patient->id", ['_token' => csrf_token()]);

        $this->assertEquals(302, $response->getStatusCode());
        $this->notSeeInDatabase('users', ['deleted_at' => null, 'id' => $patient->id]);
    }*/

    /**
     * Test Validation - Create User
     */
    public function test_validation_of_create_test()
    {
        $this->actingAs($this->operator)
            ->visit('/home')->seePageIs('/home')
            ->click('Reports Management')
            ->click('Tests')->seePageIs('/tests')
            ->click('Add new')->seePageIs('tests/create')
            ->type("", "name")
            ->press('Save')->seePageIs("/tests/create")
                ->see("The name field is required.");
    }

    /**
     * Test Create test
     *
     */
    public function test_create_test()
    {
        $this->actingAs($this->operator)
            ->visit('/home')->seePageIs('/home')
            ->click('User Management')
            ->click('Tests')->seePageIs('/tests')
            ->click('Add new')->seePageIs('tests/create')
            ->type("Medical Test", "name")
            ->type("Medical Test", "description")
            ->press('Save')->seePageIs("/tests")->see("Medical Test");
    }

}
