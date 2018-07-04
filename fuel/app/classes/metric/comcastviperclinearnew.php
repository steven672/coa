<?php

/**
 *
 * @package app
 */

class Metric_ComcastVipercLinearNew extends Metric_Base
{
    /**
     * Returns the used database type

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
        return 'viper_clinear_new';
    }

    protected function pillarWorst($table, $count, $dateStart, $dateEnd)
    {
        // Query logic
        $this->date = $this->provideDateFilter($table, 'date_created');
        $select = DB::select('*')->from($table);
        $select = $this->date->filterByDateRange($select, $dateStart, $dateEnd);
        $select->limit($count);
        $select->order_by('date_created', 'ASC');
        $select->order_by('minutes_with_error', 'DESC');
        $response = $this->runQuery($select);
        $response = $this->createArrayBucketsByField($response, 'date_created');
        return $response;
    }

    public function comcastAvailabilityRaw($count, $dateStart, $dateEnd)
    {

        $responsePillarHotReg10 = $this->pillarWorst(
            'pillar_regional_worstst_10_stream',
            $count,
            $dateStart,
            $dateEnd

        );

        $responsePillarHotNat10 = $this->pillarWorst(
            'pillar_national_worstst_10_stream',
            $count,
            $dateStart,
            $dateEnd
        );

        $responsePillarHotReg5 = $this->pillarWorst(
            'pillar_regional_worstest_5_stream',
            $count,
            $dateStart,
            $dateEnd
        );

        //assemble the results
        $response = array(
                   'NATWorst10' => $responsePillarHotNat10,
                   'RegWorst10' => $responsePillarHotReg10,
                   'RegWorst5'  => $responsePillarHotReg5,
                  );

        // return the response object
        return $response;

    }


    public function comcastAvailabilityAverage($dateStart, $dateEnd)
    {
        /*
            * Ingest the date and region variables
            * The URL formats for these variables are specified in the /app/config/routes.php file
            * For this API endpoint, both date and region are optional variables
            * Valid URL calls:
            *   /api/clinear/combined/availability/average/comcast/2017-01-01/2017-01-10         From January 1, 2017 to January 10, 2017 in all duplicate tickets (YYYY-MM-DD)
         */

        $dbConnection = 'viper_clinear_new';
        $dateProvidedStart = $dateStart;
        $dateProvidedEnd = $dateEnd;

        // Add to the response array (data is raw data)
        $this->response = array('data' => NULL);

        $queryBuilderObject = DB::select(
            array(
             'a.cfacility',
             'facility',
            ),
            array(
             'a.cregion',
             'region',
            ),
            array(
             'a.average_errorfree_time_percentage',
             'avg',
            ),
            array(
             'a.medium_errorfree_minutes_percentage',
             'med',
            ),
            array(
             'a.minimum_errorfree_minutes_percentage',
             'min',
            ),
            array(
             'd.error_count',
             'errors',
            ),
            array(
             'b.error_free_rate',
             'average',
            ),
            array(
             'c.availability',
             'avail',
            ),
            array(
             'a.date_created',
             'date',
            )
        );

        // Specify the original table
        $queryBuilderObject->from(array('comcast_viper_clinear_new.pillar', 'a'));

        // Join another table with additional conditions
        $queryBuilderObject->join(array('comcast_viper_clinear_new.pillar_err_counts_per_region', 'd'), 'LEFT')->on('a.cfacility', '=', 'd.cfacility')->on('a.date_created', '=', 'd.date_created')->on('a.cregion', '=', 'd.cregion');

        // Join another table with additional conditions
        $queryBuilderObject->join(array('comcast_viper_clinear_new.super8_error_free_per_region', 'b'), 'LEFT')->on('a.cfacility', '=', 'b.cfacility')->on('a.date_created', '=', 'b.date_created')->on('a.cregion', '=', 'b.cregion');

        // Join another table with additional conditions
        $queryBuilderObject->join(array('comcast_viper_clinear_new.varnish_error_free', 'c'), 'LEFT')->on('a.cfacility', '=', 'c.cfacility')->on('a.date_created', '=', 'c.date_created')->on('a.cregion', '=', 'c.cregion');

        // Refine the query by adding a date or date range check (exit the function with null if this fails)
        if (is_null($queryBuilderObject = $this->queryWhereDateOrRange($queryBuilderObject, $dbFieldDate = 'a.date_created', $dateProvidedStart, $dateProvidedEnd))) return NULL;

        // Sort the results
        $queryBuilderObject->order_by('avg', 'asc');

