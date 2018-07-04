<?php
/**
 * The API Controller for cLinear data.
 *
 * Responds to requests made programmatically for cLinear production data reports
 *
 * @package app
 * @extends Controller
 */
class Controller_API_cLinear_Super8_Trending extends Controller_API
{


        /**
     * Return api response with n worst comcast streams for the date or date range given
     * /api/clinear/super8/trending/comcast/2017-08-15
     * @access public
     * @param  Int    $count number of worst hosts to provide, default 10
     * @param  String $date  Y-m-d formatted date of interest, default yesterday
     * @return Response
     */
    public function get_comcast($dateStart = null, $dateEnd = null, $facility = null, $region = null)
    {
        // Process parameters
        $dateStart = $this->ingestDate($dateStart, 0);
        $dateEnd   = $this->ingestDate($dateEnd, $dateStart);
        $facility  = $this->ingestParameter($facility, 'all');
        $region    = $this->ingestParameter($region, 'all');


        // Generate data from metric
        $metric = new Metric_ComcastVipercLinearNew();
        $data = $metric->super8trend( $dateStart, $dateEnd, $facility, $region);

        // Set response data
        $this->setResponse('data', $data);

        // Forge and return response
        return $this->forgeResponse();
    }



}
