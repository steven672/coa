<?php
/**
 * The API Controller for cLinear data.
 *
 * Responds to requests made programmatically for cLinear production data reports
 *
 * @package app
 * @extends Controller
 */
class Controller_API_cLinear_Super8_Errors extends Controller_API
{
    /**
     * Return api response top 10 errors for the super8 component for the date or date range given
     * /api/clinear/super8/errors/top/(/:count)?(/:start)?(/:end)?
     * @access public
     * @param  Int    $count number of worst hosts to provide, default 10
     * @param  String $date  Y-m-d formatted date of interest, default yesterday
     * @return Response
     */
    public function get_top($count = null, $dateStart = null, $dateEnd = null)
    {
        // Process parameters
        $count      = $this->ingestParameter($count, 10);
        $dateStart  = $this->ingestDate($dateStart, 0);
        $dateEnd    = $this->ingestDate($dateEnd, $dateStart);

        // Generate data from metric
        $metric = new Metric_super8Daily();
        $data = $metric->super8top($count, $dateStart, $dateEnd);

        // Set response data
        $this->setResponse('data',   $data);

        // Forge and return response
        return $this->forgeResponse();
    }


}
