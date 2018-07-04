<?php
/**
 *
 * @package app
 */

class Metric_ComcastDDNStat extends Metric_Base
{

    /**
     * Returns the used database type
     *
     * @access protected
     * @return String 'mysql'
     */
    protected function getDatabaseType()
    {
        return 'mysql';
    }

    /**
     * Returns the used database connection
     * @access protected
     * @return String 'dashr'
     */

    protected function getConnection()
    {
        return 'ddn_stat';
    }


    public function getworstfivecapacity($dateStart, $dateEnd)
    {

         $listOfRegions = $this->getRioRegionList();


        // Query logic starts here
        $this->date = $this->provideDateFilter('cleversafe_sites_rio', 'date');
        $select     = DB::select('*')->from('cleversafe_sites_rio');
        $select = $this->date->selectByDateRange($dateStart, $dateEnd);
        $responseRio =$this->runQuery($select);


        // Assemble the results
        $responseWrap = array(
                   'regions' => $this->getRioRegionList(),
                   'data' => $responseRio
                  );


        // Iterate over the Rio regions list
        foreach($responseWrap['regions'] as $index => $regionResponse)
        {
            // Get capacity information for each individual region
            $regionRio = $this->searchWithKey('site', $regionResponse['capacity'], $responseWrap['data']);

            if (!is_null($regionRio))
            {

                // Score regions based on TOTAL utilization
                $utilRio  = $regionRio['total_used_capacity'];
                $availRio = $regionRio['total_usable_capacity'];
                $ratioRio = ($availRio > 0 ? $this->stringDivision($utilRio, $availRio) : 0);

                // Calculate using rule set
                // 1 = green / good; CS and DDN < 50% utilized
                // 2 = yellow / warning; CS or DDN >= 50%
                // 3 = red / bad; CS or DDN >= 80%
                // 4 = red / v.bad; CS and DDN >= 75%

                $health = 1; // Default is good until proven otherwise

                // Increment to yellow (2) if over 50%
                if ($ratioRio > 0.5) $health++;

                // Increment to red (3) if over 80%
                if ($ratioRio > 0.8) $health++;

                // Add the max ratio for full sorting (1.xyz, 2.abc, 3.def, 4.jkl)
                $health += $ratioRio;

                // Add to the response array
                $healthTemp[] = array(
                                             'health' => $health,
                                             'region' => $regionResponse['capacity'],
                                            );


                // Score regions based on ARCHIVE utilization (same logic as above)
                $utilRioArchive  = $regionRio['logical_archive_usedspace'];
                $availRioArchive = $regionRio['logical_archive_totalspace'];
                $ratioRioArchive = ($availRioArchive > 0 ? $this->stringDivision($utilRioArchive, $availRioArchive) : 0);


                $health = 1; // Re-initialize health score, Default is good until proven otherwise
                if ($ratioRioArchive > 0.5) $health++;
                if ($ratioRioArchive > 0.8) $health++;
                $health += $ratioRioArchive;

                $healthTempArchive[] = array(
                                             'health' => $health,
                                             'region' => $regionResponse['capacity'],
                                            );

                // Score regions based on ACTIVE utilization (same logic as above)
                $utilRioActive  = $regionRio['logical_active_usedspace'];
                $availRioActive = $regionRio['logical_active_totalspace'];
                $ratioRioActive = ($availRioActive > 0 ? $this->stringDivision($utilRioActive, $availRioActive) : 0);


                $health = 1; // Re-initialize health score, Default is good until proven otherwise
                if ($ratioRioActive > 0.5) $health++;
                if ($ratioRioActive > 0.8) $health++;
                $health += $ratioRioActive;

                $healthTempActive[] = array(
                                             'health' => $health,
                                             'region' => $regionResponse['capacity'],
                                            );

            }
        }


        // FOR TOTAL UTILIZATION: Sort the $healthTemp array by the 'health' field value so we can then extract the worst five markets
        $sortedHealthArray = $this->sortBySubValue($healthTemp, 'health', false);
        $worstFiveMarketsByHealthArray = array_slice($sortedHealthArray, 0, 5);

        $worstFiveMarketsNames = array();
        foreach ($worstFiveMarketsByHealthArray as $key => $value) {
            $worstFiveMarketsNames[] = $value['region'];
        }


        // FOR ARCHIVE: Sort the $healthTempArchive array by the 'health' field value so we can then extract the worst five markets
        $sortedHealthArrayArchive = $this->sortBySubValue($healthTempArchive, 'health', false);
        $worstFiveMarketsByHealthArrayArchive = array_slice($sortedHealthArrayArchive, 0, 5);

        $worstFiveMarketsNamesArchive = array();
        foreach ($worstFiveMarketsByHealthArrayArchive as $key => $value) {
            $worstFiveMarketsNamesArchive[] = $value['region'];
        }


        // FOR ACTIVE: Sort the $healthTempActive array by the 'health' field value so we can then extract the worst five markets
        $sortedHealthArrayActive = $this->sortBySubValue($healthTempActive, 'health', false);
        $worstFiveMarketsByHealthArrayActive = array_slice($sortedHealthArrayActive, 0, 5);

        $worstFiveMarketsNamesActive = array();
        foreach ($worstFiveMarketsByHealthArrayActive as $key => $value) {
            $worstFiveMarketsNamesActive[] = $value['region'];
        }



        // Calculate additional fields, add to new array
        $dataArrayWithNewCalculations = array();
        foreach($responseWrap['data'] as $index => $regionResponse)
        {
            $totalUtilization    = $regionResponse['total_used_capacity'];
            $active_vault_ratio  = $regionResponse['logical_active_usedspace']  / $regionResponse['logical_active_totalspace'];
            $archive_vault_ratio = $regionResponse['logical_archive_usedspace']  / $regionResponse['logical_archive_totalspace'];
            $recon_vault_ratio   = $regionResponse['logical_recon_usedspace']  / $regionResponse['logical_active_totalspace'];
            $regionResponse['total_utilization']   = $totalUtilization;
            $regionResponse['total_utilization_ratio'] = $totalUtilization / $regionResponse['total_usable_capacity'];
            $regionResponse['active_vault_ratio']  = $active_vault_ratio;
            $regionResponse['archive_vault_ratio'] = $archive_vault_ratio;
            $regionResponse['recon_vault_ratio']   = $recon_vault_ratio;

            // save object into new array
            $dataArrayWithNewCalculations[] = $regionResponse;
        }


        // The order which markets appear in the regions response is the order which the regions will be presented in our COV table.
        // We want them ordered from highest total_utilization_ratio to lowest - Find the total_utilization_ratio from dataArrayWithNewCalculations
        // and place it in the correct object in the regionsList array (match using the 'site' key in dataArrayWithNewCalculations and the 'capacity' key in regionsList.
        $regionsList = $responseWrap['regions'];


        // Initialize containers for each vault:
        // TOTAL UTILIZATION
        $resultArrayRegions = array();
        // ARCHIVE UTILIZATION
        $resultArrayRegionsArchive = array();
        // ACTIVE UTILIZATION
        $resultArrayRegionsActive = array();

        foreach ($regionsList as $index => $regionsListObject)
        {
            $dataArrayWithNewCalculationsObject = $this->findSubArrayByValue(
                $searchArray = $dataArrayWithNewCalculations,
                $searchSubKey = 'site',
                $searchValue = $regionsListObject['capacity']
            );

            $temp_TotalUtilRatio = $dataArrayWithNewCalculationsObject['total_utilization_ratio'];
            $regionsListObject['total_utilization_ratio'] = $temp_TotalUtilRatio;
            $resultArrayRegions[] = $regionsListObject;

            $temp_ArchiveUtilRatio = $dataArrayWithNewCalculationsObject['archive_vault_ratio'];
            $regionsListObject['archive_vault_ratio'] = $temp_ArchiveUtilRatio;
            $resultArrayRegionsArchive[] = $regionsListObject;

            $temp_ActiveUtilRatio = $dataArrayWithNewCalculationsObject['active_vault_ratio'];
            $regionsListObject['active_vault_ratio'] = $temp_ActiveUtilRatio;
            $resultArrayRegionsActive[] = $regionsListObject;
        }

        // Sort the subarrays in $resultArrayRegions by their total_utilization_ratio.
        $resultArrayRegions = $this->sortBySubValue($resultArrayRegions, 'total_utilization_ratio', false);

        // Sort the subarrays in $resultArrayRegionsArchive by their archive_vault_ratio.
        $resultArrayRegionsArchive = $this->sortBySubValue($resultArrayRegionsArchive, 'archive_vault_ratio', false);

        // Sort the subarrays in $resultArrayRegionsArchive by their active_vault_ratio.
        $resultArrayRegionsActive = $this->sortBySubValue($resultArrayRegionsActive, 'active_vault_ratio', false);

        // Assemble the results
        $responseWrap = array(
                   'regions' => $resultArrayRegions,
                   'regionsArchive' => $resultArrayRegionsArchive,
                   'regionsActive' => $resultArrayRegionsActive,
                   'data' => $dataArrayWithNewCalculations,
                   'health' => $healthTemp,
                   'worstFiveMktsByHealthNames' => $worstFiveMarketsNames,
                   'worstFiveMktsByHealthNamesArchive' => $worstFiveMarketsNamesArchive,
                   'worstFiveMktsByHealthNamesActive' => $worstFiveMarketsNamesActive,
                  );

        return $responseWrap;

    }




