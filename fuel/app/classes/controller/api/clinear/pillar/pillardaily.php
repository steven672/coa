<?php
/**
 * The API Controller for daily pillar report data.
 *
 * Responds to requests made programmatically for pillar data reports
 *
 * @package app
 * @extends Controller_API
 */
class Controller_API_cLinear_Pillar_Pillardaily extends Controller_API
{

    /**
     * Return api response with player global success and availability trend from dateStart to dateEnd
     *
     * @access public
     * @param  String $start Y-m-d formatted date start of range, default today
     * @param  String $start   Y-m-d formatted date end of range, default 7 days ago
     * @return Response
     */
    public function get_panicscause($start = null, $end = null)
    {
        // Process parameters
        $start = $this->ingestDate($start, 7);
        $end = $this->ingestDate($end, 0);

        // Generate data from metric
        $metric = new Metric_pillar();
        $panics = $metric->panicscause($start, $end);

        // Set response data
        $this->setResponse('data', $panics);
        $this->setResponse('start', $start);
        $this->setResponse('end', $end);

        // Forge and return response
        return $this->forgeResponse();
    }

}
