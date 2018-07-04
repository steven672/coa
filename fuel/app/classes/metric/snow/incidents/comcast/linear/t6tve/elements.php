<?php
/**
 *
 * @package app
 */
class Metric_Snow_Incidents_Comcast_Linear_T6tve_Elements extends Metric_Base
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
        return 'servicenow';
    }

    /**
     * Generates region trend data for player data
     *
     * @access public
     * @param  String $dateStart Y-m-d formatted date, beginning date of range
     * @param  String $dateEnd   Y-m-d formatted date, end date of range
     * @return Array  Array of daily availability grouped by date
     */
    public function elements($dateStart, $dateEnd)
    {
        $this->date = $this->provideDateFilter('servicenow', 'u_resolved_date');
        $select = DB::select('u_resolved_date','u_elements_ref','sev1 Count', 'sev1 MTTR', 'sev2 Count', 'sev2 MTTR','sev3 Count', 'sev3 MTTR','sev4 Count', 'sev4 MTTR')->from('Linear_daily_closed_elements');
        $select = $this->date->filterByDateRange($select, $dateStart, $dateEnd);
        return $this->runQuery($select);
    }

}