    /**

     * Returns $limit worst streams in regions for the supplied date by success_rate, failed count
     *
     * @access public
     * @param  String $date  Y-m-d formatted date, day of interests

     * @param  String component
     * @param  String region
     * @return Array  Array of data
     */
    public function cstrend($dateStart, $dateEnd, $region)
    {

        $this->date = $this->provideDateFilter('comcast_ddnstat.cleversafe_sites', 'date');
       $expr       = DB::expr('total_used_capacity/total_usable_capacity AS cs' );
        $select = DB::select('*', $expr )->from('comcast_ddnstat.cleversafe_sites');
        $select = $this->date->filterByDateRange($select, $dateStart, $dateEnd);
        $select->where('site', 'like', $region);
        $select->order_by('date', 'ASC');
        $dataRaw  = $this->runQuery($select);
        $response = $this->createArrayBucketsByTwoField($dataRaw,'site','date');

        return $response;
    }


           /**
     * @param  Int    $limit Number of worst streams for
     * @return Array  Array of streams
     */

    public function getDdnRegionStartEndRange($region, $dateStart, $dateEnd)
    {

        // . Query logic starts here, *,
        $this->date = $this->provideDateFilter('ddn_sites', 'date');
        $expr       = DB::expr('total_used_capacity/total_usable_capacity total_used_capacity_ratio');
        $select     = DB::select('*',$expr)->from('ddn_sites');
        $select     = $this->date->filterByDateRange($select,$dateStart,$dateEnd );
        $select->where('site','like',$region);
        $select->order_by('date', 'ASC');
        $select->order_by('total_used_capacity_ratio', 'DESC');
        $responseDDN =$this->runQuery($select);

        //assembly the results
        $this->response = array(
                   'regions' => $this->getCdvrRegionList(),
                   'data'    => $responseDDN,
                  );

        return $this->response;

    }


