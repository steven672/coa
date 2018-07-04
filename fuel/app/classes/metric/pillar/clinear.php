<?php
/**
 *
 * @package app
 */
class Metric_Pillar_cLinear extends Metric_Base
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
     * @return String 'viper_clinear_new'
     */
    protected function getConnection()
    {
        return 'viper_clinear_new';
    }


    /**
     * Generates table for facility-regions with zero daily errors from the Pillar component
     *
     * @access public
     * @param  String $date yyyy-mm-dd formatted date
     * @return Array  Array of facilities and regions with no errors from the pillar component over the previous day
     */
    public function errorfree($date)
    {
        $this->date = $this->provideDateFilter('pillar_err_counts_per_region', 'date_created');
        $select = DB::select('date_created', 'cfacility', 'cregion','error_count', 'total_count')->from('pillar_err_counts_per_region');
        $select = $this->date->selectByDate($date);
        $select->order_by('date_created', 'ASC');
        $select->where('error_count','=',0);
        $data = $this->runQuery($select);
        return $this->createArrayBucketsByField($data, 'date_created');
    }


}
