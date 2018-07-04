<?php

    /**
     * @group App
     * @group Sites
     * @group Presenters
     */

    class Test_API_cDVR_Legacy_Recorders_Sites extends TestCase
    {
        // TODO: Create tests for the view function (refer to the tests below for the validRegion function for example syntax and edge cases)

        // Validation tests using the data from this presenter for validRegion (ensure correct data set); don't test general edge cases (covered in the validator's unit tests already), test only the list expected


        // Test a valid region name to ensure the region list is built correctly:
        // Here we use array_column to create an array of all values associated with the key 'db' in every array within the listOfRegions array, 
        // then test that each region is in that created array using assertContains.

        // Test a valid region name to ensure the region list is built correctly
        public function test_validRegion_cisco_albq()
        {
            $presenter = Presenter::forge('api/cdvr/legacy/recorders/sites', 'view', null, 'api/response');
            $this->assertContains('#CISCO: ALBQ', array_column($presenter->listOfRegions, 'db'),
                "Presenter :: api/cdvr/legacy/recorders/sites :: True when #CISCO: ALBQ is in the region list");
        }

                // Test a valid region name to ensure the region list is built correctly
        public function test_validRegion_arris_vngs()
        {
            $presenter = Presenter::forge('api/cdvr/legacy/recorders/sites', 'view', null, 'api/response');
            $this->assertContains('#ARRIS: VNGS', array_column($presenter->listOfRegions, 'db'),
                "Presenter :: api/cdvr/legacy/recorders/sites :: True when #ARRIS: VNGS is in the region list");
        }

                // Test a valid region name to ensure the region list is built correctly
        public function test_validRegion_cisco_sjos()
        {
            $presenter = Presenter::forge('api/cdvr/legacy/recorders/sites', 'view', null, 'api/response');
            $this->assertContains('#CISCO: SJOS', array_column($presenter->listOfRegions, 'db'),
                "Presenter :: api/cdvr/legacy/recorders/sites :: True when #CISCO: SJOS is in the region list");
        }

                        // Test a valid region name to ensure the region list is built correctly
        public function test_validRegion_cisco_mana()
        {
            $presenter = Presenter::forge('api/cdvr/legacy/recorders/sites', 'view', null, 'api/response');
            $this->assertContains('#CISCO: MANA', array_column($presenter->listOfRegions, 'db'),
                "Presenter :: api/cdvr/legacy/recorders/sites :: True when #CISCO: MANA is in the region list");
        }

                        // Test a valid region name to ensure the region list is built correctly
        public function test_validRegion_cisco_stpm()
        {
            $presenter = Presenter::forge('api/cdvr/legacy/recorders/sites', 'view', null, 'api/response');
            $this->assertContains('#CISCO: STPM', array_column($presenter->listOfRegions, 'db'),
                "Presenter :: api/cdvr/legacy/recorders/sites :: True when #CISCO: STPM is in the region list");
        }

        public function test_validRegion_cisco_rnch()
        {
            $presenter = Presenter::forge('api/cdvr/legacy/recorders/sites', 'view', null, 'api/response');
            $this->assertContains('#CISCO: RNCH', array_column($presenter->listOfRegions, 'db'),
                "Presenter :: api/cdvr/legacy/recorders/sites :: True when #CISCO: RNCH is in the region list");
        }

        public function test_validRegion_arris_mtpr()
        {
            $presenter = Presenter::forge('api/cdvr/legacy/recorders/sites', 'view', null, 'api/response');
            $this->assertContains('#ARRIS: MTPR', array_column($presenter->listOfRegions, 'db'),
                "Presenter :: api/cdvr/legacy/recorders/sites :: True when #ARRIS: MTPR is in the region list");
        }

        public function test_validRegion_cisco_dnvr()
        {
            $presenter = Presenter::forge('api/cdvr/legacy/recorders/sites', 'view', null, 'api/response');
            $this->assertContains('#CISCO: DNVR', array_column($presenter->listOfRegions, 'db'),
                "Presenter :: api/cdvr/legacy/recorders/sites :: True when #CISCO: DNVR is in the region list");
        }

        public function test_validRegion_cisco_pla_fe()
        {
            $presenter = Presenter::forge('api/cdvr/legacy/recorders/sites', 'view', null, 'api/response');
            $this->assertContains('#CISCO: PLA FE', array_column($presenter->listOfRegions, 'db'),
                "Presenter :: api/cdvr/legacy/recorders/sites :: True when #CISCO: PLA FE is in the region list");
        }

        public function test_validRegion_cisco_ncs_fw()
        {
            $presenter = Presenter::forge('api/cdvr/legacy/recorders/sites', 'view', null, 'api/response');
            $this->assertContains('#CISCO: NCS FW', array_column($presenter->listOfRegions, 'db'),
                "Presenter :: api/cdvr/legacy/recorders/sites :: True when #CISCO: NCS FW is in the region list");
        }

        public function test_validRegion_arris_fox()
        {
            $presenter = Presenter::forge('api/cdvr/legacy/recorders/sites', 'view', null, 'api/response');
            $this->assertContains('#ARRIS: FOX', array_column($presenter->listOfRegions, 'db'),
                "Presenter :: api/cdvr/legacy/recorders/sites :: True when #ARRIS: FOX is in the region list");
        }

        public function test_validRegion_cisco_katy()
        {
            $presenter = Presenter::forge('api/cdvr/legacy/recorders/sites', 'view', null, 'api/response');
            $this->assertContains('#CISCO: KATY', array_column($presenter->listOfRegions, 'db'),
                "Presenter :: api/cdvr/legacy/recorders/sites :: True when #CISCO: KATY is in the region list");
        }

        public function test_validRegion_arris_jack()
        {
            $presenter = Presenter::forge('api/cdvr/legacy/recorders/sites', 'view', null, 'api/response');
           $this->assertContains('#ARRIS: JACK', array_column($presenter->listOfRegions, 'db'),
                "Presenter :: api/cdvr/legacy/recorders/sites :: True when #ARRIS: JACK is in the region list");
        }

        public function test_validRegion_arris_corl()
        {
            $presenter = Presenter::forge('api/cdvr/legacy/recorders/sites', 'view', null, 'api/response');
            $this->assertContains('#ARRIS: CORL', array_column($presenter->listOfRegions, 'db'),
                "Presenter :: api/cdvr/legacy/recorders/sites :: True when #ARRIS: CORL is in the region list");
        }

        public function test_validRegion_arris_mphs()
        {
            $presenter = Presenter::forge('api/cdvr/legacy/recorders/sites', 'view', null, 'api/response');
            $this->assertContains('#ARRIS: MPHS', array_column($presenter->listOfRegions, 'db'),
                "Presenter :: api/cdvr/legacy/recorders/sites :: True when #ARRIS: MPHS is in the region list");
        }

        public function test_validRegion_arris_mimi()
        {
            $presenter = Presenter::forge('api/cdvr/legacy/recorders/sites', 'view', null, 'api/response');
            $this->assertContains('#ARRIS: MIMI', array_column($presenter->listOfRegions, 'db'),
                "Presenter :: api/cdvr/legacy/recorders/sites :: True when #ARRIS: MIMI is in the region list");
        }

        public function test_validRegion_arris_nash()
        {
            $presenter = Presenter::forge('api/cdvr/legacy/recorders/sites', 'view', null, 'api/response');
            $this->assertContains('#ARRIS: NASH', array_column($presenter->listOfRegions, 'db'),
                "Presenter :: api/cdvr/legacy/recorders/sites :: True when #ARRIS: NASH is in the region list");
        }

        public function test_validRegion_arris_nape()
        {
            $presenter = Presenter::forge('api/cdvr/legacy/recorders/sites', 'view', null, 'api/response');
            $this->assertContains('#ARRIS: NAPE', array_column($presenter->listOfRegions, 'db'),
                "Presenter :: api/cdvr/legacy/recorders/sites :: True when #ARRIS: NAPE is in the region list");
        }

        public function test_validRegion_arris_port()
        {
            $presenter = Presenter::forge('api/cdvr/legacy/recorders/sites', 'view', null, 'api/response');
            $this->assertContains('#ARRIS: PORT', array_column($presenter->listOfRegions, 'db'),
                "Presenter :: api/cdvr/legacy/recorders/sites :: True when ##ARRIS: PORT is in the region list");
        }

        public function test_validRegion_cisco_stlk()
        {
            $presenter = Presenter::forge('api/cdvr/legacy/recorders/sites', 'view', null, 'api/response');
            $this->assertContains('#CISCO: STLK', array_column($presenter->listOfRegions, 'db'),
                "Presenter :: api/cdvr/legacy/recorders/sites :: True when #CISCO: STLK is in the region list");
        }

        public function test_validRegion_arris_seat()
        {
            $presenter = Presenter::forge('api/cdvr/legacy/recorders/sites', 'view', null, 'api/response');
            $this->assertContains('#ARRIS: SEAT', array_column($presenter->listOfRegions, 'db'),
                "Presenter :: api/cdvr/legacy/recorders/sites :: True when #ARRIS: SEAT is in the region list");
        }

        public function test_validRegion_arris_tall()
        {
            $presenter = Presenter::forge('api/cdvr/legacy/recorders/sites', 'view', null, 'api/response');
            $this->assertContains('#ARRIS: TALL', array_column($presenter->listOfRegions, 'db'),
                "Presenter :: api/cdvr/legacy/recorders/sites :: True when #ARRIS: TALL is in the region list");
        }

        public function test_validRegion_arris_wner()
        {
            $presenter = Presenter::forge('api/cdvr/legacy/recorders/sites', 'view', null, 'api/response');
            $this->assertContains('#ARRIS: WNER', array_column($presenter->listOfRegions, 'db'),
                "Presenter :: api/cdvr/legacy/recorders/sites :: True when #ARRIS: WNER is in the region list");
        }
  }

?>
