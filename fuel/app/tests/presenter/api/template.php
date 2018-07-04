<?php

    /**
     * @group App
     * @group aar
     * @group Presenters
     */

    class Test_API_Template extends TestCase
    {

        //add Rio sites
        public $listOfRegions = array(
            array('rio' => 'albq',               'text' => 'Albq'),
            array('rio' => 'detroit',         'text' => 'Detroit'),
            array('rio' => 'twincities',          'text' => 'TwinCities')
        );


        //test for search with key function
        public function test_searchWithKey()
        {
         //open presenter template to call function
           $presenter = Presenter::forge('api/template', 'view', null, 'api/response');
         //create table array to put in data, example:regionalist
           $table = array(
              array('site' => 'albq',  'date' => '2017-01-02', 'value' => '8'),
              array('site' => 'twincities',  'date' => '2017-01-03', 'value' => '18'),
              array('site' => 'detroit',  'date' => '2017-01-02', 'value' => '8')
            );

            $originalArray=$presenter->searchWithKey('site','twincities',$table);

            //expected results for twincities 2017-01-03
            $expectedArray=array(
              'site' => 'twincities',
              'date' => '2017-01-03',
              'value' => '18'
            );

            //user assertequals
           $this->assertEquals($expectedArray,$originalArray,
                "Validator :: searchWithKey :: True when query object returns twincities 2017-01-03 18");
        }



         //test for api/template  function of selectDataByDateAndRegion
        // public function test_selectDataByDateAndRegion()
        // {

        //   $presenter = Presenter::forge('api/template', 'view', null, 'api/response');
        //   //call listOfRegions function
        //   $presenter->listOfRegions=$this->listOfRegions;
        //   //call presente/api/rio/sites.php 2017-02-01 albq
        //   $originalString =$presenter->selectDataByDateAndRegion(
        //         $connection =  'ddn_stat',
        //         $table = 'cleversafe_sites_rio',
        //         $fieldDate = 'date',
        //         $date = '2017-02-01',
        //         $fieldRegion = 'site',
        //         $region = 'albq',
        //         $arrayFieldRegion = 'rio',
        //         $listOfRegionsProvided = $this->listOfRegions);
        //   //convert string to Json for comparison
        //    $originalJson=json_encode($originalString);

        //    //from browser, actual data
        //     $expectedJson='{"regions":[{"rio":"albq","text":"Albq"},{"rio":"detroit","text":"Detroit"},{"rio":"twincities","text":"TwinCities"}],"data":[{"site":"Albq","total_nodes":"113","totalok_nodes":"103","totalnotok_nodes":"10","total_usable_capacity":"8555.55","total_used_capacity":"5290.10","active_vault":"4637.71","archive_vault":"575.44","recon_vault":"0.05","average_usage_per_archive_server":"46.82","total_usage_per_cluster":"61.83","health_state":"OK","date":"2017-02-01","logical_active_totalspace":"8311.64","logical_active_usedspace":"886.43","logical_active_freespace":"7425.21","logical_archive_totalspace":"6715.88","logical_archive_usedspace":"215.16","logical_archive_freespace":"6500.71","logical_recon_totalspace":"6502.50","logical_recon_usedspace":"2.04","logical_recon_freespace":"6500.46"}]}';

        //  //assertEquals to compare two jason files check if function works or not
        //     $this->assertEquals($expectedJson,$originalJson,

        //         "Validator :: addAllRegions :: True when query object is converted to Albuquerque (C) or http://dev-ccm-php/api/cdvr/legacy/throughput/all/albq
        //             when parameter is albq");
        // }

        // public function test_selectDataByDateRangeAndRegion()
        // {

        //   $presenter = Presenter::forge('api/template', 'view', null, 'api/response');
        //   //call listOfRegions function
        //   $presenter->listOfRegions=$this->listOfRegions;
        //   //call presente/api/rio/sites.php 2017-02-01 albq
        //   $originalString =$presenter->selectDataByDateRangeAndRegion(
        //         $connection =  'ddn_stat',
        //         $table = 'cleversafe_sites_rio',
        //         $fieldDate = 'date',
        //         $dateStart = '2017-02-01',
        //         $dateEnd = null,
        //         $fieldRegion = 'site',
        //         $region = 'albq',
        //         $arrayFieldRegion = 'rio',
        //         $listOfRegionsProvided = $this->listOfRegions);
        //   //convert string to Json for comparison
        //    $originalJson=json_encode($originalString);
        //    // echo $originalJson;

        //    //from browser, actual data
        //     $expectedJson='{"regions":[{"rio":"albq","text":"Albq"},{"rio":"detroit","text":"Detroit"},{"rio":"twincities","text":"TwinCities"}],"data":[{"site":"Albq","total_nodes":"113","totalok_nodes":"103","totalnotok_nodes":"10","total_usable_capacity":"8555.55","total_used_capacity":"5290.10","active_vault":"4637.71","archive_vault":"575.44","recon_vault":"0.05","average_usage_per_archive_server":"46.82","total_usage_per_cluster":"61.83","health_state":"OK","date":"2017-02-01","logical_active_totalspace":"8311.64","logical_active_usedspace":"886.43","logical_active_freespace":"7425.21","logical_archive_totalspace":"6715.88","logical_archive_usedspace":"215.16","logical_archive_freespace":"6500.71","logical_recon_totalspace":"6502.50","logical_recon_usedspace":"2.04","logical_recon_freespace":"6500.46"}]}';

        //  //assertEquals to compare two jason files check if function works or not
        //     $this->assertEquals($expectedJson,$originalJson,

        //         "Validator :: addAllRegions :: True when query object is converted to Albuquerque (C) or http://dev-ccm-php/api/cdvr/legacy/throughput/all/albq
        //             when parameter is albq");
        // }
    }
?>