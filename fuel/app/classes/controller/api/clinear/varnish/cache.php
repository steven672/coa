<?php
/**
 * The API Controller for cLinear data.
 *
 * Responds to requests made programmatically for cLinear production data reports
 *
 * @package app
 * @extends Controller
 */
class Controller_API_cLinear_Varnish_Cache extends Controller_API
{

            /**
     * the date or date range given
     *api/clinear/varnish/cache/efficiency
     * @access public
     * @param  Int    $count number of worst hosts to provide, default 10
     * @param  String $date  Y-m-d formatted date of interest, default yesterday
     * @return Response
     */
    public function get_efficiency($dateStart = null, $dateEnd = null)
    {
        // Process parameters
        $dateStart = $this->ingestDate($dateStart,0);
        $dateEnd   = $this->ingestDate($dateEnd, $dateStart);

        // Generate data from metric
        $metric = new Metric_ComcastVipercLinearNew();
        $data = $metric-> varnishcache($dateStart, $dateEnd);

        // Set response data
        $this->setResponse('data', $data);

        // Forge and return response
        return $this->forgeResponse();
    }


}
