<?php
/**
 *
 * @package app
 */
class Metric_Jiraplannedwork extends Metric_Base
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
        return 'comcast_viper_jiraccpplannedwork';
    }

    /**
     * Generates region trend data for player data
     *
     * @access public
     * @param  String $dateStart Y-m-d formatted date, beginning date of range
     * @param  String $dateEnd   Y-m-d formatted date, end date of range
     * @return Array  Array of daily availability grouped by date
     */
    public function plannedimpactedservices($platform, $dateStart, $dateEnd)
    {
        $this->date = $this->provideDateFilter('VOPSPlannedWork', 'date_created');
        $select = DB::select('*')->from('VOPSPlannedWork');
        $select->where('VOPSImpactedServices', '=', $platform);
        $select = $this->date->filterByDateRange($select, $dateStart, $dateEnd);
        $responseRaw = $this->runQuery($select);
        return $this->createArrayBucketsByField($responseRaw, 'date_created');
    }

}
