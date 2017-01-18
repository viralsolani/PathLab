<?php

use App\Models\Role;
use App\Models\User;

abstract class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';


    /**
     * @var
     */
    protected $operator;

    /**
     * @var
     */
    protected $patient;

    /**
     * @var
     */
    protected $operatorRole;

    /**
     * @var
     */
    protected $patientRole;

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }

    /**
     * Set up tests.
     */
    public function setUp()
    {
        parent::setUp();

        // Set up the database
        /*Artisan::call('migrate:refresh');
        Artisan::call('db:seed');*/

        /*
         * Create class properties to be used in tests
         */

        $this->operator = User::find(1);
        $this->patient = User::find(2);
        $this->operatorRole = Role::find(1);
        $this->patientRole = Role::find(3);
    }
}
