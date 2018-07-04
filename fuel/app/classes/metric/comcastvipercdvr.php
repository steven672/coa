<?php
/**
 *
 * @package app
 */
class Metric_ComcastVipercDVR extends Metric_Base
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
     * Generates Super8 Availability data by date or date range ordered by date and error count
     *
     * @access public
     * @param  String $dateStart Y-m-d formatted date, beginning date of range
     * @param  String $dateEnd   Y-m-d formatted date, end date of range
     * @return Array  Array of daily availability grouped by date
     *   /api/cdvr/performance/super8/availability/dateStart/dateEnd
     *   /api/cdvr/performance/super8/availability/2017-05-05
     */

    public function availabilitySuper8($dateStart, $dateEnd)
    {
        $this->date = $this->provideDateFilter('playback_super8_errorfree', 'date_created');
        $select = $this->date->selectByDateRange($dateStart, $dateEnd);
        $select->order_by('date_created', 'ASC');
        $select->order_by('error', 'DESC');
        $data = $this->runQuery($select);
        return $this->createArrayBucketsByField($data, 'date_created');
    }


    /**
     * Generates Dashr Availability data by date or date range ordered by date and error count
     *
     * @access public
     * @param  String $dateStart Y-m-d formatted date, beginning date of range
     * @param  String $dateEnd   Y-m-d formatted date, end date of range
     * @return Array  Array of daily availability grouped by date
     */
    public function availabilityDashr($dateStart, $dateEnd)
    {
        $this->date = $this->provideDateFilter('dash_r_errorfree', 'date_created');
        $select = $this->date->selectByDateRange($dateStart, $dateEnd);
        $select->order_by('date_created', 'ASC');
        $select->order_by('errorfree_percentage', 'DESC');
        $data = $this->runQuery($select);
        return $this->createArrayBucketsByField($data, 'date_created');
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
