<?php

/**
 *
 * @package app
 */

class Metric_super8Daily extends Metric_Base
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
     * @return String 'headwaters'
     */

    protected function getConnection()
    {
        return 'super8_daily';
    }

                /**
     * Returns $limit worst streams in regions for the supplied date by success_rate, failed count
     *
     * @access public
     * @param  String $date  Y-m-d formatted date, day of interests
     * @param  string $region
     * @return Array  Array of streams
     */
    public function super8top($count, $dateStart, $dateEnd)
    {

        // Query logic
        $this->date = $this->provideDateFilter('Super8Top10ErrorByRegion', 'date_created');
        $select = DB::select('*')->from('Super8Top10ErrorByRegion');
        $select = $this->date->filterByDateRange($select,$dateStart,$dateEnd);
        $select->limit($count);
        $select->order_by('date_created', 'ASC');
        $select->order_by('count', 'DESC');
        $responseRaw = $this->runQuery($select);
        $response = $this->createArrayBucketsByField($responseRaw, 'date_created');

        // return the response object
        return $response;
    }



}

