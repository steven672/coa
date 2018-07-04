<?php

/**
 *
 * @package app
 */

class Metric_cDVR_Performance_Rio_Failures extends Metric_Base
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
     * @return String 'comcast_rio'
     */

    protected function getConnection()
    {
        return 'comcast_rio';
    }


    /**
     * Returns $limit worst hosts for the supplied date by failed count
     *
     * @access public
     * @param  String $date  Y-m-d formatted date, day of interests
     * @param  Int    $limit Number of worst hosts
     * @return Array  Array of hosts with failure counts and failure rates
     */
    public function hosts($date, $limit)
    {
        $this->date = $this->provideDateFilter('Top10HostWithMostRecordingFail@ManifestAgent', 'date_created');
        $select = $this->date->selectByDate($date);
        $select->limit($limit);
        $select->order_by('failed', 'DESC');
        $results =  $this->runQuery($select);
        return $this->createArrayBucketsByField($results, 'date_created');
    }

    /**
     * Returns time series data for all recordings in selected markets
     *
     * @access public
     * @param  String $dateStart  Y-m-d formatted date
     * @param  String $dateEnd  Y-m-d formatted date
     * @param  String $limit Regions to limit for query
     * @return Array  Array of market data points with failure counts and failure rates
     */
    public function getMarkets($dateStart, $dateEnd, $region)
    {
        $this->date = $this->provideDateFilter('Rio_recording_status', 'date_created');
        $select = $this->date->selectByDateRange($dateStart, $dateEnd);
        $select->where('market', 'like', $region);
        $results = $this->runQuery($select);

        if (empty($results))
        {
            $totalRecordingsSummed = 0;
            $failuresSummed = 0;
            $successRate = 0;
            $failureRate = 0;
        }
        else
        {
            // extract successes and failures from each market
            $totalRecordingsArray = array_column($results, 'recording_total');
            $failuresArray = array_column($results, 'recording_failed');

            // sum the successes into one variable and the failures into another
            $totalRecordingsSummed = array_sum($totalRecordingsArray);
            $failuresSummed = array_sum($failuresArray);

            // calculate the success and failure rates
            $successRate = ($totalRecordingsSummed / ($totalRecordingsSummed + $failuresSummed));
            $failureRate = ($failuresSummed / ($totalRecordingsSummed + $failuresSummed));

            $regions = (new Model_RegionList())->listAllRio();;

            // map the raw site name text to more user friendly/readable text using the $listOfRegionsRio array.
            foreach ($results as $key => $value)
            {
                $region = $this->findSubArrayByValue($regions, 'status', $value['market']);
                $results[$key]['market'] = $region['text'];;
            }
        }

        return array(
            'data' => $results,
            'totalRecordingsSummed' => $totalRecordingsSummed,
            'failuresSummed' => $failuresSummed,
            'successRate' => $successRate,
            'failureRate' => $failureRate,
        );
    }


    public function getWorst5StreamsWith5Market($dateStart, $dateEnd, $region)
    {

        $tableName = DB::expr('`Worst5StreamsPerMarket@ManifestAgent`');
        $this->date = $this->provideDateFilter($tableName, 'date_created');
        $select = $this->date->selectByDateRange($dateStart, $dateEnd);
        $select->where('cRegion','like',$region);
        $select->order_by('date_created', 'ASC');
        $select->order_by('cRegion', 'ASC');
        $select->order_by('Failed', 'DESC');
        $queryOutput = $this->createArrayBucketsByField($this->runQuery($select), 'date_created');

        // All code below deals with identifing the Five Markets with the most recording failures
        $data = $this->runQuery($select);
        $array = $this->createArrayBucketsByTwoField($data, 'date_created', 'cRegion');

        // Sum the count of failures by region for each date
        $newArray = array();
        foreach ($array as $date => $regionArray) {
            foreach ($regionArray as $regionName => $region) {
                $newArray[$regionName] = array_reduce($region, function ($sum, $item) { return $sum + $item['Failed']; });
            }
        }

        // sort array (region: failureCount, region:failureCount, ...) by failure count, keep 5 regions with most failures
        arsort($newArray);
        $worstFiveMarkets = array_keys(array_slice($newArray, 0, 5));

        // assemble query response as well as list of worst five markets
        $response = array(
                   'tableData' => $queryOutput,
                   'listOfMarkets' => $worstFiveMarkets, // structure: (region, region, region, ...)
                  );

        // return the response object
        return $response;

    }
}
