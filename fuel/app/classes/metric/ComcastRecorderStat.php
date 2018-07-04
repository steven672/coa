<?php

/**
 *
 * @package app
 */

class Metric_ComcastRecorderStat extends Metric_Base
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

           /**
     * Returns $limit worst streams in regions for the supplied date by success_rate, failed count
     *
     * @access public
     * @param  String $date  Y-m-d formatted date, day of interests
     * @param  String component
     * @param  String region
     * @return Array  Array of data
     */
    public function recordertrend($dateStart, $dateEnd, $region)
    {

        $this->date = $this->provideDateFilter('recorder_list', 'date');
        $expr   = DB::expr('sum_total_percent/100 AS recorders' );
        $select = DB::select('*', $expr )->from('recorder_list');
        $select = $this->date->filterByDateRange($select, $dateStart, $dateEnd);
        $select->where('site', 'like', $region);
        $select->order_by('date', 'ASC');
        $dataRaw  = $this->runQuery($select);
        $response = $this->createArrayBucketsByTwoField($dataRaw,'site','date');

        return $response;
    }

}
