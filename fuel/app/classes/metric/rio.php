<?php

/**
 *
 * @package app
 */

class Metric_Rio extends Metric_Base
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
        return 'comcast_rio';
    }

    //  * Returns $limit worst hosts for the supplied date by failed count
    //  *
    //  * @access public
    //  * @param  String $date  Y-m-d formatted date, day of interests
    //  * @param  Int    $limit Number of worst hosts
    //  * @return Array  Array of hosts with failure counts and failure rates

    public function hosts($date, $limit)
    {
        $this->date = $this->provideDateFilter('Top10HostWithMostRecordingFail@ManifestAgent', 'date_created');
        $select = $this->date->selectByDate($date);
        $select->limit($limit);
        $select->order_by('failed', 'DESC');
        $results =  $this->runQuery($select);
        return $this->createArrayBucketsByField($results, 'date_created');
    }


    //  * Returns $limit worst error codes from rio components during the $date supplied
    //  *
    //  * @access public
    //  * @param  String $date  Y-m-d formatted date, day of interests
    //  * @param  Int    $limit Number of worst hosts
    //  * @return Array  Array of regions with error codes and count of error codes

        public function errorcodes($date, $limit)
    {
        $this->date = $this->provideDateFilter('Top10RioErrorCodes1h', 'date_key');
        // $select = DB::select('cRegion', 'count', 'code')->from('comcast_rio.Top10RioErrorCodes');
        $select = $this->date->selectByDate($date);
        $data = $this->runQuery($select);

        $dataByCode = $this->createArrayBucketsByField($data, 'code');

        // Sum the code counts within each code bucket, put values into new array
        $resultArray = array();
        foreach ($dataByCode as $code => $value) {
            if (!array_key_exists($code, $resultArray))
                {
                    $resultArray[$code]['count'] = array_sum(array_map(function ($i) { return $i['count']; }, $value));
                    $resultArray[$code]['code'] = $code;
                }
            }

        // sort the resultArray's subarray by the 'count' field value
        $sortedResultsArray = $this->sortBySubValue($resultArray, 'count', false);

        return $sortedResultsArray;

    }

    //  * Returns the count of restarts at Rio components for the supplied date or date range
    //  *
    //  * @access public
    //  * @param  String $startDate/$endDate  Y-m-d formatted date
    //  * @return Array - Array of objects where each object contains format: {"cRegion":"Albuquerque","Component":"manifest-agent","Restarts":"78221"}

    public function restarts($region, $dateStart, $dateEnd)
    {
        $this->date = $this->provideDateFilter('Worst10RestartsByComponent', 'date_created');
        $select = DB::select('*')->from('Worst10RestartsByComponent');
        $select     = $this->date->filterByDateRange($select,$dateStart,$dateEnd);
        $select->where('cRegion','like',$region);
        $select->order_by('Restarts', 'DESC');
        $results =  $this->runQuery($select);

        $originalStrings = array("a8-updater", "archive-agent", "dash-origin", "manifest-agent", "reconstitution-agent", "recorder-manager", "segment-recorder");
        $formattedStrings = array("A8 Updater", "Archive Agent", "Dash Origin", "Manifest Agent", "Reconstitution Agent", "Recorder Manager", "Segment Recorder");

        // replace component names
        $results = $this->deepReplace($originalStrings,$formattedStrings,$results);

        // nest datta by component to allow for easier summing of total restarts by component
        $dataByComponent = ($this->createArrayBucketsByField($results, 'Component'));

        $resultsArray = $dataByComponent;
        foreach ($dataByComponent as $component => $value) {
            $totalRestartsPerComponent = array_sum(array_map(function ($i) { return $i['Restarts']; }, $value));
            $processedValue = array_map(function($e) use ($totalRestartsPerComponent, $component) {
                $e['Contribution'] = $e['Restarts'] / $totalRestartsPerComponent;
                $e['Component'] = $component;
                $e['TotalPerComponent'] = $totalRestartsPerComponent;
                return $e;
            }, $value);
            $resultsArray[$component] = $processedValue;
        }

        return $resultsArray;

    }


}
