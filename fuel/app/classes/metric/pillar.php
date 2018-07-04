<?php
/**
 *
 * @package app
 */
class Metric_Pillar extends Metric_Base
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
        return 'comcast_viper_pillardailyreport';
    }


    /**
     * Generates table for regions without any daily errors from the Pillar component
     *
     * @access public
     * @param  String $dateStart Y-m-d formatted date, beginning date of range
     * @param  String $dateEnd   Y-m-d formatted date, end date of range
     * @return Array  Array of daily availability grouped by date
     */
    public function errorfree($date)
    {
        $this->date = $this->provideDateFilter('comcast_viper_clinear_new.pillar_err_counts_per_region', 'date_created');
        $select = DB::select('date_created', 'cfacility', 'cregion','error_count', 'total_count')->from('pillar_err_counts_per_region');
        $select = $this->date->selectByDate($date);
        $select->order_by('date_created', 'ASC');
        $select->where('error_count','=',0);
        $data = $this->runQuery($select);
        return $this->createArrayBucketsByField($data, 'date_created');
    }


    /**
     * Generates region trend data for pillar data
     *
     * @access public
     * @param  String $dateStart Y-m-d formatted date, beginning date of range
     * @param  String $dateEnd   Y-m-d formatted date, end date of range
     * @return Array  Array of daily availability grouped by date
     */
    public function panicscause($dateStart, $dateEnd)
    {
        $this->date = $this->provideDateFilter('channelpanicsbyrootcause', 'date_created');
        $select = DB::select('date_created', 'ERR', 'count','percent')->from('channelpanicsbyrootcause');
        $select = $this->date->selectByDateRange($dateStart, $dateEnd);
        $select->order_by('date_created', 'ASC');
        $select->order_by('count', 'DESC');
        $data = $this->runQuery($select);
        return $this->createArrayBucketsByField($data, 'date_created');
    }


}
