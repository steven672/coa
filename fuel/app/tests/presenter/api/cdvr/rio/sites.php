<?php

    /**
     * @group App
     * @group Presenters
     */

    class Test_API_cDVR_Rio_Sites extends TestCase
    {
        // TODO: Create tests for the view function (refer to the tests below for the validRegion funcction for example syntax and edge cases)

        // Validation tests using the data from this presenter for validRegion (ensure correct data set); don't test general edge cases (covered in the validator's unit tests already), test only the list expected

        // Test a valid region name to ensure the region list is built correctly
        public function test_validRegion_albq()
        {
            $validator = new Model_Validator();
            $presenter = Presenter::forge('api/cdvr/rio/sites', 'view', null, 'api/response');
            $this->assertTrue($validator->validRegion('albq', $presenter->listOfRegions, 'db'),
                "Validator :: validRegion :: True when albq is in the region list");
        }

        // Test a valid region name to ensure the region list is built correctly
        public function test_validRegion_detroit()
        {
            $validator = new Model_Validator();
            $presenter = Presenter::forge('api/cdvr/rio/sites', 'view', null, 'api/response');
            $this->assertTrue($validator->validRegion('detroit', $presenter->listOfRegions, 'db'),
                "Validator :: validRegion :: True when detroit is in the region list");
        }

        // Test a valid region name to ensure the region list is built correctly
        public function test_validRegion_twincities()
        {
            $validator = new Model_Validator();
            $presenter = Presenter::forge('api/cdvr/rio/sites', 'view', null, 'api/response');
            $this->assertTrue($validator->validRegion('twincities', $presenter->listOfRegions, 'db'),
                "Validator :: validRegion :: True when twincities is in the region list");
        }
}

?>