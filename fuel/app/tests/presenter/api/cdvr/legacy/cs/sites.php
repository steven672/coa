<?php

    /**
     * @group App
     * @group Presenters
     */

    class Test_API_cDVR_Legacy_CS_Sites extends TestCase
    {
        // TODO: Create tests for the view function (refer to the tests below for the validRegion function for example syntax and edge cases)

        // Validation tests using the data from this presenter for validRegion (ensure correct data set); don't test general edge cases (covered in the validator's unit tests already), test only the list expected

        // Test a valid region name to ensure the region list is built correctly:
        // Here we use array_column to create an array of all values associated with the key 'db' in every array within the listOfRegions array,
        // then test that each region is in that created array using assertContains.

        // Test a valid region name to ensure the region list is built correctly
        public function test_validRegion_albuquerque()
        {
            $presenter = Presenter::forge('api/cdvr/legacy/cs/sites', 'view', null, 'api/response');
            $this->assertContains('albuquerque', array_column($presenter->listOfRegions, 'db'),
                "Presenter :: api/cdvr/legacy/cs/sites :: True when albuquerqueis in the region list");
        }

        // Test a valid region name to ensure the region list is built correctly
        public function test_validRegion_vinings()
        {
            $presenter = Presenter::forge('api/cdvr/legacy/cs/sites', 'view', null, 'api/response');
            $this->assertContains('vinings', array_column($presenter->listOfRegions, 'db'),
                "Presenter :: api/cdvr/legacy/cs/sites :: True when vinings is in the region list");
        }

        // Test a valid region name to ensure the region list is built correctly
        public function test_validRegion_sanjose_sfba()
        {
            $presenter = Presenter::forge('api/cdvr/legacy/cs/sites', 'view', null, 'api/response');
            $this->assertContains('sanjose_sfba', array_column($presenter->listOfRegions, 'db'),
                "Presenter :: api/cdvr/legacy/cs/sites :: True when sanjose_sfba is in the region list");
        }

                // Test a valid region name to ensure the region list is built correctly
        public function test_validRegion_richmond_stpmill()
        {
            $presenter = Presenter::forge('api/cdvr/legacy/cs/sites', 'view', null, 'api/response');
            $this->assertContains('richmond_stpmill', array_column($presenter->listOfRegions, 'db'),
                "Presenter :: api/cdvr/legacy/cs/sites :: True when richmond_stpmill is in the region list");
        }


                // Test a valid region name to ensure the region list is built correctly
        public function test_validRegion_manassas()
        {
            $presenter = Presenter::forge('api/cdvr/legacy/cs/sites', 'view', null, 'api/response');
            $this->assertContains('manassas', array_column($presenter->listOfRegions, 'db'),
                "Presenter :: api/cdvr/legacy/cs/sites :: True when manassas is in the region list");
        }



                // Test a valid region name to ensure the region list is built correctly
        public function test_validRegion_sacramento_ccal()
        {
            $presenter = Presenter::forge('api/cdvr/legacy/cs/sites', 'view', null, 'api/response');
            $this->assertContains('sacramento_ccal', array_column($presenter->listOfRegions, 'db'),
                "Presenter :: api/cdvr/legacy/cs/sites :: True when sacramento_ccal is in the region list");
        }

                // Test a valid region name to ensure the region list is built correctly
        public function test_validRegion_MtProspect()
        {
            $presenter = Presenter::forge('api/cdvr/legacy/cs/sites', 'view', null, 'api/response');
            $this->assertContains('mtprospect', array_column($presenter->listOfRegions, 'db'),
                "Presenter :: api/cdvr/legacy/cs/sites :: True when mtprospect is in the region list");
        }

        // Test a valid region name to ensure the region list is built correctly
        public function test_validRegion_denver()
        {
            $presenter = Presenter::forge('api/cdvr/legacy/cs/sites', 'view', null, 'api/response');
            $this->assertContains('denver', array_column($presenter->listOfRegions, 'db'),
                "Presenter :: api/cdvr/legacy/cs/sitmtprospectes :: True when denver is in the region list");
        }

        // Test a valid region name to ensure the region list is built correctly
        public function test_validRegion_plainfield_freeeast()
        {
            $presenter = Presenter::forge('api/cdvr/legacy/cs/sites', 'view', null, 'api/response');
            $this->assertContains('plainfield_freeeast', array_column($presenter->listOfRegions, 'db'),
                "Presenter :: api/cdvr/legacy/cs/sites :: True when plainfield_freeeast is in the region list");
        }

        // Test a valid region name to ensure the region list is built correctly
        public function test_validRegion_newcastle_freewest()
        {
            $presenter = Presenter::forge('api/cdvr/legacy/cs/sites', 'view', null, 'api/response');
            $this->assertContains('newcastle_freewest', array_column($presenter->listOfRegions, 'db'),
                "Presenter :: api/cdvr/legacy/cs/sites :: True when newcastle_freewest is in the region list");
        }

        // Test a valid region name to ensure the region list is built correctly
        public function test_validRegion_foxboro_gbr()
        {
            $presenter = Presenter::forge('api/cdvr/legacy/cs/sites', 'view', null, 'api/response');
            $this->assertContains('foxboro_gbr', array_column($presenter->listOfRegions, 'db'),
                "Presenter :: api/cdvr/legacy/cs/sites :: True when foxboro_gbr is in the region list");
        }

        // Test a valid region name to ensure the region list is built correctly
        public function test_validRegion_katy()
        {
            $presenter = Presenter::forge('api/cdvr/legacy/cs/sites', 'view', null, 'api/response');
            $this->assertContains('katy', array_column($presenter->listOfRegions, 'db'),
                "Presenter :: api/cdvr/legacy/cs/sites :: True when katy is in the region list");
        }

        // Test a valid region name to ensure the region list is built correctly
        public function test_validRegion_jacksonville_fl()
        {
            $presenter = Presenter::forge('api/cdvr/legacy/cs/sites', 'view', null, 'api/response');
            $this->assertContains('jacksonville_fl', array_column($presenter->listOfRegions, 'db'),
                "Presenter :: api/cdvr/legacy/cs/sites :: True when jacksonville_fl is in the region list");
        }

        // Test a valid region name to ensure the region list is built correctly
        public function test_validRegion_corliss()
        {
            $presenter = Presenter::forge('api/cdvr/legacy/cs/sites', 'view', null, 'api/response');
            $this->assertContains('corliss', array_column($presenter->listOfRegions, 'db'),
                "Presenter :: api/cdvr/legacy/cs/sites :: True when corliss is in the region list");
        }

        // Test a valid region name to ensure the region list is built correctly
        public function test_validRegion_memphis_tn()
        {
            $presenter = Presenter::forge('api/cdvr/legacy/cs/sites', 'view', null, 'api/response');
            $this->assertContains('memphis_tn', array_column($presenter->listOfRegions, 'db'),
                "Presenter :: api/cdvr/legacy/cs/sites :: True when memphis_tn is in the region list");
        }

        // Test a valid region name to ensure the region list is built correctly
        public function test_validRegion_miami_fl()
        {
            $presenter = Presenter::forge('api/cdvr/legacy/cs/sites', 'view', null, 'api/response');
            $this->assertContains('miami_fl', array_column($presenter->listOfRegions, 'db'),
                "Presenter :: api/cdvr/legacy/cs/sites :: True when miami_fl is in the region list");
        }



        // Test a valid region name to ensure the region list is built correctly
        public function test_validRegion_naples_fl()
        {
            $presenter = Presenter::forge('api/cdvr/legacy/cs/sites', 'view', null, 'api/response');
            $this->assertContains('naples_fl', array_column($presenter->listOfRegions, 'db'),
                "Presenter :: api/cdvr/legacy/cs/sites :: True when naples_fl is in the region list");
        }


        // Test a valid region name to ensure the region list is built correctly
        public function test_validRegion_nashville()
        {
            $presenter = Presenter::forge('api/cdvr/legacy/cs/sites', 'view', null, 'api/response');
            $this->assertContains('nashville', array_column($presenter->listOfRegions, 'db'),
                "Presenter :: api/cdvr/legacy/cs/sites :: True when nashville is in the region list");
        }

        // Test a valid region name to ensure the region list is built correctly
        public function test_validRegion_portland()
        {
            $presenter = Presenter::forge('api/cdvr/legacy/cs/sites', 'view', null, 'api/response');
            $this->assertContains('portland', array_column($presenter->listOfRegions, 'db'),
                "Presenter :: api/cdvr/legacy/cs/sites :: True when portland is in the region list");
        }

        // Test a valid region name to ensure the region list is built correctly
        public function test_validRegion_salt_lake_city()
        {
            $presenter = Presenter::forge('api/cdvr/legacy/cs/sites', 'view', null, 'api/response');
            $this->assertContains('salt_lake_city', array_column($presenter->listOfRegions, 'db'),
                "Presenter :: api/cdvr/legacy/cs/sites :: True when salt_lake_city is in the region list");
        }

        // Test a valid region name to ensure the region list is built correctly
        public function test_validRegion_seattle()
        {
            $presenter = Presenter::forge('api/cdvr/legacy/cs/sites', 'view', null, 'api/response');
            $this->assertContains('seattle', array_column($presenter->listOfRegions, 'db'),
                "Presenter :: api/cdvr/legacy/cs/sites :: True when seattle is in the region list");
        }

        // Test a valid region name to ensure the region list is built correctly
        public function test_validRegion_tallahassee_fl()
        {
            $presenter = Presenter::forge('api/cdvr/legacy/cs/sites', 'view', null, 'api/response');
            $this->assertContains('tallahassee_fl', array_column($presenter->listOfRegions, 'db'),
                "Presenter :: api/cdvr/legacy/cs/sites :: True when tallahassee_fl is in the region list");
        }

        // Test a valid region name to ensure the region list is built correctly
        public function test_validRegion_foxboro_wner()
        {
            $presenter = Presenter::forge('api/cdvr/legacy/cs/sites', 'view', null, 'api/response');
            $this->assertContains('foxboro_wner', array_column($presenter->listOfRegions, 'db'),
                "Presenter :: api/cdvr/legacy/cs/sites :: True when foxboro_wner is in the region list");
        }
  }

?>