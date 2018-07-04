<?php
/**
 * The API Controller for cLinear data.
 *
 * Responds to requests made programmatically for cLinear production data reports
 *
 * @package app
 * @extends Controller
 */
class Controller_API_Clinear_Super8_Hot_Error extends Controller_API
{

    /**
     * Return api response with 3 worst error codes per region at the super8 component for the date or date range given
     * api/clinear/super8/hot/error/codes/(/:start)?(/:end)?
     * @access public
     * @param  Int    $count number of worst hosts to provide, default 10
     * @param  String $date  Y-m-d formatted date of interest, default yesterday
     * @return Response
     */
    public function get_codes($start = null, $end = null)
    {
        // Process parameters
        $start = $this->ingestDate($start, 0);
        $end = $this->ingestDate($end, 0);

        // Generate data from metric
        $metric = new Metric_Clinear_Super8_Hot_Error_Codes();
        $codes = $metric->codes($start, $end);

        // Set response data
        $this->setResponse('data', $codes);
        $this->setResponse('start', $start);
        $this->setResponse('end', $end);

        // Forge and return response
        return $this->forgeResponse();
    }

}
