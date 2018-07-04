<?php
/**
 *
 * @package app
 */
class Metric_CMC_Pillar extends Metric_Base
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
        return 'cmcbackup';
    }

    /**
     * Generates region trend data for player data
     *
     * @access public
     * @param  String $dateStart Y-m-d formatted date, beginning date of range
     * @param  String $dateEnd   Y-m-d formatted date, end date of range
     * @return Array  Array of daily availability grouped by date
     */
    public function availability($dateStart, $dateEnd)
    {
        $this->date = $this->provideDateFilter('pillar_cmc_daily', 'date_created');
        $select = DB::select('date_created','site', 'AvgEFTime', 'MedErrorFreeMinutes','MinErrorFreeMinutes', 'P75', 'P95', 'P99')->from('PillarRegionLevelSuccessRate');
        $select = $this->date->filterByDateRange($select, $dateStart, $dateEnd);
        $select->order_by('date_created', 'ASC');
        return $data = $this->runQuery($select);
    }

    /**
     * Generates region trend data for player data
     *
     * @access public
     * @param  String $dateStart Y-m-d formatted date, beginning date of range
     * @param  String $dateEnd   Y-m-d formatted date, end date of range
     * @return Array  Array of daily availability grouped by date
     */
    public function worststreams($dateStart, $dateEnd)
    {
        $this->date = $this->provideDateFilter('pillar_cmc_daily', 'date_created');
        $select = DB::select('date_created','site', 'channel','MinutesWithErrors', 'TotalMinutes','ErrorFreeMinutes')->from('PillarWorst10Channels');
        $select = $this->date->filterByDateRange($select, $dateStart, $dateEnd);
        $select->order_by('date_created', 'ASC');
        return $this->runQuery($select);
    }

}
