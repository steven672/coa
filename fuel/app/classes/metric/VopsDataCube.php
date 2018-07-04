<?php
/**
 *
 * @package app
 */
class Metric_VopsDataCube extends Metric_Base
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
     * @return String 'vops_data_cube'
     */
    protected function getConnection()
    {
        return 'vops_data_cube';
    }


    /**
     * Generates data for the worst 100 streams at pillar
     *
     * @access public
     * @param  String $dateStart Y-m-d formatted date, beginning date of range
     * @param  String $dateEnd   Y-m-d formatted date, end date of range
     * @return Array  Array of daily availability grouped by date
     */
    public function worst100Pillar($count, $dateStart, $dateEnd)
    {
        $dateStart = str_replace('-','', $dateStart);

        $select = DB::query("SELECT STREAM, DATE_KEY,
        SUM(ERROR_COUNT) AS 'ERRORS PER HOUR',
        (1 - SUM(ERROR_COUNT)/COUNT(ERROR_COUNT)) AS 'HOURLY AVAILABILITY',
        HOUR_KEY
        FROM vops_data_cube.W_PILLAR_WORST100_STREAMS_A
        WHERE DATE_KEY = '$dateStart'
        GROUP BY STREAM, HOUR_KEY;");

        $data = $this->runQuery($select);

        $dataByHour = $this->createArrayBucketsByField($data, 'HOUR_KEY');

        // Calculate the total amount of minutes with errors for the 100 stream on an hourly basis - return a 24 element array.
        $totalErrorsPerHour = array();
        foreach ($dataByHour as $key => $value) {

            $totalErrorsPerHour[$key] = array(
                'availability' => 100 - ((array_sum(array_map(function ($i) { return $i['ERRORS PER HOUR']; }, $value))) / count($value)),
                'hour' => $key
            );
        }

        $totalErrorsPerHour = $this->sortBySubValue($totalErrorsPerHour, 'hour');

        return $totalErrorsPerHour;

    }


    /**
     * Generates data for the worst 100 streams at super8
     *
     * @access public
     * @param  String $dateStart Y-m-d formatted date, beginning date of range
     * @param  String $dateEnd   Y-m-d formatted date, end date of range
     * @return Array  Array of daily availability grouped by date
     */
    public function worst100Super8($count, $dateStart, $dateEnd)
    {

        $dateStart = str_replace('-','', $dateStart);

        $select = DB::query("SELECT STREAM, DATE_KEY, SUM(TOTAL) AS TOTAL,
        SUM(SUCCESS_COUNT) AS 'SUCCESSES PER HOUR',
        (1 - SUM(SUCCESS_COUNT)/COUNT(SUCCESS_COUNT)) AS 'HOURLY AVAILABILITY',
        HOUR_KEY
        FROM vops_data_cube.W_SUPER8_WORST100_STREAMS_A
        WHERE DATE_KEY = '$dateStart'
        GROUP BY STREAM, HOUR_KEY;");

        $data = $this->runQuery($select);

        $dataByHour = $this->createArrayBucketsByField($data, 'HOUR_KEY');

        // Calculate the total amount of minutes with errors for the 100 stream on an hourly basis - return a 24 element array.
        $totalErrorsPerHour = array();
        foreach ($dataByHour as $key => $value) {

            $totalErrorsPerHour[$key] = array(
                'availability' => 1 - (array_sum(array_map(function ($i) { return $i['SUCCESSES PER HOUR']; }, $value))) / (array_sum(array_map(function ($i) { return $i['TOTAL']; }, $value))),
                'hour' => $key
            );
        }

        $totalErrorsPerHour = $this->sortBySubValue($totalErrorsPerHour, 'hour');

        return $totalErrorsPerHour;

    }


    /**
     * Generates data for the worst 100 streams at varnish
     *
     * @access public
     * @param  String $dateStart Y-m-d formatted date, beginning date of range
     * @param  String $dateEnd   Y-m-d formatted date, end date of range
     * @return Array  Array of daily availability grouped by date
     */
    public function worst100Varnish($count, $dateStart, $dateEnd)
    {
        $dateStart = str_replace('-','', $dateStart);

        $select = DB::query("SELECT STREAM, DATE_KEY, SUM(TOTAL) AS TOTAL,
        SUM(COUNT) AS 'ERRORS PER HOUR',
        (1 - SUM(COUNT)/COUNT(COUNT)) AS 'HOURLY AVAILABILITY',
        HOUR_KEY
        FROM vops_data_cube.W_VARNISH_WORST100_STREAMS_A
        WHERE DATE_KEY = '$dateStart'
        GROUP BY STREAM, HOUR_KEY;");

        $data = $this->runQuery($select);

        $dataByHour = $this->createArrayBucketsByField($data, 'HOUR_KEY');

        // Calculate the total amount of minutes with errors for the 100 stream on an hourly basis - return a 24 element array.
        $totalErrorsPerHour = array();
        foreach ($dataByHour as $key => $value) {

            $totalErrorsPerHour[$key] = array(
                'availability' => 1 - (array_sum(array_map(function ($i) { return $i['ERRORS PER HOUR']; }, $value))) / (array_sum(array_map(function ($i) { return $i['TOTAL']; }, $value))),
                'hour' => $key
            );
        }

        $totalErrorsPerHour = $this->sortBySubValue($totalErrorsPerHour, 'hour');

        return $totalErrorsPerHour;

    }

        /**
     * Generates data for the worst 100 streams at varnish
     *
     * @access public
     * @param  String $dateStart Y-m-d formatted date, beginning date of range
     * @param  String $dateEnd   Y-m-d formatted date, end date of range
     * @return Array  Array of daily availability grouped by date
     */
    public function playerregionerror($count, $dateStart, $dateEnd)
    {
        // Query logic starts here, cs,
        $this->date = $this->provideDateFilter('W_HW_REGION_DAILY_A', 'DATE_KEY');
        $expr       = DB::expr("DATE_FORMAT(date_key,'%Y-%m-%d') AS DATE_KEY");
        $select     = DB::select('*',$expr)->from('W_HW_REGION_DAILY_A');
        $select = $this->date->filterByDateRange($select, $dateStart, $dateEnd);
        $select->limit($count);
        $select->order_by('DATE_KEY', 'ASC');
        $select->order_by('FAILED', 'DESC');
        $responseRaw = $this->runQuery($select);
        $responseRaw1 = $this->createArrayBucketsByField($responseRaw, 'DATE_KEY');

        $response = array(
                            'responsePlayerX2Hot' => $responseRaw1,
                          );
        return $response;

    }


}