   /**

     * Returns $limit worst streams in regions for the supplied date by success_rate, failed count
     *
     * @access public
     * @param  String $date  Y-m-d formatted date, day of interests
     * @param  String component
     * @param  String region
     * @return Array  Array of data
     */
    public function ddntrend($dateStart, $dateEnd, $region)
    {

        $this->date = $this->provideDateFilter('comcast_ddnstat.ddn_sites', 'date');
        $expr   = DB::expr('total_used_capacity/total_usable_capacity AS ddn' );
        $select = DB::select('*', $expr )->from('comcast_ddnstat.ddn_sites');
        $select = $this->date->filterByDateRange($select, $dateStart, $dateEnd);
        $select->where('site', 'like', $region);
        $select->order_by('date', 'ASC');
        $dataRaw  = $this->runQuery($select);
        $response = $this->createArrayBucketsByTwoField($dataRaw,'site','date');

        return $response;
    }

    /**
     * @param  Int    $limit Number of worst streams for
     * @return Array  Array of streams
     */

    public function getMinMaxDDN($region, $dateStart, $dateEnd)
    {

        // Query logic starts here, *,
        $this->date = $this->provideDateFilter('ddn_sites', 'date');
        $expr       = DB::expr('total_used_capacity/total_usable_capacity total_used_capacity_ratio');
        $select     = DB::select('*',$expr)->from('ddn_sites');
        $select     = $this->date->filterByDateRange($select,$dateStart,$dateEnd );
        $select->where('site','like',$region);
        $select->order_by('date', 'ASC');
        $responseDDN = $this->runQuery($select);

        $regions = $this->getCdvrRegionList();

        // Bucket data by date
        $responseDataByDate = $this->createArrayBucketsByField($responseDDN, 'date');

        // keep these are respons variables so we can check which two dates are being compared
        $arrayOne = $responseDataByDate[$dateStart];
        $arrayTwo = $responseDataByDate[$dateEnd];

        // below, the foreach loops finds the percent change from arrayOne to arrayTwo in the 'total_usage_per_cluster' field for each market and returns
        // an array identical to arrayOne but with a new field - 'percentDifference'.
        $resultArray = array();
        foreach ($arrayOne as $index => $arrayOneObject)
        {
            $arrayTwoObject = $this->findSubArrayByValue(
                $searchArray = $arrayTwo,
                $searchSubKey = 'site',
                $searchValue = $arrayOneObject['site']
            );

            // $pd = percent difference array
            $pd = (($arrayTwoObject['total_usage_per_cluster'] - $arrayOneObject['total_usage_per_cluster']) / $arrayOneObject['total_usage_per_cluster']) * 100;

            $arrayOneObject['percentDifference'] = $pd;

            $resultArray[] = $arrayOneObject;
        }

        // sort the resultArray's subarray by the 'percentDifference' field value
        $sortedResultsArray = $this->sortBySubValue($resultArray, 'percentDifference', false);

        // create a new response array with 10 elements - the first five being the elements with the lowest percentDifference and the last five with the
        // highest percentDifference.
        $response = array_merge(array_slice($sortedResultsArray, 0, 5),array_slice($sortedResultsArray, -5));

        // map the raw site name text to more user friendly/readable text using the $listOfRegionsLegacy array.
        foreach ($response as $key => $value) {
            $region = $this->findSubArrayByValue($regions, 'ddn', $value['site']);
            $response[$key]['labelText'] = $region['text'];
        }

        // Write the response data for consumption by the client
        $response = array(
            'regions' => $this->getCdvrRegionList(),
            'MinMaxDDNArchive' => $response,
        );

        return $response;

    }


