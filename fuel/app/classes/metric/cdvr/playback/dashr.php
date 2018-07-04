<?php
/**
 *
 * @package app
 */
class Metric_cDVR_Playback_Dashr extends Metric_Base
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
        return 'comcast_viper_cdvr';
    }

    /**
     * Returns cDVR Playback DASH-R Worst 3 Recording_ID by Market data for the supplied date range
     *
     * @access public
     * @param  String $date  Y-m-d formatted date, day of interests
     * @param  Int $limit Number of worst streams for
     * @return Array  Array of streams
     */

    public function worst($dateStart, $dateEnd)
    {
        $this->date = $this->provideDateFilter('dash_r_worst3_per_region', 'date_created');
        $select     = DB::select('*')->from('comcast_viper_cdvr.dash_r_worst3_per_region');
        $select     = $this->date->filterByDateRange($select,$dateStart,$dateEnd);
        $select->order_by('cregion', 'DESC');
        return $this->runQuery($select);
    }


    /**
     * Returns $limit worst streams in regions for the supplied date by success_rate, failed count
     *
     * @access public
     * @param  String $date  Y-m-d formatted date, day of interests
     * @param  Int $limit Number of worst streams for
     * @return Array  Array of streams
     */

    public function worstStreams($date, $limit)
    {
        $this->date = $this->provideDateFilter('dash_r_worst10', 'date_created');
        $select = $this->date->selectByDate($date);
        $select->limit($limit);
        $select->order_by('error', 'DESC');
        return $this->runQuery($select);
    }
}
