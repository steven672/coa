<?php

/**
 *
 * @package app
 */

class Metric_Combined_Subscriber_Counts extends Metric_Base
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
     * @return String 'comcast_viper_player'
     */

    protected function getConnection()
    {
        return 'comcast_viper_player';
    }


    public function getRegionalSubscriberCounts($region, $dateStart, $dateEnd)
    {

        // Query logic starts here. Do not grab subscriber data for two specific markets.
        $this->date = $this->provideDateFilter('subscriber_account', 'date_created');
        $select     = DB::select('*')->from('subscriber_account');
        $select     = $this->date->filterByDateRange($select,$dateStart,$dateEnd );
        $select->where('region_name','!=', 'TEST MARKET');
        $select->where('region_name','!=', 'UNDEF');

        if($region == 'cdvr_flag')
        {
            $select->where('cdvr_flag','=',1);
        }
        elseif($region == 'clinear_flag')
        {
            $select->where('clinear_flag','=',1);
        }
        elseif($region == 'mdvr_flag')
        {
            $select->where('mdvr_flag','=',1);
        }
        else
        {
            // If all, no filter at all
        }

        $select->order_by('date_created', 'ASC');
        $select->order_by('count', 'DESC');

        $dataByRegion = $this->createArrayBucketsByField($this->runQuery($select), 'region_name');

        // Sum the count field for each record within each region bucket, put values into new array
        $resultArray = array();
        foreach ($dataByRegion as $region => $value) {
            $resultArray[$region]['totalCount'] = array_sum(array_map(function ($i) { return $i['count']; }, $value));
            $resultArray[$region]['region'] = $region;
            }

        // return $resultArray;

        $totalSubscribers = array_sum(array_map(function ($i) { return $i['totalCount']; }, $resultArray));

        //assemble the results
        $response = array(
                   'perRegionSubscribers' => $resultArray,
                   'totalSubscribers' => $totalSubscribers,
                  );

        // return the response object
        return $response;

    }



}
