<?php

/**
 *
 * @package app
 */

class Metric_ComcastViperWatermarkNew extends Metric_Base
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
        return 'viper_watermark_new';
    }



                /**
     * Returns $limit worst streams in regions for the supplied date by success_rate, failed count
     *
     * @access public
     * @param  String $date  Y-m-d formatted date, day of interests
     * @param  string $region
     * @return Array  Array of streams
     */
    public function coxsuper8worst10($count, $dateStart, $dateEnd)
    {

        // Query logic
        $this->date = $this->provideDateFilter('super8_worst10', 'date_created');
        $select = DB::select('*')->from('super8_worst10');
        $select = $this->date->filterByDateRange($select,$dateStart,$dateEnd);
        $select->limit($count);
        $select->order_by('date_created', 'ASC');
        $select->order_by('Down', 'DESC');
        $responseRaw = $this->runQuery($select);
        $response = $this->createArrayBucketsByField($responseRaw, 'date_created');

        // return the response object
        return $response;

    }



                /**
     * Returns $limit worst streams in regions for the supplied date by success_rate, failed count
     *
     * @access public
     * @param  String $date  Y-m-d formatted date, day of interests
     * @param  string $region
     * @return Array  Array of streams
     */
    public function coxsuper8availability($dateStart, $dateEnd)
    {

        // Query logic
        $this->date = $this->provideDateFilter('super8_errorfree', 'date_created');
        $select = DB::select('*')->from('super8_errorfree');
        $select = $this->date->filterByDateRange($select,$dateStart,$dateEnd);
        $select->order_by('date_created', 'ASC');
        $select->order_by('Down', 'DESC');
        $responseRaw = $this->runQuery($select);
        $response = $this->createArrayBucketsByField($responseRaw, 'date_created');
        return $response;
    }

    public function restartsCox($count, $dateStart, $dateEnd)
    {

        /*
            * Ingest the date and region variables
            * The URL formats for these variables are specified in the /app/config/routes.php file
            * For this API endpoint, both date and region are optional variables
            * Valid URL calls:
            *   /api/clinear/pillar/restarts/cox/100/2017-08-15
         */

        $dbConnection = 'viper_clinear_new';
        $dateProvidedStart = $dateStart;
        $dateProvidedEnd = $dateEnd;
        $limit = $count;


        // Add to the response array (data is raw data)
        $this->response = array('data' => NULL);

        $queryBuilderObject = DB::select(
            array(
             'a.date_created',
             'date',
            ),
            array(
             'a.region',
             'region',
            ),
            array(
             'b.restart_count',
             'count',
            ),
            array(
             'a.ErrorMinutes_AllStreams',
             'errorMinutes',
            )
        );

        // Specify the original table
        $queryBuilderObject->from(array('comcast_viper_watermark_new.pillar_manualrestart_errorminutestotal', 'a'));

        // Join another table with additional conditions
        $queryBuilderObject->join(array('comcast_viper_watermark_new.pillar_manualrestart_count', 'b'), 'LEFT')->on('a.region', '=', 'b.region')->on('a.date_created', '=', 'b.date_created');

        // Refine the query by adding a date or date range check (exit the function with null if this fails)
        if (is_null($queryBuilderObject = $this->queryWhereDateOrRange($queryBuilderObject, $dbFieldDate = 'a.date_created', $dateProvidedStart, $dateProvidedEnd))) return NULL;

        // Sort the results
        $queryBuilderObject->order_by('count', 'desc');

        // Add limit number to query if not wildcard or null
        if (!is_null($limit) && $limit !== '%')
        {
            $queryBuilderObject->limit($limit);
        }

        // Execute the query builder object and return the result set
        $queryData = $this->queryRunUsingConnection($queryBuilderObject, $dbConnection);

        // Bucket by Region
        $queryDataByRegion = $this->createArrayBucketsByField($queryData, 'region');

        $tempArray = array();
        foreach ($queryDataByRegion as $index => $element)
        {
            $tempArray[$index] = array_column($element, 'count');
        }

        //assemble the results
        $response = array(
                   'data' => $queryDataByRegion,
                   'histogramData1' => $tempArray,
                  );

        // return the response object
        return $response;

    }


                /**
     * Returns $limit worst streams in regions for the supplied date by success_rate, failed count
     *
     * @access public
     * @param  String $date  Y-m-d formatted date, day of interests
     * @param  string $region
     * @return Array  Array of streams
     */
    public function coxpillarworst10($count, $dateStart, $dateEnd)
    {

        // Query logic
        $this->date = $this->provideDateFilter('pillar_worst10', 'date_created');
        $select = DB::select('*')->from('pillar_worst10');
        $select = $this->date->filterByDateRange($select,$dateStart,$dateEnd);
        $select->limit($count);
        $select->order_by('date_created', 'ASC');
        $select->order_by('ErrorMinutes', 'DESC');
        $responseRaw = $this->runQuery($select);
        $responserRaw1 = $this->createArrayBucketsByField($responseRaw, 'date_created');

        $response = array(
                    'responseCoxWorst10Pillar' => $responserRaw1,
        );

        // return the response object
        return $response;
    }


    public function coxWorst10Restarts($count, $dateStart, $dateEnd)
    {

        /*
            * Ingest the date and region variables
            * The URL formats for these variables are specified in the /app/config/routes.php file
            * For this API endpoint, both date and region are optional variables
            * Valid URL calls:
            *   //api/clinear/pillar/restarts/coxworst10/10/2017-08-08/2017-08-12
         */

        // Query logic
        $this->date = $this->provideDateFilter('pillar_manualrestart_worst10', 'date_created');
        $select = DB::select('*')->from('pillar_manualrestart_worst10');
        $select = $this->date->filterByDateRange($select,$dateStart,$dateEnd);
        $select->limit($count);
        $select->order_by('date_created', 'ASC');
        $select->order_by('restart_count', 'DESC');
        $responsePillarHotReg10 = $this->runQuery($select);

        return $this->createArrayBucketsByField($responsePillarHotReg10, 'date_created');

    }

    public function restartsMinutesCox($count, $dateStart, $dateEnd)
    {
        /*
            * Ingest the date and region variables
            * The URL formats for these variables are specified in the /app/config/routes.php file
            * For this API endpoint, both date and region are optional variables
            * Valid URL calls:
            *   /api/clinear/pillar/restartscox/100/2017-08-15
         */

        $dbConnection = 'viper_watermark_new';
        $dateProvidedStart = $dateStart;
        $dateProvidedEnd = $dateEnd;

        // Add to the response array (data is raw data)
        $this->response = array('data' => NULL);

        $queryBuilderObject = DB::select(
            array(
             'a.region',
             'market',
            ),
            array(
             'a.restart_count',
             'restartCount',
            ),
            array(
             'b.ErrorMinutes_AllStreams',
             'errorMinutes',
            ),
            array(
             'a.date_created',
             'date',
            )
        );

        // Specify the original table
        $queryBuilderObject->from(array('comcast_viper_watermark_new.pillar_manualrestart_count', 'a'));

        // Join another table with additional conditions
        $queryBuilderObject->join(array('comcast_viper_watermark_new.pillar_manualrestart_errorminutestotal', 'b'), 'LEFT')->on('a.region', '=', 'b.region')->on('a.date_created', '=', 'b.date_created');

        // Join another table with additional conditions
        // Refine the query by adding a date or date range check (exit the function with null if this fails)
        if (is_null($queryBuilderObject = $this->queryWhereDateOrRange($queryBuilderObject, $dbFieldDate = 'a.date_created', $dateProvidedStart, $dateProvidedEnd))) return NULL;

        // Sort the results
        $queryBuilderObject->order_by('date', 'DESC');
        $queryBuilderObject->order_by('restart_count', 'ASC');

        // Add limit number to query if not wildcard or null
        if (!is_null($count) && $count !== '%')
        {
            $queryBuilderObject->limit($count);
        }

        // Execute the query builder object and return the result set
        $data = $this->queryRunUsingConnection($queryBuilderObject, $dbConnection);

        // Build response array, bucketize by date
        return $this->createArrayBucketsByField($data, 'date');

    }


}



