<?php
/**
 * The API Controller for cLinear data.
 *
 * Responds to requests made programmatically for cLinear production data reports
 *
 * @package app
 * @extends Controller
 */
class Controller_API_cLinear_Super8_Hot_Streams extends Controller_API
{


    /**
     * Return api response with 100 worst streams at the super8 component for the date or date range given
     * /api/clinear/pillar/hot/streams/comcast/(/:count)?(/:start)?(/:end)?
     * @access public
     * @param  Int    $count number of worst hosts to provide, default 10
     * @param  String $date  Y-m-d formatted date of interest, default yesterday
     * @return Response
     */
    public function get_worst100($count = null, $dateStart = null, $dateEnd = null)
    {
        // Process parameters
        $count      = $this->ingestParameter($count, 100);
        $dateStart  = $this->ingestDate($dateStart, 0);
        $dateEnd    = $this->ingestDate($dateEnd, $dateStart);

        // Generate data from metric
        $metric = new Metric_VopsDataCube();
        $data = $metric->worst100Super8($count, $dateStart, $dateEnd);

        // Set response data
        $this->setResponse('data',   $data);
        $this->setResponse('start',  $dateStart);
        $this->setResponse('end',    $dateEnd);
        $this->setResponse('count',  $count);

        // Forge and return response
        return $this->forgeResponse();
    }



}
