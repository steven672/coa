<?php

    /**
     * @group App
     * @group Presenters
     */

    class Test_API_cDVR_Legacy_Recorders_Throughput extends TestCase
    {
        // TODO: Create tests for the view function (refer to the tests below for the validRegion function for example syntax and edge cases)

        // Validation tests using the data from this presenter for validRegion (ensure correct data set); don't test general edge cases (covered in the validator's unit tests already), test only the list expected

        // public function test_arrayKeyExists()
        // {
        //     $presenter = Presenter::forge('api/cdvr/legacy/recorders/throughput', 'view', 0, 'api/response');
        //     $this->assertContainsOnly('dsb',array_keys($presenter->listOfRegions, null));

        //     // Gets a list of all the 2nd-level keys in the array
        // function getL2Keys($array)
        // {
        //     $result = array();
        //     foreach($array as $sub) {
        //         $result = array_merge($result, $sub);
        //     }        
        //     return array_keys($result);

        //     print_r($result);
        // }

        //     print_r(getL2Keys($presenter->listOfRegions));
        // }

        // Test a valid region name to ensure the region list is built correctly:
        // Here we use array_column to create an array of all values associated with the key 'db' in every array within the listOfRegions array, 
        // then test that each region is in that created array using assertContains.

        // Test a valid region name to ensure the region list is built correctly
        public function test_validRegion_albq()
        {
            $presenter = Presenter::forge('api/cdvr/legacy/recorders/throughput', 'view', null, 'api/response');
            $this->assertContains('albq', array_column($presenter->listOfRegions, 'db'),
                "Presenter :: api/cdvr/legacy/recorders/throughput :: True when albq is in the region list");
        }

        // Test a valid region name to ensure the region list is built correctly
        public function test_validRegion_Vinings()
        {
            $presenter = Presenter::forge('api/cdvr/legacy/recorders/throughput', 'view', null, 'api/response');
            $this->assertContains('vinings', array_column($presenter->listOfRegions, 'db'),
                "Presenter :: api/cdvr/legacy/recorders/throughput :: True when vinings is in the region list");
        }

        // Test a valid region name to ensure the region list is built correctly
        public function test_validRegion_sjos()
        {
            $presenter = Presenter::forge('api/cdvr/legacy/recorders/throughput', 'view', null, 'api/response');
            $this->assertContains('sjos', array_column($presenter->listOfRegions, 'db'),
                "Presenter :: api/cdvr/legacy/recorders/throughput :: True when sjos is in the region list");
        }

                // Test a valid region name to ensure the region list is built correctly
        public function test_validRegion_mana()
        {
            $presenter = Presenter::forge('api/cdvr/legacy/recorders/throughput', 'view', null, 'api/response');
            $this->assertContains('mana', array_column($presenter->listOfRegions, 'db'),
                "Presenter :: api/cdvr/legacy/recorders/throughput :: True when mana is in the region list");
        }

                // Test a valid region name to ensure the region list is built correctly
        public function test_validRegion_stpm()
        {
            $presenter = Presenter::forge('api/cdvr/legacy/recorders/throughput', 'view', null, 'api/response');
            $this->assertContains('stpm', array_column($presenter->listOfRegions, 'db'),
                "Presenter :: api/cdvr/legacy/recorders/throughput :: True when stpm is in the region list");
        }

                // Test a valid region name to ensure the region list is built correctly
        public function test_validRegion_rnch()
        {
            $presenter = Presenter::forge('api/cdvr/legacy/recorders/throughput', 'view', null, 'api/response');
            $this->assertContains('rnch', array_column($presenter->listOfRegions, 'db'),
                "Presenter :: api/cdvr/legacy/recorders/throughput :: True when rnch is in the region list");
        }

                // Test a valid region name to ensure the region list is built correctly
        public function test_validRegion_MtProspect()
        {
            $presenter = Presenter::forge('api/cdvr/legacy/recorders/throughput', 'view', null, 'api/response');
            $this->assertContains('mtprospect', array_column($presenter->listOfRegions, 'db'),
                "Presenter :: api/cdvr/legacy/recorders/throughput :: True when mtprospect is in the region list");
        }

        // Test a valid region name to ensure the region list is built correctly
        public function test_validRegion_dnvr()
        {
            $presenter = Presenter::forge('api/cdvr/legacy/recorders/throughput', 'view', null, 'api/response');
            $this->assertContains('dnvr', array_column($presenter->listOfRegions, 'db'),
                "Presenter :: api/cdvr/legacy/recorders/throughput :: True when dnvr is in the region list");
        }

        // Test a valid region name to ensure the region list is built correctly
        public function test_validRegion_seca()
        {
            $presenter = Presenter::forge('api/cdvr/legacy/recorders/throughput', 'view', null, 'api/response');
            $this->assertContains('seca', array_column($presenter->listOfRegions, 'db'),
                "Presenter :: api/cdvr/legacy/recorders/throughput :: True when seca is in the region list");
        }

        // Test a valid region name to ensure the region list is built correctly
        public function test_validRegion_ncst()
        {
            $presenter = Presenter::forge('api/cdvr/legacy/recorders/throughput', 'view', null, 'api/response');
            $this->assertContains('ncst', array_column($presenter->listOfRegions, 'db'),
                "Presenter :: api/cdvr/legacy/recorders/throughput :: True when ncst is in the region list");
        }

        // Test a valid region name to ensure the region list is built correctly
        public function test_validRegion_foxboro_g()
        {
            $presenter = Presenter::forge('api/cdvr/legacy/recorders/throughput', 'view', null, 'api/response');
            $this->assertContains('foxboro_g', array_column($presenter->listOfRegions, 'db'),
                "Presenter :: api/cdvr/legacy/recorders/throughput :: True when foxboro_g is in the region list");
        }

        // Test a valid region name to ensure the region list is built correctly
        public function test_validRegion_katy()
        {
            $presenter = Presenter::forge('api/cdvr/legacy/recorders/throughput', 'view', null, 'api/response');
            $this->assertContains('katy', array_column($presenter->listOfRegions, 'db'),
                "Presenter :: api/cdvr/legacy/recorders/throughput :: True when katy is in the region list");
        }

        // Test a valid region name to ensure the region list is built correctly
        public function test_validRegion_jacksonville()
        {
            $presenter = Presenter::forge('api/cdvr/legacy/recorders/throughput', 'view', null, 'api/response');
            $this->assertContains('jacksonville', array_column($presenter->listOfRegions, 'db'),
                "Presenter :: api/cdvr/legacy/recorders/throughput :: True when jacksonville is in the region list");
        }

        // Test a valid region name to ensure the region list is built correctly
        public function test_validRegion_pittsburgh()
        {
            $presenter = Presenter::forge('api/cdvr/legacy/recorders/throughput', 'view', null, 'api/response');
            $this->assertContains('pittsburgh', array_column($presenter->listOfRegions, 'db'),
                "Presenter :: api/cdvr/legacy/recorders/throughput :: True when pittsburgh is in the region list");
        }

        // Test a valid region name to ensure the region list is built correctly
        public function test_validRegion_memphis()
        {
            $presenter = Presenter::forge('api/cdvr/legacy/recorders/throughput', 'view', null, 'api/response');
            $this->assertContains('memphis', array_column($presenter->listOfRegions, 'db'),
                "Presenter :: api/cdvr/legacy/recorders/throughput :: True when memphis is in the region list");
        }

        // Test a valid region name to ensure the region list is built correctly
        public function test_validRegion_miami_s()
        {
            $presenter = Presenter::forge('api/cdvr/legacy/recorders/throughput', 'view', null, 'api/response');
            $this->assertContains('miami_s', array_column($presenter->listOfRegions, 'db'),
                "Presenter :: api/cdvr/legacy/recorders/throughput :: True when miami_s is in the region list");
        }

        // Test a valid region name to ensure the region list is built correctly
        public function test_validRegion_nashville()
        {
            $presenter = Presenter::forge('api/cdvr/legacy/recorders/throughput', 'view', null, 'api/response');
            $this->assertContains('nashville', array_column($presenter->listOfRegions, 'db'),
                "Presenter :: api/cdvr/legacy/recorders/throughput :: True when nashville is in the region list");
        }

        // Test a valid region name to ensure the region list is built correctly
        public function test_validRegion_miami_w()
        {
            $presenter = Presenter::forge('api/cdvr/legacy/recorders/throughput', 'view', null, 'api/response');
            $this->assertContains('miami_w', array_column($presenter->listOfRegions, 'db'),
                "Presenter :: api/cdvr/legacy/recorders/throughput :: True when miami_w is in the region list");
        }

        // Test a valid region name to ensure the region list is built correctly
        public function test_validRegion_portland()
        {
            $presenter = Presenter::forge('api/cdvr/legacy/recorders/throughput', 'view', null, 'api/response');
            $this->assertContains('portland', array_column($presenter->listOfRegions, 'db'),
                "Presenter :: api/cdvr/legacy/recorders/throughput :: True when portland is in the region list");
        }

        // Test a valid region name to ensure the region list is built correctly
        public function test_validRegion_stlk()
        {
            $presenter = Presenter::forge('api/cdvr/legacy/recorders/throughput', 'view', null, 'api/response');
            $this->assertContains('stlk', array_column($presenter->listOfRegions, 'db'),
                "Presenter :: api/cdvr/legacy/recorders/throughput :: True when stlk is in the region list");
        }

        // Test a valid region name to ensure the region list is built correctly
        public function test_validRegion_s116thseattle()
        {
            $presenter = Presenter::forge('api/cdvr/legacy/recorders/throughput', 'view', null, 'api/response');
            $this->assertContains('s116thseattle', array_column($presenter->listOfRegions, 'db'),
                "Presenter :: api/cdvr/legacy/recorders/throughput :: True when s116thseattle is in the region list");
        }

        // Test a valid region name to ensure the region list is built correctly
        public function test_validRegion_tallahassee()
        {
            $presenter = Presenter::forge('api/cdvr/legacy/recorders/throughput', 'view', null, 'api/response');
            $this->assertContains('tallahassee', array_column($presenter->listOfRegions, 'db'),
                "Presenter :: api/cdvr/legacy/recorders/throughput :: True when tallahassee is in the region list");
        }

        // Test a valid region name to ensure the region list is built correctly
        public function test_validRegion_foxboro_w()
        {
            $presenter = Presenter::forge('api/cdvr/legacy/recorders/throughput', 'view', null, 'api/response');
            $this->assertContains('foxboro_w', array_column($presenter->listOfRegions, 'db'),
                "Presenter :: api/cdvr/legacy/recorders/throughput :: True when foxboro_w is in the region list");
        }
  }

?>