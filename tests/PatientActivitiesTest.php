<?php

use App\Models\Report;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PatientActivitiesTest extends TestCase
{
    /**
     * Test Case : Login with patient
     * @group patient
     */
    public function test_if_i_can_do_log_in_with_operator()
    {
        $this->visit("/")
            ->type('patient@gmail.com', 'email')
            ->type('password', 'password')
            ->press('Login')
            ->seePageIs('/home')
            ->see('You are logged in!')
            ->dontSee('User Management');
    }

    /**
     * Test view report
     * @group patient
     */
    public function test_go_to_reports()
    {
        $this->actingAs($this->patient)
            ->visit('/home')->seePageIs('/home')
            ->click('Reports')->seePageIs('/reports')
            ->see('Reports')
            ->see('List');
    }

    /**
     * Test Report with test view
     * @group patient
     */
    public function test_report_with_tests_view()
    {
        $item = Report::where('name', '=', 'Vitmain Profile')->first();

        $this->actingAs($this->patient)
            ->visit("/reports/$item->id")
            ->see("Reports")
            ->see($item->name)
            ->see('Patient Name');
    }

    /**
     * Test download pdf report
     * @group patient
     */
    public function test_download_reports_in_pdf_format()
    {
        $item = Report::where('name', '=', 'Vitmain Profile')->first();

        $this->actingAs($this->patient)
            ->visit("/reports/$item->id")
            ->see("Reports")
            ->see($item->name)
            ->see('Patient Name')
            ->click('Download');
    }

    /**
     * Test email reports
     * @group patient
     */
    public function test_send_email_of_reports_in_pdf_format()
    {
        $item = Report::where('name', '=', 'Vitmain Profile')->first();

        $this->actingAs($this->patient)
            ->visit("/reports/$item->id")
            ->see("Reports")
            ->see($item->name)
            ->see('Patient Name')
            ->type('solani.viral@gmail.com','email')
            ->type('TDD Patient','message')
            ->press('Save')
            ->see('The report has been successfully send.');
    }
}
