ge<?php
/**
 * The API Controller for cLinear data.
 *
 * Responds to requests made programmatically for cLinear production data reports
 *
 * @package app
 * @extends Controller
 */
class Controller_API_cLinear_Pillar_restarts extends Controller_API
{


    // public function get_cox()
    // {
    //     // Call presenter/api/clinear/pillar/restarts/cox.php and invoke the view() function, then revert to views/api/response.php, send HTTP code 200 (OK)
    //     return Response::forge(Presenter::forge('api/clinear/pillar/restarts/cox', 'view', NULL, 'api/response'), 200, array('Content-Type','application/json'));
    // }


    /**
     * Return api response with 100 worst streams at the varnish component for the date or date range given
     * /api/clinear/pillar/hot/streams/comcast/(/:count)?(/:start)?(/:end)?
     * @access public
     * @param  Int    $count number of worst hosts to provide, default 10
     * @param  String $date  Y-m-d formatted date of interest, default yesterday
     * @return Response
     */
    public function get_cox($count = null, $dateStart = null, $dateEnd = null)
    {
        // Process parameters
        $count      = $this->ingestParameter($count, 100);
        $dateStart  = $this->ingestDate($dateStart, 0);
        $dateEnd    = $this->ingestDate($dateEnd, $dateStart);

        // Generate data from metric
        $metric = new Metric_ComcastViperWatermarkNew();
        $data = $metric->restartsCox($count, $dateStart, $dateEnd);

        // Set response data
        $this->setResponse('data',   $data);
        $this->setResponse('start',  $dateStart);
        $this->setResponse('end',    $dateEnd);
        $this->setResponse('count',  $count);

        $this->setResponse('data', $data['data']);
        $this->setResponse('histogramData1', $data['histogramData1']);


        // Forge and return response
        return $this->forgeResponse();
    }

    /**
     * Return api response with n worst comcast streams for the date or date range given
     * /api/clinear/super8/trending/comcast/2017-08-15
     * @access public
     * @param  Int    $count number of worst hosts to provide, default 10
     * @param  String $date  Y-m-d formatted date of interest, default yesterday
     * @return Response
     */
    public function get_comcast($count = null, $dateStart = null, $dateEnd = null)
    {
        // Process parameters
        $count     = $this->ingestParameter($count, 10);
        $dateStart = $this->ingestDate($dateStart,0);
        $dateEnd   = $this->ingestDate($dateEnd, $dateStart);

        // Generate data from metric
        $metric = new Metric_ComcastVipercLinearNew();
        $data = $metric-> pillarrestart($count, $dateStart, $dateEnd);

        // Set response data
        $this->setResponse('data', $data);

        // Forge and return response
        return $this->forgeResponse();
    }

    /**
     * Return api response with 10 worst cox streams at the pillar component for the date or date range given
     * /api/clinear/pillar/restarts/coxworst10/100/2017-07-08/2017-08-08
     * @access public
     * @param  String $date  Y-m-d formatted date of interest, default today
     * @return Response
     */
    public function get_coxworst10($count = null, $dateStart = null, $dateEnd = null)
    {
        // Process parameters
        $count      = $this->ingestParameter($count, 100);
        $dateStart  = $this->ingestDate($dateStart, 0);
        $dateEnd    = $this->ingestDate($dateEnd, $dateStart);

        // Generate data from metric
        $metric = new Metric_ComcastViperWatermarkNew();
        $data = $metric->coxWorst10Restarts($count, $dateStart, $dateEnd);

        // Set response data
        $this->setResponse('data',   $data);
        $this->setResponse('start',  $dateStart);
        $this->setResponse('end',    $dateEnd);
        $this->setResponse('count',  $count);

        // Forge and return response
        return $this->forgeResponse();
    }

}

