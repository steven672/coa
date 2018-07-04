<?php

    /**
     * @group App
     * @group template
     * @group Presenters
     */

    class Test_API_cDVR_Template extends TestCase
    {

        //add Rio sites
        public $listOfRegions = array(
            array('rio' => 'albq',               'text' => 'Albq'),
            array('rio' => 'detroit',         'text' => 'Detroit'),
            array('rio' => 'twincities',          'text' => 'TwinCities')
        );

        // TODO: Create tests for addAllRegions

        // create an assertEquals statement like the following:
        // assertEquals(mixed $expected, mixed $actual[, string $message = ''])

        // //         Test a valid region name to ensure the region list is built correctly
        // public function test_last_query()
        // {
        //     // $originalString = addAllRegions($query = null, $fieldRegion = albq, $arrayFieldRegion = listOfRegions);
        //     // $expectedString = //the output (query object) of the above function
        //     $presenter = Presenter::forge('api/cdvr/template', 'view', null, 'api/response');
        //     $this->assertEquals("SELECT * FROM `cleversafe_sites_rio` WHERE UNIX_TIMESTAMP(CAST(date as DATE)) >= 1468555200 AND UNIX_TIMESTAMP(CAST(date as DATE)) <= 1484542800 AND `site` LIKE 'albq' ORDER BY `date` ASC, `site` ASC",last_query($connection),
        //         "Presenter :: addAllRegions :: True when last_query object is SELECT * FROM `cleversafe_sites_rio` WHERE UNIX_TIMESTAMP(CAST(date as DATE)) >= 1468555200 AND UNIX_TIMESTAMP(CAST(date as DATE)) <= 1484542800 AND `site` LIKE 'albq' ORDER BY `date` ASC, `site` ASC");
        // }

        public function test_addAllRegions()
        {
                $validator = new Model_Validator();
                $connection =  'recorder_stat';
                $table = 'recorder_list';
                $presenter = Presenter::forge('api/cdvr/legacy/health', 'view', null, 'api/response');
                // $presenterOne = Presenter::forge('api/cdvr/template', 'view', null, 'api/response');
                $query = DB::select()->from($table);
                $validator->listOfRegions = $this->listOfRegions;
                // $presenterOne->addAllRegions = $this->addAllRegions;
                $query = $presenter->addAllRegions(
                        $query = null,
                        $fieldRegion = 'site', //query is being set to null because addAllRegions is returning null
                        $arrayFieldRegion = 'rio');

                $expectedQueryString = "SELECT * FROM `cleversafe_sites_rio` WHERE UNIX_TIMESTAMP(CAST(date as DATE)) >= 1468555200 AND UNIX_TIMESTAMP(CAST(date as DATE)) <= 1484542800 AND `site` LIKE 'albq' ORDER BY `date` ASC, `site` ASC";
                $actualQueryString = DB::last_query($connection);

                // print_r(last_query($connection));

                $this->assertEquals($actualQueryString, $expectedQueryString, "Presenter :: addAllRegions :: True when last_query object is SELECT * FROM `cleversafe_sites_rio` WHERE UNIX_TIMESTAMP(CAST(date as DATE)) >= 1468555200 AND UNIX_TIMESTAMP(CAST(date as DATE)) <= 1484542800 AND `site` LIKE 'albq' ORDER BY `date` ASC, `site` ASC");
        }
    }
?>