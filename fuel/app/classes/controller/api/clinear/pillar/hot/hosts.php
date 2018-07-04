<?php
/**
 * The API Controller for cLinear data.
 *
 * Responds to requests made programmatically for cLinear production data reports
 *
 * @package app
 * @extends Controller
 */
class Controller_API_cLinear_Pillar_Hot_Hosts extends Controller_API
{

    /**
     * Return api response with n worst cox hosts for the date or date range given
     * /api/clinear/pillar/hot/hosts/cox/(/:count)?(/:start)?(/:end)?
     * @access public
     * @param  Int    $count number of worst hosts to provide, default 10
     * @param  String $date  Y-m-d formatted date of interest, default yesterday
     * @return Response
     */
    public function get_cox($count = null, $dateStart = null, $dateEnd = null)
    {
        // Process parameters
        $count      = $this->ingestParameter($count, 10);

        // Generate data from metric
        $metric = new Metric_Watermark();
        $data = $metric->cox($count, $dateStart, $dateEnd);

        // Set response data
        $this->setResponse('data',   $data);
        $this->setResponse('start',  $dateStart);
        $this->setResponse('end',    $dateEnd);
        $this->setResponse('count',  $count);

        // Forge and return response
        return $this->forgeResponse();
    }



}
