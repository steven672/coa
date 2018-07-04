<?php

    /**
     * @group App
     * @group Presenters
     */

    class Test_RegionList extends TestCase
    {



// assertArraySubset()
// assertArraySubset(array $subset, array $array[, bool $strict = '', string $message = ''])

// assertArrayHasKey()
// assertArrayHasKey(mixed $key, array $array[, string $message = ''])

        // Test a valid region name to ensure the region list is built correctly
        public function testKeysOfArraySubsets()
        {
            $validator = new Model_Validator();
            $presenter = Presenter::forge('api/cdvr/rio/sites', 'view', null, 'api/response');
            $this->assertTrue($validator->validRegion('albq', $presenter->listOfRegions, 'db'),
                "Validator :: validRegion :: True when albq is in the region list");
        }
}

?>