        $data = $this->queryRunUsingConnection($queryBuilderObject, $dbConnection);

        return $this->createArrayBucketsByField($data, 'date');

    }


    public function coxAvailabilityAverage($dateStart, $dateEnd)
    {
        /*
            * Ingest the date and region variables
            * The URL formats for these variables are specified in the /app/config/routes.php file
            * For this API endpoint, both date and region are optional variables
            * Valid URL calls:
            *   /api/clinear/combined/availability/average/cox/2017-01-01/2017-01-10         From January 1, 2017 to January 10, 2017 in all duplicate tickets (YYYY-MM-DD)
         */


        $dbConnection = 'viper_clinear_new';
        $dateProvidedStart = $dateStart;
        $dateProvidedEnd = $dateEnd;

        // Add to the response array (data is raw data)
        $this->response = array('data' => NULL);

        $queryBuilderObject = DB::select(
            array(
             'a.region',
             'region',
            ),
            array(
             'a.Avg_ErrorFreeTime_Percentage',
             'Avg',
            ),
            array(
             'a.Med_ErrorFreeTime_Percentage',
             'Med',
            ),
            array(
             'Min_ErrorFreeTime_Percentage',
             'Min',
            ),
            array(
             'b.Down',
             'Down',
            ),
            array(
             'c.avg_errorfree_rate',
             'average',
            ),
            array(
             'a.date_created',
             'date',
            )
        );

        // Specify the original table
        $queryBuilderObject->from(array('comcast_viper_watermark_new.pillar_errorfree_minutes', 'a'));

        // Join another table with additional conditions
        $queryBuilderObject->join(array('comcast_viper_watermark_new.pillar_errorcount', 'b'), 'LEFT')->on('a.date_created', '=', 'b.date_created')->on('a.region', '=', 'b.region');

        // Join another table with additional conditions
        $queryBuilderObject->join(array('comcast_viper_watermark_new.super8_errorfree', 'c'), 'LEFT')->on('a.region', '=', 'c.region')->on('a.date_created', '=', 'c.date_created');

        // Refine the query by adding a date or date range check (exit the function with null if this fails)
        if (is_null($queryBuilderObject = $this->queryWhereDateOrRange($queryBuilderObject, $dbFieldDate = 'a.date_created', $dateProvidedStart, $dateProvidedEnd))) return NULL;

        // Sort the results
        $queryBuilderObject->order_by('Down', 'desc');

        $data = $this->queryRunUsingConnection($queryBuilderObject, $dbConnection);

        return $this->createArrayBucketsByField($data, 'date');
    }

     /* Returns regional transcoder alarms for the supplied date by success_rate, failed count

     *
     * @access public
     * @param  String $date  Y-m-d formatted date, day of interests
     * @param  string $region
     * @return Array  Array of streams
     */

    public function super8availability($dateStart, $dateEnd)
    {

        // Perform a calculation and save it into the response (save as a new element in each sub-array of the response object)
        $this->date = $this->provideDateFilter('comcast_viper_clinear_new.super8_error_free_per_region', 'date_created');
        $select = DB::select('*')->from('comcast_viper_clinear_new.super8_error_free_per_region');
        $select = $this->date->selectByDateRange($dateStart, $dateEnd);
        $select->order_by('date_created', 'ASC');
        $select->order_by('error_count', 'DESC');
        $responseRaw = $this->runQuery($select);
        $responseByDate = $this->createArrayBucketsByField($responseRaw, 'date_created');
        $responseByFacility = $this->createArrayBucketsByField($responseRaw, 'cfacility');
        $responseByRegion = $this->createArrayBucketsByField($responseRaw, 'cregion');


        $tempArray = array();
        foreach ($responseByRegion as $index => $element)
        {
            $tempArray[$index] = array_column($element, 'error_count');

        }

                //assemble the results
        $response = array(
                   'data'          => $responseByDate,
                   'dataFacility'  => $responseByFacility,
                   'dataCregion'   =>  $responseByRegion,
                   'histogramData1'=>   $tempArray,
                  );

        return  $response;
    }

            /**
     * Returns $limit worst streams in regions for the supplied date by success_rate, failed count
     */
    public function transcoderregionalarms($dateStart, $dateEnd)
    {

        // Query logic
        $this->date = $this->provideDateFilter('transcoder_region_alarms', 'date_created');
        $select = DB::select('*')->from('transcoder_region_alarms');
        $select = $this->date->filterByDateRange($select,$dateStart,$dateEnd);
        $select->order_by('date_created', 'ASC');
        $responseRaw = $this->runQuery($select);
        return $this->createArrayBucketsByField($responseRaw, 'date_created');
    }



                /**
     * Returns $limit worst Transcoder continuity for the supplied date by limit (default 10), success_rate, failed count
     * api/clinear/transcoder/continuity/hot/3/2017-05-07
     * api/clinear/transcoder/continuity/hot/all/2017-05-07

     *
     * @access public
     * @param  String $date  Y-m-d formatted date, day of interests
     * @param  string $region
     * @return Array  Array of streams
     */


    public function super8worst10($count, $dateStart, $dateEnd)
    {
       // Query logic
        $this->date = $this->provideDateFilter('super8_regional_worst10', 'date_created');
        $select = DB::select('*')->from('super8_regional_worst10');
        $select = $this->date->filterByDateRange($select,$dateStart,$dateEnd);
        $select->limit($count);
        $select->order_by('date_created', 'ASC');
        $select->order_by('error_count', 'DESC');
        $responsesuper8HotReg10 = $this->runQuery($select);
        $responsesuper8HotReg10 = $this->createArrayBucketsByField($responsesuper8HotReg10, 'date_created');


        $this->date = $this->provideDateFilter('super8_national_worst10', 'date_created');
        $select = DB::select('*')->from('super8_national_worst10');
        $select = $this->date->filterByDateRange($select,$dateStart,$dateEnd );
        $select->limit($count);
        $select->order_by('date_created', 'ASC');
        $select->order_by('error_count', 'DESC');
        $responsesuper8HotNat10 = $this->runQuery($select);
        $responsesuper8HotNat10 = $this->createArrayBucketsByField($responsesuper8HotNat10, 'date_created');


        $this->date = $this->provideDateFilter('super8_worst5', 'date_created');
        $select = DB::select('*')->from('super8_worst5');
        $select = $this->date->filterByDateRange($select,$dateStart,$dateEnd );
        $select->limit($count);
        $select->order_by('date_created', 'ASC');
        $select->order_by('error_count', 'DESC');
        $responsesuper8HotReg5 = $this->runQuery($select);
        $responsesuper8HotReg5 = $this->createArrayBucketsByField($responsesuper8HotReg5, 'date_created');


        //assemble the results
        $response = array(
                   'NATWorst10' => $responsesuper8HotNat10,
                   'RegWorst10' => $responsesuper8HotReg10,
                   'RegWorst5'  => $responsesuper8HotReg5,
        );

         // return the response object
        return $response;
    }

    public function transcodercontinuityworst10($count, $dateStart, $dateEnd)
    {

        // Query logic
        $this->date = $this->provideDateFilter('transcoder_continuity_worst10', 'date_created');
        $select = DB::select('*')->from('transcoder_continuity_worst10');
        $select = $this->date->filterByDateRange($select,$dateStart,$dateEnd);
        $select->order_by('date_created', 'ASC');
        $select->order_by('failed', 'DESC');
        $select->limit($count);
        $responseRaw = $this->runQuery($select);
        $responseRaw1 = $this->createArrayBucketsByField($responseRaw, 'date_created');

        //assemble the results
        $response = array(
                   'responseTranscoderHotContinuity10' => $responseRaw1,

                  );

        // return the response object
        return $response;


    }


        /**
     * Returns $limit trend in regions for the supplied date by success_rate, failed count

    }


    /* Returns regional transcoder continuity for the supplied date by region
     *
     * @access public
     * @param  String $date  Y-m-d formatted date, day of interests
     * @param  string $region
     * @return Array  Array of streams
     */

    public function super8trend($dateStart, $dateEnd, $facility, $region)
    {

        // Perform a calculation and save it into the response (save as a new element in each sub-array of the response object)
        $this->date = $this->provideDateFilter('super8_error_free_per_region', 'date_created');
        $select = DB::select('*')->from('super8_error_free_per_region');
        $select = $this->date->selectByDateRange($dateStart, $dateEnd);
        $select->where('cfacility','like', $facility);
        $select->where('cregion','like', $region);
        $select->order_by('cfacility', 'DESC');
        $select->order_by('cregion', 'DESC');
        $select->order_by('date_created', 'ASC');
        $responseRaw = $this->runQuery($select);
        $responseByFacility = $this->createArrayBucketsByField($responseRaw, 'cfacility');

        //iterate through cregion
        foreach ($responseByFacility as $index => $facility)
        {
            $responseByFacility[$index] = $this->createArrayBucketsByField($facility, 'cregion');
                //iterate through date
                foreach ($responseByFacility[$index] as $index1 => $region)
                {
                    $responseByFacility[$index][$index1] = $this->createArrayBucketsByField($region, 'date_created');
                }
        }

        return $responseByFacility;
    }


            /**
     * Returns $limit worst streams in regions for the supplied date by success_rate, failed count
     */
    public function transcoderregioncontinuity($dateStart, $dateEnd)
    {

        // Query logic
        $this->date = $this->provideDateFilter('transcoder_continuity_error', 'date_created');
        $select = DB::select('*')->from('transcoder_continuity_error');
        $select = $this->date->filterByDateRange($select,$dateStart,$dateEnd);
        $select->order_by('date_created', 'ASC');
        $responseRaw = $this->runQuery($select);
        return $this->createArrayBucketsByField($responseRaw, 'date_created');
    }

                /**
     * Returns $limit worst Transcoder continuity for the supplied date by limit (default 10), success_rate, failed count
     * api/clinear/transcoder/pid/hot/3/2017-05-07
     * api/clinear/transcoder/pid/hot/all/2017-05-07

     *
     * @access public
     * @param  String $date  Y-m-d formatted date, day of interests
     * @param  string $region
     * @return Array  Array of streams
     */

    public function pillarrestart($count, $dateStart, $dateEnd)
    {
//3 table left jion with too many prameters, this way is better
        $select=DB::query("
            select a.date_created, a.cfacility as facility, a.cregion as region, a.restarts as restartCount, b.duration_1 as errorMinutes, c.duration_2 errorMinutesAllStream from comcast_viper_clinear_new.pillar_manual_restart_errorcount a
            left join comcast_viper_clinear_new.pillar_manual_restart_duration b
            on a.date_created=b.date_created and a.cfacility=b.cfacility and a.cregion=b.cregion
            left join comcast_viper_clinear_new.pillar_manual_restart_duration_allstream c on a.date_created=c.date_created and a.cfacility=c.cfacility and a.cregion=c.cregion
            where a.date_created between '$dateStart' and '$dateEnd'
            order by a.date_created asc, a.restarts desc
            limit $count"
        );

        $responseRaw = $this->runQuery($select);
        $response = $this->createArrayBucketsByField($responseRaw, 'date_created');

        // return the response object
        return $response;

    }

    /**
     * Returns varnish cache efficiency
     */

    public function transcoderpidworst10($count, $dateStart, $dateEnd)
    {

        // Query logic
        $this->date = $this->provideDateFilter('transcoder_pid_worst10', 'date_created');
        $select = DB::select('*')->from('transcoder_pid_worst10');
        $select = $this->date->filterByDateRange($select,$dateStart,$dateEnd);
        $select->order_by('date_created', 'ASC');
        $select->order_by('failed', 'DESC');
        $select->limit($count);
        $responseRaw = $this->runQuery($select);
        $responseRaw1 = $this->createArrayBucketsByField($responseRaw, 'date_created');

        //assemble the results
        $response = array(
                   'responseTranscoderHotPid10' => $responseRaw1,
                  );

        // return the response object
        return $response;
    }


        /* Returns regional transcoder pid info for the supplied date by region
     *
     * @access public
     * @param  String $date  Y-m-d formatted date, day of interests
     * @param  string $region
     * @return Array  Array of streams
     */

    public function varnishcache($dateStart, $dateEnd)
    {

        // Perform a calculation and save it into the response (save as a new element in each sub-array of the response object)
        $this->date = $this->provideDateFilter('VarnishRegionalLevelCacheEfficiency', 'date_created');
        $select = DB::select('*')->from('VarnishRegionalLevelCacheEfficiency');
        $select = $this->date->selectByDateRange($dateStart, $dateEnd);
        $select->order_by('date_created', 'ASC');
        // $select->order_by('fail', 'DESC');
        $responseRaw = $this->runQuery($select);
        $response = $this->createArrayBucketsByField($responseRaw, 'date_created');

        return $response;
    }

                /**
     * Returns $limit worst streams in regions for the supplied date by success_rate, failed count */

    public function transcoderpidregion($dateStart, $dateEnd)
    {

        // Query logic
        $this->date = $this->provideDateFilter('transcoder_pid_error', 'date_created');
        $select = DB::select('*')->from('transcoder_pid_error');
        $select = $this->date->filterByDateRange($select,$dateStart,$dateEnd);
        $select->order_by('date_created', 'ASC');
        $select->order_by('successRate', 'ASC');
        $responseRaw = $this->runQuery($select);
        return $this->createArrayBucketsByField($responseRaw, 'date_created');
    }


    public function varnishworststreams($count, $dateStart, $dateEnd)
    {

        // Query logic
        $this->date = $this->provideDateFilter('varnish_nat_worst10', 'date_created');
        $select = DB::select('*')->from('varnish_nat_worst10');
        $select = $this->date->filterByDateRange($select,$dateStart,$dateEnd );
        $select->limit($count);
        $select->order_by('date_created', 'ASC');
        $select->order_by('httperror', 'DESC');
        $responseVarnishHotReg10 = $this->runQuery($select);
        $responseVarnishHotReg10 = $this->createArrayBucketsByField($responseVarnishHotReg10, 'date_created');


        $this->date = $this->provideDateFilter('varnish_reg_worst10', 'date_created');
        $select = DB::select('*')->from('varnish_reg_worst10');
        $select = $this->date->filterByDateRange($select,$dateStart,$dateEnd );
        $select->limit($count);
        $select->order_by('date_created', 'ASC');
        $select->order_by('httperror', 'DESC');
        $responseVarnishHotNat10 = $this->runQuery($select);
        $responseVarnishHotNat10 = $this->createArrayBucketsByField($responseVarnishHotNat10, 'date_created');


        $this->date = $this->provideDateFilter('varnish_worst5_streams', 'date_created');
        $select = DB::select('*')->from('varnish_worst5_streams');
        $select = $this->date->filterByDateRange($select,$dateStart,$dateEnd );
        $select->limit($count);
        $select->order_by('date_created', 'ASC');
        $select->order_by('pcount', 'DESC');
        $responseVarnishHotReg5 = $this->runQuery($select);
        $responseVarnishHotReg5 = $this->createArrayBucketsByField($responseVarnishHotReg5, 'date_created');


        //assemble the results
        $response = array(
                   'NATWorst10' => $responseVarnishHotNat10,
                   'RegWorst10' => $responseVarnishHotReg10,
                   'RegWorst5'  => $responseVarnishHotReg5,
                  );

        // return the response object
        return $response;

    }


        /* Returns regional varnish availability for the supplied date by region
     *
     * @access public
     * @param  String $date  Y-m-d formatted date, day of interests
     * @param  string $region
     * @return Array  Array of streams
     */

    public function transcoderalarmworst10($count, $dateStart, $dateEnd)
    {

        // Query logic
        $this->date = $this->provideDateFilter('transcoder_worst_10_alarms', 'date_created');
        $select = DB::select('*')->from('transcoder_worst_10_alarms');
        $select = $this->date->filterByDateRange($select,$dateStart,$dateEnd);
        $select->limit($count);
        $select->order_by('date_created', 'ASC');
        $select->order_by('alarmNum_sev_012', 'DESC');
        $responseRaw = $this->runQuery($select);
        $responseRaw1 = $this->createArrayBucketsByField($responseRaw, 'date_created');

        //assemble the results
        $response = array(
                   'responseTranscoderHotAlarms10' => $responseRaw1,
                  );

        // return the response object
        return $response;

    }


public function varnishavailability($dateStart, $dateEnd)
    {

        // Query logic
        $this->date = $this->provideDateFilter('varnish_error_free', 'date_created');
        $select = DB::select('*')->from('varnish_error_free');
        $select = $this->date->filterByDateRange($select,$dateStart,$dateEnd);
        $select->order_by('date_created', 'ASC');
        $responseRaw = $this->runQuery($select);
        return $this->createArrayBucketsByField($responseRaw, 'date_created');
    }

            /* Returns regional varnish worst 10 response time for the supplied date by region
     *
     * @access public
     * @param  String $date  Y-m-d formatted date, day of interests
     * @param  string $region
     * @return Array  Array of streams
     */
public function varnishworst10responsetime($dateStart, $dateEnd)
    {

        // Query logic
        $this->date = $this->provideDateFilter('Varnishworst10channelswithresponsetime', 'date_created');
        $select = DB::select('*')->from('Varnishworst10channelswithresponsetime');
        $select = $this->date->filterByDateRange($select,$dateStart,$dateEnd);
        $select->order_by('date_created', 'ASC');
        $select->order_by('CountTimes', 'DESC');
        $responseRaw = $this->runQuery($select);
        return $this->createArrayBucketsByField($responseRaw, 'date_created');
    }

}


