<?php
/**
 * The API Controller for cLinear data.
 *
 * Responds to requests made programmatically for cLinear production data reports
 *
 * @package app
 * @extends Controller
 */
class Controller_API_cLinear_Varnish extends Controller_API
{


        /**
     * Return api response with n worst comcast streams at varnish for the date or date range given
     * /api/clinear/varnish/availability/(/:count)?(/:start)?(/:end)?
     * @access public
     * @param  Int    $count number of worst hosts to provide, default 10
     * @param  String $date  Y-m-d formatted date of interest, default yesterday
     * @return Response
     */
    public function get_hot($count = null, $dateStart = null, $dateEnd = null)
    {
        // Process parameters
        $count      = $this->ingestParameter($count, 10);
        $dateStart  = $this->ingestDate($dateStart, 0);
        $dateEnd    = $this->ingestDate($dateEnd, $dateStart);

        // Generate data from metric
        $metric = new Metric_ComcastVipercLinearNew();
        $data = $metric->varnishworststreams($count, $dateStart, $dateEnd);

        // Set response data
        $this->setResponse('data',   $data);

        // Forge and return response
        return $this->forgeResponse();
    }





    /**
     * the date or date range given
     * /api/clinear/varnish/availability
     * /api/clinear/varnish/availability/2017-08-05/2017-08-08
     * @access public
     * @param  Int    $count number of worst hosts to provide, default 10
     * @param  String $date  Y-m-d formatted date of interest, default yesterday
     * @return Response
     */
    public function get_availability($dateStart = null, $dateEnd = null)
    {
        // Process parameters
        $dateStart = $this->ingestDate($dateStart, 0);
        $dateEnd   = $this->ingestDate($dateEnd, $dateStart);

        // Generate data from metric
        $metric = new Metric_ComcastVipercLinearNew();
        $data = $metric-> varnishavailability($dateStart, $dateEnd);

        // Set response data
        $this->setResponse('data', $data);

        // Forge and return response
        return $this->forgeResponse();
    }




    /**
     * the date or date range given
     * /api/clinear/varnish/worst10responsetime
     * /api/clinear/varnish/worst10responsetime/2017-05-15
     * @access public
     * @param  String $date  Y-m-d formatted date of interest, default yesterday
     * @return Response
     */
    public function get_worst10responsetime($dateStart = null, $dateEnd = null)
    {
        // Process parameters
        $dateStart = $this->ingestDate($dateStart, 0);
        $dateEnd   = $this->ingestDate($dateEnd,$dateStart);

        // Generate data from metric
        $metric = new Metric_ComcastVipercLinearNew();
        $data = $metric-> varnishworst10responsetime($dateStart, $dateEnd);

        // Set response data
        $this->setResponse('data', $data);

        // Forge and return response
        return $this->forgeResponse();
    }




    /**
     * Return api response with 100 worst streams at the varnish component for the date or date range given
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
        $data = $metric->worst100Varnish($count, $dateStart, $dateEnd);

        // Set response data
        $this->setResponse('data',   $data);
        $this->setResponse('start',  $dateStart);
        $this->setResponse('end',    $dateEnd);
        $this->setResponse('count',  $count);

        // Forge and return response
        return $this->forgeResponse();
    }


            public function get_regionalresponsetimeavg()
    {
        // Call presenter/api/clinear/varnish/availability.php and invoke the view() function, then revert to views/api/response.php, send HTTP code 200 (OK)
        return Response::forge(Presenter::forge('api/clinear/varnish/regionalresponsetimeavg', 'view', NULL, 'api/response'), 200, array('Content-Type','application/json'));
    }


}