    public function getCleversafeRegionStartEndRange($region, $dateStart, $dateEnd)
    {

        // . Query logic starts here, *,
        $this->date = $this->provideDateFilter('cleversafe_sites', 'date');
        $expr       = DB::expr('total_used_capacity/total_usable_capacity total_used_capacity_ratio');
        $select     = DB::select('*',$expr)->from('cleversafe_sites');
        $select     = $this->date->filterByDateRange($select,$dateStart,$dateEnd );
        $select->where('site','like',$region);
        $select->order_by('date', 'ASC');
        $select->order_by('total_used_capacity_ratio', 'DESC');
        $responseCS =$this->runQuery($select);

        //assembly the results
        $response = array(
                   'regions' => $this->getCdvrRegionList(),
                   'data'    => $responseCS,
                  );

        return $response;

    }


    public function getMinMaxCS($region, $dateStart, $dateEnd)
    {

        // . Query logic starts here, *,
        $this->date = $this->provideDateFilter('cleversafe_sites', 'date');
        $expr       = DB::expr('total_used_capacity/total_usable_capacity total_used_capacity_ratio');
        $select     = DB::select('*',$expr)->from('cleversafe_sites');
        $select     = $this->date->filterByDateRange($select,$dateStart,$dateEnd );
        $select->where('site','like',$region);
        $select->order_by('date', 'ASC');
        $select->order_by('total_used_capacity_ratio', 'DESC');
        $responseCS =$this->runQuery($select);

        $regions = $this->getCdvrRegionList();

        // Bucket data by date
        $responseDataByDate = $this->createArrayBucketsByField($responseCS, 'date');

        // keep these are respons variables so we can check which two dates are being compared
        $arrayOne = $responseDataByDate[$dateStart];
        $arrayTwo = $responseDataByDate[$dateEnd];

        // below, the foreach loops finds the percent change from arrayOne to arrayTwo in the 'total_usage_per_cluster' field for each market and returns
        // an array identical to arrayOne but with a new field - 'percentDifference'.
        $resultArray = array();
        foreach ($arrayOne as $index => $arrayOneObject)
        {
            $arrayTwoObject = $this->findSubArrayByValue(
                $searchArray = $arrayTwo,
                $searchSubKey = 'site',
                $searchValue = $arrayOneObject['site']
            );

            // $pd = percent difference array
            $pd = (($arrayTwoObject['total_usage_per_cluster'] - $arrayOneObject['total_usage_per_cluster']) / $arrayOneObject['total_usage_per_cluster']) * 100;

            $arrayOneObject['percentDifference'] = $pd;

            $resultArray[] = $arrayOneObject;
        }

        // sort the resultArray's subarray by the 'percentDifference' field value
        $sortedResultsArray = $this->sortBySubValue($resultArray, 'percentDifference', false);

        // create a new response array with 10 elements - the first five being the elements with the lowest percentDifference and the last five with the
        // highest percentDifference.
        $response = array_merge(array_slice($sortedResultsArray, 0, 5),array_slice($sortedResultsArray, -5));

        // map the raw site name text to more user friendly/readable text using the $listOfRegionsLegacy array.
        foreach ($response as $key => $value) {
            $region = $this->findSubArrayByValue($regions, 'cs', $value['site']);
            $response[$key]['labelText'] = $region['text'];
        }

        // Write the response data for consumption by the client
        $response = array(
            'regions' => $this->getCdvrRegionList(),
            'MinMaxCSArchive' => $response,
        );

        return $response;

    }



