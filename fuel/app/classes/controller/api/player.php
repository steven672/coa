<?php
/**
 * The API Controller for player data.
 *
 * Responds to requests made programmatically for playere data reports
 *
 * @package app
 * @extends Controller_API
 */
class Controller_API_Player extends Controller_API
{

    /**
     * Return api response with player global success and availability trend from dateStart to dateEnd
     *
     * @access public
     * @param  String $start Y-m-d formatted date start of range, default today
     * @param  String $start   Y-m-d formatted date end of range, default 7 days ago
     * @return Response
     */
    public function get_overallavailability($start = null, $end = null)
    {
        // Process parameters
        $start = $this->ingestDate($start, 7);
        $end = $this->ingestDate($end, 0);

        // Generate data from metric
        $metric = new Metric_Headwaters();
        $availability = $metric->overallAvailability($start, $end);

        // Set response data
        $this->setResponse('data', $availability);
        $this->setResponse('start', $start);
        $this->setResponse('end', $end);

        // Forge and return response
        return $this->forgeResponse();
    }

    /**
     * Return api response with n worst streams for date
     *
     * @access public
     * @param  Int    $count number of worst streams to provide, default 10
     * @param  String $date  Y-m-d formatted date of interest, default yesterday
     * @return Response
     */
    public function get_worststreams($count = null, $date = null)
    {
        // Process parameters
        $count = $this->ingestParameter($count, 10);
        $date = $this->ingestDate($date, 1);

        // Generate data from metric
        $metric = new Metric_Headwaters();
        $worst = $metric->worstStreams($date, $count);

        // Set response data
        $this->setResponse('data', $worst);
        $this->setResponse('date', $date);
        $this->setResponse('count', $count);

        // Forge and return response
        return $this->forgeResponse();
    }

    /**
     * Return api response with player success trend from dateStart to dateEnd
     *
     * @access public
     * @param  String $dateStart Y-m-d formatted date start of range, default today
     * @param  String $dateEnd   Y-m-d formatted date end of range, default 7 days ago
     * @return Response
     */
    public function get_trendregion($dateStart = null, $dateEnd = null)
    {
        // Process parameters
        $dateStart = $this->ingestDate($dateStart, 7);
        $dateEnd = $this->ingestDate($dateEnd);

        //Generate data metric
        $metric = new Metric_Headwaters();
        $trend = $metric->trendRegion($dateStart, $dateEnd);

        // Set response data
        $this->setResponse('data', $trend);
        $this->setResponse('start', $dateStart);
        $this->setResponse('end', $dateEnd);

        // Forge and return response
        return $this->forgeResponse();
    }
}
