<?php
/**
 *
 * @package app
 */
class Metric_ComcastJiraMetrics extends Metric_Base
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
        return 'jira_metrics';
    }

    /**
     * Returns $limit worst streams in regions for the supplied date by success_rate, failed count
     *
     * @access public
     * @param  String $date  Y-m-d formatted date, day of interests
     * @param  Int $limit Number of worst streams for
     * @return Array  Array of streams
     */

    public function comcastComponents($component, $dateStart, $dateEnd)
    {

        //  Query logic starts here
        $this->date = $this->provideDateFilter('t6c', 'date_created');
        $select     = DB::select('*')->from('t6c');
        $select     = $this->date->filterByDateRange($select,$dateStart,$dateEnd);
        $select->where('component','like',$component);
        $select->order_by('date_created', 'ASC');
        $responseComponentsDay = $this->runQuery($select);


        //  Query logic starts here
        $this->date = $this->provideDateFilter('t6c_weekly', 'date_created');
        $select     = DB::select('*')->from('t6c_weekly');
        $select     = $this->date->filterByDateRange($select,$dateStart,$dateEnd);
        $select->where('component','like',$component);
        $select->order_by('date_created', 'ASC');
        $responseComponentsWeek = $this->runQuery($select);


        // Assemble the results
        $response = array(
                                   'Hours24' => $this->createArrayBucketsByField($responseComponentsDay, 'date_created'),
                                   'Days7'   => $this->createArrayBucketsByField($responseComponentsWeek, 'date_created'),
                  );

        // Return the response object
        return $response;

    }


}

