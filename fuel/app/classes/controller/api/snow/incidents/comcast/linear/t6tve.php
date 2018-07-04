<?php
/**
 * The API Controller for player data.
 *
 * Responds to requests made programmatically for playere data reports
 *
 * @package app
 * @extends Controller_API
 */
class Controller_Api_Snow_Incidents_Comcast_Linear_T6tve extends Controller_API
{

    /**
     * Return api response with pillar availability trend from dateStart to dateEnd
     *
     * @access public
     * @param  String $start Y-m-d formatted date start of range, default today
     * @param  String $start   Y-m-d formatted date end of range, default 7 days ago
     * @return Response
     */
    public function get_impactedservices($start = null, $end = null)
    {
        // Process parameters
        $start = $this->ingestDate($start, 0);
        $end = $this->ingestDate($end, 0);

        // Generate data from metric
        $metric = new Metric_Snow_Incidents_Comcast_Linear_T6tve_Impactedservices();
        $impactedservices = $metric->impactedservices($start, $end);

        // Set response data
        $this->setResponse('data', $impactedservices);
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
    public function get_elements($start = null, $end = null)
    {
        // Process parameters
        $start = $this->ingestDate($start, 0);
        $end = $this->ingestDate($end, 0);

        // Generate data from metric
        $metric = new Metric_Snow_Incidents_Comcast_Linear_T6tve_Elements();
        $elements = $metric->elements($start, $end);

        // Set response data
        $this->setResponse('data', $elements);
        $this->setResponse('start', $start);
        $this->setResponse('end', $end);

        // Forge and return response
        return $this->forgeResponse();
    }

}
