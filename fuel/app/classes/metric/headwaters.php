<?php
/**
 *
 * @package app
 */
class Metric_Headwaters extends Metric_Base
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
        return 'headwaters';
    }

    /**
     * Generates overall availability by date for date range
     *
     * @access public
     * @param  String $dateStart Y-m-d formatted date, beginning date of range
     * @param  String $dateEnd   Y-m-d formatted date, end date of range
     * @return Array  Array of daily availability grouped by date
     */
    public function overallAvailability($dateStart, $dateEnd)
    {
        $this->date = $this->provideDateFilter('headwaters_daily', 'DATE_KEY');
        $select = $this->date->selectByDateRange($dateStart, $dateEnd);
        $select->order_by('DATE_KEY', 'ASC');
        $data = $this->runQuery($select);
        return $this->createArrayBucketsByField($data, 'DATE_KEY');
    }

    /**
     * Generates region trend data for player data
     *
     * @access public
     * @param  String $dateStart Y-m-d formatted date, beginning date of range
     * @param  String $dateEnd   Y-m-d formatted date, end date of range
     * @return Array  Array of daily results for various regions
     */
    public function trendRegion($dateStart, $dateEnd)
    {
        $this->date = $this->provideDateFilter('headwaters_region_daily', 'DATE_KEY');
        $select = $this->date->selectByDateRange($dateStart, $dateEnd);
        $select->order_by('DATE_KEY', 'ASC');
        $data = $this->runQuery($select);
        return $this->createArrayBucketsByField($data, 'DATE_KEY');
    }

    /**
     * Returns $limit worst streams in regions for the supplied date by success_rate, failed count
     *
     * @access public
     * @param  String $date  Y-m-d formatted date, day of interests
     * @param  Int    $limit Number of worst streams for
     * @return Array  Array of streams
     */
    public function worstStreams($date, $limit)
    {
        $this->date = $this->provideDateFilter('headwaters_stream_daily', 'DATE_KEY');
        $select = $this->date->selectByDate($date);
        $select->order_by('AVAILABILITY', 'ASC');
        $select->order_by('FAILED', 'DESC');
        $select->limit($limit);
        return $this->runQuery($select);
    }
}
