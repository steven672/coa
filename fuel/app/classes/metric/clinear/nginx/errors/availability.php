<?php
/**
 *
 * @package app
 */
class Metric_Clinear_Nginx_Errors_Availability extends Metric_Base
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
     * Generates region trend data for player data
     *
     * @access public
     * @param  String $dateStart Y-m-d formatted date, beginning date of range
     * @param  String $dateEnd   Y-m-d formatted date, end date of range
     * @return Array  Array of daily availability grouped by date
     */
    public function availability($dateStart, $dateEnd)
    {
        $this->date = $this->provideDateFilter('nginx_access_errorfreerate', 'date_created');
        $select = DB::select('date_created','cFacility','cRegion','ErrorRequest','TotalRequest','availability%')->from('nginx_access_errorfreerate');
        $select = $this->date->filterByDateRange($select, $dateStart, $dateEnd);
        return $this->runQuery($select);
    }

}
