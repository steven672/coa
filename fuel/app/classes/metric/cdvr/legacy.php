<?php

/**
 *
 * @package app
 */

class Metric_cDVR_Legacy extends Metric_Base
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


    //search through DB
    public function getDataBuildResponse(
            $responseCSTmp6month            = null,
            $responseDDNTmp6month           = null,
            $responseRecordersTmp6month     = null,
            $listOfRegions                  = null
        )
    {
        $trending['dataTrending'] = array();
        $factors = ['cs' => $responseCSTmp6month, 'ddn' => $responseDDNTmp6month,'recorders' => $responseRecordersTmp6month];

        foreach ($factors as $arrayFieldRegion => $responseFromDatabase) {

            // // Query the database using the dataSource info needed for this API
            // $responseFromDatabase = $responseTable;

            // Iterate over region list from dataSource, using normalized region names
            foreach($responseFromDatabase as $index => $data)
            {
                // Map this db region to the main regions plain text
                $region = $this->findSubArrayByValue( $listOfRegions, $arrayFieldRegion, $data['site']);
                $regionName = $region['text'];

                // Create the response->region data key if it doesn't exist
                if (!array_key_exists($regionName, $trending['dataTrending']))
                {
                    $trending['dataTrending'][$regionName] = array();
                }

                // Create the response->region->date key if it doesn't exist
                if (!array_key_exists($data['date'], $trending['dataTrending'][$regionName]))
                {
                    $trending['dataTrending'][$regionName][$data['date']] = array();
                }

                // Put the day's utilization ratio into the response->region->date->dataSource value
                if($arrayFieldRegion === 'cs' || $arrayFieldRegion === 'ddn' )
                {
                    $trending['regions'] =  $listOfRegions;
                    $trending['dataTrending'][$regionName][$data['date']][$arrayFieldRegion] = $this->stringDivision($data['total_used_capacity'], $data['total_usable_capacity']);
                }
                else
                {
                    $trending['dataTrending'][$regionName][$data['date']][$arrayFieldRegion] = $this->stringDivision($data['sum_total_percent'], 100);
                }
            }

        }

        return $trending['dataTrending'];
    }

    public function getMinMax($region, $dateStart, $dateEnd)
    {

        //  Query logic starts here, *,
        $this->date = $this->provideDateFilter('comcast_recorder_stat.recorder_list', 'date');
        $select     = DB::select('*')->from('comcast_recorder_stat.recorder_list');
        $select     = $this->date->filterByDateRange($select,$dateStart,$dateEnd);
        $select->where('site','like',$region);
        $select->order_by('date', 'ASC');
        $responseLegacy =$this->runQuery($select);
        $regions = $this->getCdvrRegionList();

        // Start of data preparation for the worst/best 5 bar chart which represents values from the legacy CS archives column in Capacity -> cDVR
        // Build response array, bucketize by date
        $responseDataByDate = $this->createArrayBucketsByField($responseLegacy, 'date');

        // keep these are respons variables so we can check which two dates are being compared
        if (!isset($responseDataByDate[$dateStart]) || !isset($responseDataByDate[$dateEnd]))
        {
            return array(
                'regions' => $this->getCdvrRegionList(),
                'MinMaxLegacyRecorders' => array(),
            );
        }
        $arrayOne = $responseDataByDate[$dateStart];
        $arrayTwo = $responseDataByDate[$dateEnd];

        // below, the foreach loops finds the percent change from arrayOne to arrayTwo in the 'total_usage_per_cluster' field for each market and returns
        // an array identical to arrayOne but with a new field - 'percentDifference'. Please note this function assumes the markets appear in the same order
        // in each array.
        $resultArray = array();
        foreach ($arrayOne as $index => $arrayOneObject)
        {
            $arrayTwoObject = $this->findSubArrayByValue(
                $searchArray = $arrayTwo,
                $searchSubKey = 'site',
                $searchValue = $arrayOneObject['site']
            );

            // $pd = percent difference array
            $pd = (($arrayTwoObject['sum_total_percent'] - $arrayOneObject['sum_total_percent']) / $arrayOneObject['sum_total_percent']) * 100;

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
            $region = $this->findSubArrayByValue($regions, 'recorders', $value['site']);
            $response[$key]['labelText'] = $region['text'];
        }

        // Write the response data for consumption by the client
        $response = array(
             'regions' => $this->getCdvrRegionList(),
             'MinMaxLegacyRecorders' => $response,
        );

        return $response;

    }


    public function getPriority($region, $date, $dateEnd )
    {

         $listOfRegions = $this->getCdvrRegionList();

        // Query logic starts here, cs,
        $this->date = $this->provideDateFilter('cleversafe_sites', 'date');
        $expr       = DB::expr('total_used_capacity/total_usable_capacity total_used_capacity_ratio');
        $select     = DB::select('*',$expr)->from('cleversafe_sites');
        $select     = $this->date->filterByDate($select,$date );
        $select->where('site','like',$region);
        $select->order_by('date', 'ASC');
        $select->order_by('total_used_capacity_ratio', 'DESC');
        $responseCS =$this->runQuery($select);
        $responseCSTmp = $responseCS;


        // DDN
        $this->date = $this->provideDateFilter('ddn_sites', 'date');
        $expr       = DB::expr('total_used_capacity/total_usable_capacity total_used_capacity_ratio');
        $select     = DB::select('*',$expr)->from('ddn_sites');
        $select     = $this->date->filterByDate($select,$date );
        $select->where('site','like',$region);
        $select->order_by('date', 'ASC');
        $responseDDN =$this->runQuery($select);
        $responseDDNTmp = $responseDDN;

        // Recorder
        $this->date = $this->provideDateFilter('comcast_recorder_stat.recorder_list', 'date');
        $select     = DB::select('*')->from('comcast_recorder_stat.recorder_list');
        $select     = $this->date->filterByDate($select,$date );
        $select->where('site','like',$region);
        $select->order_by('date', 'ASC');
        $responseRecorders =$this->runQuery($select);
        $responseRecordersTmp = $responseRecorders;

        //assembly the results
        $responseWrap = array(
                   'regions' => $this->getCdvrRegionList()
                  );

        // Iterate over region list from CS, using normalized region names
        foreach($listOfRegions as $index => $regionResponse)
        {
            // Get the utilization value for CS
            $regionCS = $this->searchWithKey('site', $regionResponse['cs'], $responseCS);

            // Get the utilization value for DDN
            $regionDDN = $this->searchWithKey('site', $regionResponse['ddn'], $responseDDN);

            // Get the utilization value for Recorders
            $regionRecorders = $this->searchWithKey('site', $regionResponse['recorders'], $responseRecorders);

            if (!is_null($regionCS) || !is_null($responseRecorders))
            {
                $utilCS  = $regionCS['total_used_capacity'];
                $availCS = $regionCS['total_usable_capacity'];
                $ratioCS = ($availCS > 0 ? $utilCS / $availCS : 0);

                $utilDDN  = $regionDDN['total_used_capacity'];
                $availDDN = $regionDDN['total_usable_capacity'];
                $ratioDDN = ($availDDN > 0 ? $utilDDN / $availDDN : 0);

                $utilRecorders  = $regionRecorders['sum_total_used'];
                $availRecorders = $regionRecorders['sum_total_space'];
                $ratioRecorders = ($availRecorders > 0 ? $utilRecorders / $availRecorders : 0);

                // Calculate using rule set
                // 1 = green / good; CS and DDN < 50% utilized
                // 2 = yellow / warning; CS or DDN >= 50%
                // 3 = red / bad; CS or DDN >= 80%
                // 4 = red / v.bad; CS and DDN >= 75%
                // Default is good until proven otherwise
                $health = 1;

                // Increment to yellow (2) if either is over 50%
                if ($ratioCS > 0.5 || $ratioDDN > 0.5 || $ratioRecorders > 0.5) $health++;

                // Increment to red (3) if either is over 80%
                if ($ratioCS > 0.8 || $ratioDDN > 0.8 || $ratioRecorders > 0.8) $health++;

                // Increment to red (4) if both are over 75%
                if (($ratioCS > 0.75 || $ratioDDN > 0.75) && $ratioRecorders > 0.75) $health++;

                // Add the max ratio for full sorting (1.xyz, 2.abc, 3.def, 4.jkl)
                $health += max($ratioCS, $ratioDDN, $ratioRecorders);

                // Add to the response array
                $responseWrap['dataHealth'][] = array(
                                             'region' => $regionResponse['cs'],
                                             'health' => $health,
                                            );
            }
        }//end foreach

        // sort the $responseWrap['dataHealth'] subarray by the 'health' field value
        $sortedArray = $this->sortBySubValue($responseWrap['dataHealth'], 'health', false);
        $responseWrap['priorityMarket'] = $sortedArray[0];
        $responseWrap['priorityMarketRegion'] = $responseWrap['priorityMarket']['region'];

        $responseCS= $responseCSTmp;

        $responseWrap['dataCS'] = $this->searchWithKey('site', $responseWrap['priorityMarketRegion'], $responseCSTmp );

        // Recorder Throughput
        $throughputRegion = $this->searchWithKey('cs', $responseWrap['priorityMarketRegion'], $listOfRegions);

        $this->date = $this->provideDateFilter('comcast_recorder_stat.recorder_throughput', 'date');
        $select     = DB::select('*')->from('comcast_recorder_stat.recorder_throughput');
        $select     = $this->date->filterByDate($select,$date );
        $select->where('region','like', $throughputRegion['throughput']);
        $select->order_by('date', 'ASC');
        $responseRecordersThroughput =$this->runQuery($select);


        // Presenter_API_cDVR_Legacy_Recorders_Throughput

        $throughputRegion = $this->searchWithKey('cs', $responseWrap['priorityMarketRegion'], $listOfRegions);

        // Write the response data for consumption by the client
        $responseWrap['dataThroughput'] = $responseRecordersThroughput;

        // Write the response data for consumption by the client
        $responseWrap['dataDDN'] = $this->searchWithKey('site', $responseWrap['priorityMarketRegion'], $responseDDNTmp );

        // Presenter_API_cDVR_Legacy_Recorders_Sites
        $recorderRegion = $this->searchWithKey('cs', $responseWrap['priorityMarketRegion'], $listOfRegions);
        // get recorder's name
        $firstWorstRegion = $this->findSubArrayByValue($listOfRegions, 'cs', $responseWrap['priorityMarketRegion']);

        // Write the response data for consumption by the client
        $responseWrap['dataRecorders'] = $this->searchWithKey('site', $firstWorstRegion['recorders'], $responseRecordersTmp );


        $responseWrap['dataRecorders']['sum_total_percent_ratio'] =  $responseWrap['dataRecorders']['sum_total_percent'] / 100;

        // Presenter_API_cDVR_Legacy_Trending
        $dateSixMonthsAgo = date('Y-m-d', strtotime($date .' -180 day'));

        // Query logic starts here, cs, - for 6 months
        $this->date = $this->provideDateFilter('cleversafe_sites', 'date');
        $expr       = DB::expr('total_used_capacity/total_usable_capacity total_used_capacity_ratio');
        $select     = DB::select('*',$expr)->from('cleversafe_sites');
        $select     = $this->date->filterByDateRange($select,$dateSixMonthsAgo, $date );
        $select->where('site','like',$responseWrap['priorityMarketRegion']);
        $select->order_by('date', 'ASC');
        $select->order_by('total_used_capacity_ratio', 'DESC');
        $responseCSTmp6month =$this->runQuery($select);


        // DDN -- for 6 months
        $this->date = $this->provideDateFilter('ddn_sites', 'date');
        $expr       = DB::expr('total_used_capacity/total_usable_capacity total_used_capacity_ratio');
        $select     = DB::select('*',$expr)->from('ddn_sites');
        $select     = $this->date->filterByDateRange($select,$dateSixMonthsAgo, $date );
        $select->where('site','like',$responseWrap['priorityMarketRegion']);
        $select->order_by('date', 'ASC');
        $responseDDNTmp6month =$this->runQuery($select);

        // Recorder
        $this->date = $this->provideDateFilter('comcast_recorder_stat.recorder_list', 'date');
        $select     = DB::select('*')->from('comcast_recorder_stat.recorder_list');
        $select     = $this->date->filterByDateRange($select,$dateSixMonthsAgo, $date );
        $select->where('site','like',$firstWorstRegion['recorders']);
        $select->order_by('date', 'ASC');
        $responseRecordersTmp6month =$this->runQuery($select);

        // Fetch data from DB, and fill to global variable $response
         $responseWrap['dataTrending'] = $this->getDataBuildResponse(
                                    $responseCSTmp6month,
                                    $responseDDNTmp6month,
                                    $responseRecordersTmp6month,
                                    $listOfRegions
                                );


        // Sort each dataset by date
        foreach($responseWrap['dataTrending'] as $key => $array)
        {
            ksort($responseWrap['dataTrending'][$key]);
        }

        // below we re-initialize the region response
        $responseWrap['regions'] = array();
        $responseWrap['regions'][] = $this->findSubArrayByValue($listOfRegions, 'cs', $responseWrap['priorityMarketRegion']);

        return $responseWrap;
    }


    public function getHealth($region, $date)
    {

        // Query logic starts here, cs,
        $this->date = $this->provideDateFilter('cleversafe_sites', 'date');
        $expr       = DB::expr('total_used_capacity/total_usable_capacity total_used_capacity_ratio');
        $select     = DB::select('*',$expr)->from('cleversafe_sites');
        $select     = $this->date->filterByDate($select,$date );
        $select->where('site','like',$region);
        $select->order_by('date', 'ASC');
        $select->order_by('total_used_capacity_ratio', 'DESC');
        $responseCS =$this->runQuery($select);

        // DDN
        $this->date = $this->provideDateFilter('ddn_sites', 'date');
        $select     = DB::select('*')->from('ddn_sites');
        $select     = $this->date->filterByDate($select,$date );
        $select->where('site','like',$region);
        $select->order_by('date', 'ASC');
        $responseDDN =$this->runQuery($select);

        // Recorder
        $this->date = $this->provideDateFilter('comcast_recorder_stat.recorder_list', 'date');
        $select     = DB::select('*')->from('comcast_recorder_stat.recorder_list');
        $select     = $this->date->filterByDate($select,$date );
        $select->where('site','like',$region);
        $select->order_by('date', 'ASC');
        $responseRecorders =$this->runQuery($select);

        //assembly the results
        $this->response = array(
                   'regions' => $this->getCdvrRegionList(),
                   'data'    => array(),
                  );

        $listOfRegions = $this->getCdvrRegionList();

        // Iterate over region list from CS, using normalized region names
        foreach($listOfRegions as $index => $regionResponse)
        {
            // Get the utilization value for CS
            $regionCS = $this->searchWithKey('site', $regionResponse['cs'], $responseCS);

            // Get the utilization value for DDN
            $regionDDN = $this->searchWithKey('site', $regionResponse['ddn'], $responseDDN);

            // Get the utilization value for Recorders
            $regionRecorders = $this->searchWithKey('site', $regionResponse['recorders'], $responseRecorders);

            if (!is_null($regionCS) || !is_null($responseRecorders))
            {
                $utilCS  = $regionCS['total_used_capacity'];
                $availCS = $regionCS['total_usable_capacity'];
                $ratioCS = ($availCS > 0 ? $utilCS / $availCS : 0);

                $utilDDN  = $regionDDN['total_used_capacity'];
                $availDDN = $regionDDN['total_usable_capacity'];
                $ratioDDN = ($availDDN > 0 ? $utilDDN / $availDDN : 0);

                $utilRecorders  = $regionRecorders['sum_total_used'];
                $availRecorders = $regionRecorders['sum_total_space'];
                $ratioRecorders = ($availRecorders > 0 ? $utilRecorders / $availRecorders : 0);

                // Calculate using rule set
                // 1 = green / good; CS and DDN < 50% utilized
                // 2 = yellow / warning; CS or DDN >= 50%
                // 3 = red / bad; CS or DDN >= 80%
                // 4 = red / v.bad; CS and DDN >= 75%
                // Default is good until proven otherwise
                $health = 1;

                // Increment to yellow (2) if either is over 50%
                if ($ratioCS > 0.5 || $ratioDDN > 0.5 || $ratioRecorders > 0.5) $health++;

                // Increment to red (3) if either is over 80%
                if ($ratioCS > 0.8 || $ratioDDN > 0.8 || $ratioRecorders > 0.8) $health++;

                // Increment to red (4) if both are over 75%
                if (($ratioCS > 0.75 || $ratioDDN > 0.75) && $ratioRecorders > 0.75) $health++;

                // Add the max ratio for full sorting (1.xyz, 2.abc, 3.def, 4.jkl)
                $health += max($ratioCS, $ratioDDN, $ratioRecorders);

                // Add to the response array
                $this->response['data'][] = array(
                                             'region' => $regionResponse['cs'],
                                             'health' => $health,
                                            );

                foreach ($this->response['data'] as $index => $value)
                {
                    $this->response['pieChartOneDigit'][$index] = floor($value['health']);
                }

                sort($this->response['pieChartOneDigit']);
            }

        }//end foreach

        return $this->response;

    }




}
