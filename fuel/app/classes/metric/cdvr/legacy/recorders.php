    <?php

/**
 *
 * @package app
 */

class Metric_cDVR_Legacy_Recorders extends Metric_Base
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
        return 'recorder_stat';
    }


    public function getMinMax($region, $dateStart, $dateEnd)
    {

        $legacyRegions = (array_map(function ($i) { return $i['throughput']; }, $this->getCdvrRegionList()));

        // . Query logic starts here, *,
        $this->date = $this->provideDateFilter('recorder_throughput', 'date');
        $select     = DB::select('*')->from('recorder_throughput');
        $select     = $this->date->filterByDateRange($select,$dateStart,$dateEnd);
        // $select     = $this->region->filterByRegions($select,'region',$legacyRegions);
        $select->where('region','in',$legacyRegions);
        $select->order_by('date', 'ASC');
        $responseRecorders =$this->runQuery($select);

        $regions = $this->getCdvrRegionList();

        // Bucket data by date
        $responseDataByDate = $this->createArrayBucketsByField($responseRecorders, 'date');

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
                $searchSubKey = 'region',
                $searchValue = $arrayOneObject['region']
            );

            // $pd = percent difference array
            $pd = (($arrayTwoObject['peak_throughput'] - $arrayOneObject['peak_throughput']) / $arrayOneObject['peak_throughput']) * 100;

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
            $region = $this->findSubArrayByValue($regions, 'throughput', $value['region']);
            $response[$key]['labelText'] = $region['text'];
        }

        // Write the response data for consumption by the client
        $response = array(
            'regions' => $this->getCdvrRegionList(),
            'MinMaxPeakThroughput' => $response,
        );

        return $response;

    }


}