    /**
     * Returns health (cleversafe) data for rio sites
     *
     * @access public
     * @param  String $date  Y-m-d formatted date, day of interests
     * @param  string $region
     * @return Array  Array of streams
     */
    public function health($date, $region)
    {

         $listOfRegions = $this->getRioRegionList();

        // Perform a calculation and save it into the response (save as a new element in each sub-array of the response object)
        $this->date = $this->provideDateFilter('cleversafe_sites_rio', 'date');
        $select = DB::select('*')->from('cleversafe_sites_rio');
        $select = $this->date->filterByDate($select, $date);
        $select->where('site','like',$region);

        $data = $this->runQuery($select);


        // Iterate over region list from CS, using normalized region names
        foreach($listOfRegions as $index => $regionResponse)
        {
            // Get the utilization value for CS
            $regionRio = $this->searchWithKey('site', $regionResponse['rio'], $data);

            if (!is_null($regionRio))
            {
                $utilRio  = $regionRio['total_used_capacity'];
                $availRio = $regionRio['total_usable_capacity'];
                $ratioRio = ($availRio > 0 ? $this->stringDivision($utilRio, $availRio) : 0);

                // Calculate using rule set
                // 1 = green / good; CS and DDN < 50% utilized
                // 2 = yellow / warning; CS or DDN >= 50%
                // 3 = red / bad; CS or DDN >= 80%
                // 4 = red / v.bad; CS and DDN >= 75%
                // Default is good until proven otherwise
                $health = 1;

                // Increment to yellow (2) if over 50%
                if ($ratioRio > 0.5) $health++;

                // Increment to red (3) if over 80%
                if ($ratioRio > 0.8) $health++;

                // Add the max ratio for full sorting (1.xyz, 2.abc, 3.def, 4.jkl)
                $health += $ratioRio;

                // Add to the response array
                $response[] = array(
                                             'region' => $regionResponse['rio'],
                                             'health' => $health,
                                            );
            }//end if
        }//end foreach

        return $response;

    }


    /**
     * Returns sites data for rio sites
     *
     * @access public
     * @param  String $date  Y-m-d formatted date, day of interests
     * @param  string $region
     * @return Array  Array of streams
     */
    public function getsites($date, $region)
    {

         $listOfRegions = $this->getRioRegionList();

        // Perform a calculation and save it into the response (save as a new element in each sub-array of the response object)
        $this->date = $this->provideDateFilter('cleversafe_sites_rio', 'date');
        $select = DB::select('*')->from('cleversafe_sites_rio');
        $select = $this->date->filterByDate($select, $date);
        $select->where('site','like',$region);

        $data = $this->runQuery($select);


        // Write the response data for consumption by the client
        $this->response = $data;

            // Check whether the data object is the correct structure
            if ($this->response !== array())
            {
                // The data array exists and is not empty, so let's operate on each of the result elements
                foreach ($this->response as $index => $result)
                {
                    // Calculate the percent capacity used for each site/region
                    $result['total_used_capacity_ratio'] = $this->stringDivision($result['total_used_capacity'], $result['total_usable_capacity']);

                    // Save the modified entry to the result set
                    $this->response[$index] = $result;
                }
            }
            else
            {
                // Ensure predictable default behavior for the client
                $this->response['data'] = array();
            }

        return $this->response;

    }



}


