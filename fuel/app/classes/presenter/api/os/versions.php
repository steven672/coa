<?php

/**
 * The API Rio presenter.
 *
 * @package app
 * @extends Presenter_API
 */

// The Presenter_API class includes Model\Validator already
// use \Model\Validator;
class Presenter_API_Os_Versions extends Presenter_API_cDVR_Template
{


    /**
     * Prepare the view data, keeping this in here helps clean up
     * the controller.
     *
     * @return void
     */
    public function view()
    {
        /*
            * Ingest the date and region variables
            * The URL formats for these variables are specified in the /app/config/routes.php file
            * For this API endpoint, both date and region are optional variables
            * Valid URL calls:
            *   /api/os/versions                             Data from yesterday in all regions
            *   /api/os/versions/vbn/2017-03-15/             Data from specific market and specific date
            *   /api/os/versions/all/2017-04-07/2017-04-10   Data from a date range in all regions
         */


        // TODO: Set up a regionslist in model/regionlist.php - there are over 100 markets in the table and we only want around 25.
        // $listOfRegions = (new Model_RegionList())->listAllVersionData();


        // Ingest normalized application parameters from the URL
        $dateStart = $this->ingestParameter('start');
        $dateEnd = $this->ingestParameter('end');
        $region = $this->ingestParameter('region');


        // Save yesterday's date to use if no startDate given. Response time of currently constructed query increases ~ 5 seconds per additional day in date range if region not given.
        //  TODO: Use todays date and draw yesterday's data only for servers whose data is not available from today's date.
        $today = date("Y-m-d");
        $dateYesterday = date('Y-m-d', strtotime($today .' -1 day'));

        // Optionally, extend maximum execution time (default is 30 seconds) or memory limit - could be useful if we write or test more complex queries in the future - db is 19M+ rows (with 700k being added per day)
        ini_set('max_execution_time', 300); //300 seconds = 5 minutes
        // ini_set('memory_limit','128M');


        // Declare db connection to postgreSQL db entry in config/production/db.php
        $dbConnection = 'postgresql_versiondata';

        // Query to run if no parameters are ingested (data for yesterday's date will be given)
        if ($dateStart == '%' && $dateEnd == '%' && $region == '%')
        {
            $queryBuilderObject = DB::query("SELECT DISTINCT ON (ipaddr, version, market, facility, os) ipaddr, version, market, facility, os, timestamp FROM public.device_history WHERE date_trunc('day', timestamp) = '$dateYesterday' LIMIT 2000;");

        }

        // Query to run if dateStart and region parameters are supplied
        if ($dateStart !== '%' && $dateEnd == '%' && $region !== '%')
        {
            $queryBuilderObject = DB::query("SELECT DISTINCT ON (ipaddr, version, market, facility, os) ipaddr, version, market, facility, os, timestamp FROM public.device_history WHERE date_trunc('day', timestamp) = '$dateStart' AND market = '$region' LIMIT 2000;");

        }

        // Query to run if dateStart and dateRange are supplied (and an 'all' given for region: /api/os/versions/all/2017-04-07/2017-04-10)
        if ($dateStart !== '%' && $dateEnd !== '%' && $region == '%')
        {
            $queryBuilderObject = DB::query("SELECT DISTINCT ON (ipaddr, version, market, facility, os) ipaddr, version, market, facility, os, timestamp FROM public.device_history WHERE date_trunc('day', timestamp) BETWEEN '$dateStart' AND '$dateEnd' LIMIT 2000;");
        }

            $this->response = array();
            $this->response['data'] = $this->queryRunUsingConnection($queryBuilderObject, $dbConnection);



        function array_column_multi(array $input, array $column_keys) {
            $result = array();
            $column_keys = array_flip($column_keys);
            foreach($input as $key => $el) {
                $result[$key] = array_intersect_key($el, $column_keys);
            }
            return $result;
        }

        $columnsNeeded = array("market", "version");

        $this->response['filteredData'] = array_column_multi($this->response['data'], $columnsNeeded);


        // $resultArray = array();
        //  foreach ($this->response['filteredData'] as $key => $value) {
        //     $strings = implode(" ", $value);
        //     $value['string'] = $strings;
        //     $resultArray[] = $value;
        //  }

        $resultArray = array();
        foreach ($this->response['filteredData'] as $key => $value) {
            // $value['strings'] = $strings;
            if (empty($resultArray[$value['market']])) {
                $resultArray[$value['market']] = array($value['version'] => 1);
            } else if (empty($resultArray[$value['market']][$value['version']])) {
                $resultArray[$value['market']][$value['version']] = 1;
            } else {
                $resultArray[$value['market']][$value['version']] = $resultArray[$value['market']][$value['version']] + 1;
            }
         }

        $this->response['marketVersions'] = $resultArray;


        $arrayOfMarketsAndVersions = array();

        foreach ($resultArray as $market => $value) {
            $marketArray = array('Market' => $market);
            foreach ($value as $version => $count) {
                $marketArray[$version] = $count;

            }
            $arrayOfMarketsAndVersions[] = $marketArray;
        }

        $this->response['marketVersionsUpdated'] = $arrayOfMarketsAndVersions;


// instead of doing this manually,
$arrayOfVersions = array('3.2.1_002-1.el6', '1.1.2_011-1', '1.1.2_014-1', '1.5.3', '4.0.3-1.el6', '2.6.16-1', '1.5.4-3', '1.5.4', '3.8.4', '0.9.0-1', '3.4.6.88403-1', '2.8.2cc.44247', '3.0.3cc.40549', '1.1.2_008-1', '0.3.0_018-1', '1.5.3-3', '8.4.3', '3.1.0_022-1', '2.1.0_004-1', '1.4.24', '0.3.0_019-1', '2.1.0_003-1', '3.6.2.127538-1', '3.7.2.135764-1', '0.8.6-4.el6_5.2', '1.0.15-11.el6', '1.2.13', '1.1.1_007-1', '1.0.4_002-1', '1.0.5_008-1', '1.4.7_002-1.el6',
 '3.0.3-1.el6', '3.0.7-2.el6.remi 0.0.9_001-1', '3.0.7-2', '6.03.00-097', '2.0.3_028-1', '2.0.3_045-1', '3.3-1', '3.2-1', '2.4.14-mongodb_1 1.1.2-1', '0.0.6-1', '2.6.16-1.el6', '2.3.9_005-1', '1.10.2', '3.8.0.134', '3.7.2.67', '3.0.4-1.el6', '4.02.06-116', '3.1.0_013-1', '3.5.6.109803-1');

    $arrayWithAddedVersionKeys = array();


    foreach($arrayOfVersions as $versionsNum){
        foreach ($arrayOfMarketsAndVersions as $marketIndex => $marketAndVersions) {
            if (!array_key_exists($versionsNum, $marketAndVersions))
            {
                $arrayOfMarketsAndVersions[$marketIndex][$versionsNum] = 0;
            }
            ksort($arrayOfMarketsAndVersions[$marketIndex]);
         }
     }




    $this->response['marketVersionsUpdated'] = $arrayOfMarketsAndVersions;

        // $this->response['byMarket'] = $this->createArrayBucketsByField($this->response['filteredData'], 'market');

        // $count = array();
        // foreach ($this->response['byMarket'] as $key => $value) {
        //     $version = $key[$value]['version'];
        //     $count[] = $version;
        //     // array_count_values($count);
        //     // $key['count'] = $count;
        // }



         // $this->response['filteredData1'] = array_count_values($this->response['filteredData']);



        // API currently works as expected but would be useful to create date column ('YYY-MM-DD') for each element using the timestamp column, but foreach below doesnt currently work. Keeping in code for later use. Same with createArrayBucketsByField code.
        // foreach ($this->response['data'] as $index => $value) {
        //     $dt = new DateTime($value['timestamp']);
        //     $this->response['data'][$index]['date'] = $dt->format('Y-m-d');
        // }

        // $this->response['byDate'] = $this->createArrayBucketsByField($this->response['data'], 'date');
        // $this->response['byMarket'] = $this->createArrayBucketsByField($this->response['data'], 'market');
    }
}


