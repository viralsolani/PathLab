<?php

use App\Models\Test;
use App\Models\User;
use App\Models\Report;
use Carbon\Carbon as Carbon;
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
            ->type("solani.viral@gmail.com", "email")
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
        $patient = User::where('email', '=', 'solani.viral@gmail.com')->first();

        $this->actingAs($this->operator)
            ->visit("/users/$patient->id/edit")
            ->see("Edit")->see($patient->name)->see($patient->email)
            ->type("Test Patient Updated", "name")
            ->type("solani.viral@gmail.com", "email")
            ->type("123456", "password")
            ->select("2", "role_id")
            ->type("05-07-1984", "dob")
            ->type("9016608345", "phone")
            ->press('Update')->seePageIs("/users")->see("Test Patient Updated");

            // delete this user
            User::where('email', '=', 'solani.viral@gmail.com')->forceDelete();
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
     * Test Validation - Create test
     */
    public function test_validation_of_create_test()
    {
        $this->actingAs($this->operator)
            ->visit('/home')->seePageIs('/home')
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
            ->click('Tests')->seePageIs('/tests')
            ->click('Add new')->seePageIs('tests/create')
            ->type("Medical Test", "name")
            ->type("Medical Test", "description")
            ->press('Save')->seePageIs("/tests")->see("Medical Test");
    }

    /**
     * Test Edit test
     *
     */
    public function test_edit_test()
    {

        $item = Test::where('name', '=', 'Medical Test')->first();

        $this->actingAs($this->operator)
            ->visit("/tests/$item->id/edit")
            ->see("Edit")->see($item->name)
            ->type("Medical Test Updated", "name")
            ->type("Medical Test Updated", "description")
            ->press('Update')->seePageIs("/tests")->see("Medical Test Updated");

            // delete this test
            Test::where('name', '=', 'Medical Test Updated')->forceDelete();
    }

    /**
     * Test Validation - Create report
     */
    public function test_validation_of_create_report()
    {
        $this->actingAs($this->operator)
            ->visit('/home')->seePageIs('/home')
            ->click('Reports')->seePageIs('/reports')
            ->click('Add new')->seePageIs('reports/create')
            ->type("", "name")
            ->press('Save')->seePageIs("/reports/create")
                ->see("The name field is required.")
                ->see("The user id field is required.");
    }

    /**
     * Test Create report
     */
    public function test_create_report()
    {
        $this->actingAs($this->operator)
            ->visit('/home')->seePageIs('/home')
            ->click('Reports')->seePageIs('/reports')
            ->click('Add new')->seePageIs('reports/create')
            ->type("Report1", "name")
            ->select("2", "user_id")
            ->type("Report1 Details", "details")
            ->press('Save')->seePageIs("/reports")->see("Report1");
    }

    /**
     * Test edit report
     */
    public function test_edit_report()
    {
        $item = Report::where('name', '=', 'Report1')->first();

        $this->actingAs($this->operator)
            ->visit("/reports/$item->id/edit")
            ->see("Edit")->see($item->name)
            ->type("Report2", "name")
            ->type("Report2", "details")
            ->press('Update')->seePageIs("/reports")->see("Report2");
    }

    /**
     * Test Report's Add test feature
     */
    public function test_report_add_test_feature()
    {
        $item = Report::where('name', '=', 'Report2')->first();

        $this->actingAs($this->operator)
            ->visit("/reports/$item->id/tests")
            ->see("Add Test Result")->see($item->name)
            ->select('1','test')
            ->type("15", "result")
            ->press('Save')->see("The test has been successfully added to report.");
    }

    /**
     * Test Report with test view
     */
    public function test_report_with_tests_view()
    {
        $item = Report::where('name', '=', 'Report2')->first();

        $this->actingAs($this->operator)
            ->visit("/reports/$item->id")
            ->see("Reports")
            ->see($item->name)
            ->see('Patient Name');
    }

    /**
     * Test download pdf report
     */
    public function test_download_reports_in_pdf_format()
    {
        $item = Report::where('name', '=', 'Report2')->first();

        $this->actingAs($this->operator)
            ->visit("/reports/$item->id")
            ->see("Reports")
            ->see($item->name)
            ->see('Patient Name')
            ->click('Download');
    }

    /**
     * Test email reports
     */
    public function test_send_email_of_reports_in_pdf_format()
    {
        $item = Report::where('name', '=', 'Report2')->first();

        $this->actingAs($this->operator)
            ->visit("/reports/$item->id")
            ->see("Reports")
            ->see($item->name)
            ->see('Patient Name')
            ->type('solani.viral@gmail.com','email')
            ->type('TDD','message')
            ->press('Save')
            ->see('The report has been successfully send.');
    }



}
