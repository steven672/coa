<?php
/**
 *
 * @package app
 */
class Metric_Clinear_Super8_Hot_Error_Codes extends Metric_Base
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
        return 'viper_super8Daily';
    }

    /**
     * Generates region trend data for Super8 linear data
     *
     * @access public
     * @param  String $dateStart Y-m-d formatted date, beginning date of range
     * @param  String $dateEnd   Y-m-d formatted date, end date of range
     * @return Array  Array of daily availability grouped by date
     */
    public function codes($dateStart, $dateEnd)
    {
        $this->date = $this->provideDateFilter('Super8Top10ErrorByRegion', 'date_created');
        $select = DB::select('date_created','cRegion','Error_Code','count','percent')->from('Super8Top10ErrorByRegion')->where('Delivery_Lane', '=', 'cLinear');
        $select = $this->date->filterByDateRange($select, $dateStart, $dateEnd);
        return $this->runQuery($select);
    }




        /* Returns super8 error codes (cdvr lane) for the supplied date by region
     *
     * @access public
     * @param  String $date  Y-m-d formatted date, day of interests
     * @param  string $region
     * @return Array  Array of streams
     */
public function super8errorscdvr($dateStart, $dateEnd)
    {

        // Query logic
        $this->date = $this->provideDateFilter('TopDeliveryLanesWithMostErrors', 'date_created');
        $select = DB::select('*')->from('TopDeliveryLanesWithMostErrors');
        $select = $this->date->filterByDateRange($select,$dateStart,$dateEnd);
        $select->where('Delivery_Lane', '=', 'cDVR');
        $select->order_by('date_created', 'ASC');

        $responseRaw = $this->runQuery($select);
        return $this->createArrayBucketsByField($responseRaw, 'date_created');
    }



            /* Returns super8 error codes (cLinear lane) for the supplied date by region
     *
     * @access public
     * @param  String $date  Y-m-d formatted date, day of interests
     * @param  string $region
     * @return Array  Array of streams
     */
public function super8errorsclinear($dateStart, $dateEnd)
    {

        // Query logic
        $this->date = $this->provideDateFilter('TopDeliveryLanesWithMostErrors', 'date_created');
        $select = DB::select('*')->from('TopDeliveryLanesWithMostErrors');
        $select = $this->date->filterByDateRange($select,$dateStart,$dateEnd);
        $select->where('Delivery_Lane', '=', 'cLinear');
        $select->order_by('date_created', 'ASC');

        $responseRaw = $this->runQuery($select);
        return $this->createArrayBucketsByField($responseRaw, 'date_created');
    }




            /* Returns super8 error codes (iVod lane) for the supplied date by region
     *
     * @access public
     * @param  String $date  Y-m-d formatted date, day of interests
     * @param  string $region
     * @return Array  Array of streams
     */
public function super8errorsivod($dateStart, $dateEnd)
    {

        // Query logic
        $this->date = $this->provideDateFilter('TopDeliveryLanesWithMostErrors', 'date_created');
        $select = DB::select('*')->from('TopDeliveryLanesWithMostErrors');
        $select = $this->date->filterByDateRange($select,$dateStart,$dateEnd);
        $select->where('Delivery_Lane', '=', 'iVOD');
        $select->order_by('date_created', 'ASC');

        $responseRaw = $this->runQuery($select);
        return $this->createArrayBucketsByField($responseRaw, 'date_created');
    }



}
