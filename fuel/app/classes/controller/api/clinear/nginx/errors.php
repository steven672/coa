<?php
/**
 * The API Controller for player data.
 *
 * Responds to requests made programmatically for playere data reports
 *
 * @package app
 * @extends Controller_API
 */
class Controller_Api_Clinear_Nginx_Errors extends Controller_API
{

    /**
     * Return api response with pillar availability trend from dateStart to dateEnd
     *
     * @access public
     * @param  String $start Y-m-d formatted date start of range, default today
     * @param  String $start   Y-m-d formatted date end of range, default 7 days ago
     * @return Response
     */
    public function get_non200($start = null, $end = null)
    {
        // Process parameters
        $start = $this->ingestDate($start, 0);
        $end = $this->ingestDate($end, 0);

        // Generate data from metric
        $metric = new Metric_Clinear_Nginx_Errors_Non200();
        $non200 = $metric->non200($start, $end);

        // Set response data
        $this->setResponse('data', $non200);
        $this->setResponse('start', $start);
        $this->setResponse('end', $end);

        // Forge and return response
        return $this->forgeResponse();
    }


        /**
     * Return api response with pillar worst 10 streams from dateStart to dateEnd
     *
     * @access public
     * @param  String $start Y-m-d formatted date start of range, default today
     * @param  String $start   Y-m-d formatted date end of range, default 7 days ago
     * @return Response
     */
    public function get_availability($start = null, $end = null)
    {
        // Process parameters
        $start = $this->ingestDate($start, 0);
        $end = $this->ingestDate($end, 0);

        // Generate data from metric
        $metric = new Metric_Clinear_Nginx_Errors_Availability();
        $availability = $metric->availability($start, $end);

        // Set response data
        $this->setResponse('data', $availability);
        $this->setResponse('start', $start);
        $this->setResponse('end', $end);

        // Forge and return response
        return $this->forgeResponse();
    }

}
