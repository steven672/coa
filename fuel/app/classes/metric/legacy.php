<?php
/**
 *
 * @package app
 */
class Metric_Legacy extends Metric_Base
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
     * @return String 'site'
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
     * @param  Int    $limit Number of worst streams for
     * @return Array  Array of streams
     */
    public function sites($date)
    {

        // Perform a calculation and save it into the response (save as a new element in each sub-array of the response object)
        $this->date = $this->provideDateFilter('recorder_list', 'date');
        $select = DB::select('date','site','rec_count','sum_total_space','sum_total_used','sum_total_percent' ,'(sum_total_percent/100) as sum_total_percent_ratio ')->from('recorder_list');
        $select = $this->date->filterByDate($select, $date);
        return   $this->runQuery($select);
    }

}
