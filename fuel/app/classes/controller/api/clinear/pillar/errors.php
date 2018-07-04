<?php
/**
 * The API Controller for daily pillar report data.
 *
 * Responds to requests made programmatically for pillar data reports
 *
 * @package app
 * @extends Controller_API
 */
class Controller_API_cLinear_Pillar_Errors extends Controller_API
{

    /**
     * Return api response with regions whose daily pillar error count is zero
     *
     * @access public
     * @param  String $start Y-m-d formatted date start of range, default today
     * @param  String $start   Y-m-d formatted date end of range, default 7 days ago
     * @return Response
     */
    public function get_errorfree($date = null)
    {
        // Process parameters
        $start = $this->ingestDate($date);
        // $end = $this->ingestDate($end, 0);

        // Generate data from metric
        $metric = new Metric_pillar_clinear();
        $errors = $metric->errorfree($date);

        // Set response data
        $this->setResponse('data', $errors);
        $this->setResponse('date', $date);

        // Forge and return response
        return $this->forgeResponse();
    }

}
