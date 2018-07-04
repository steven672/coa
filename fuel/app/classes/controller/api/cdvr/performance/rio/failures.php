<?php
/**
 * The API Controller for recording failures by rio market
 *
 * Responds to requests made programmatically for cDVR production data reports
 *
 * @package app
 * @extends Controller
 */
class Controller_API_cDVR_Performance_Rio_Failures extends Controller_API
{

    /**
     * Return failures per dash origin component data
     *
     * @access public
     * @return Response
     */
    public function get_dashorigin()
    {
        // Call presenter/api/cdvr/performance/rio/failures/markets.php and invoke the view() function, then revert to views/api/response.php, send HTTP code 200 (OK)
        return Response::forge(Presenter::forge('api/cdvr/performance/rio/failures/dashorigin', 'view', NULL, 'api/response'), 200, array('Content-Type','application/json'));
    }

    /**

     * Return failures per error code data
     * @param  Int    $count number of worst streams to provide, default 10
     * @param  String $date  Y-m-d formatted date of interest, default yesterday
     * @access public
     * @return Response
     */

    public function get_errorcodes($count = null, $date = null)
    {
        // Process parameters
        $count = $this->ingestParameter($count, 10);
        $date  = $this->ingestDate($date, 1);

        // Generate data from metric
        $metric = new Metric_Rio();
        $worst = $metric->errorcodes($date, $count);

        // Set response data
        $this->setResponse('data', $worst);
        $this->setResponse('date', $date);
        $this->setResponse('count', $count);

        // Forge and return response
        return $this->forgeResponse();

    }

    /**
      * Return api response with the Worst 10 Hosts by Recording Failures
      *
      * @access public
      * @param  Int    $count number of worst streams to provide, default 10
      * @param  String $date  Y-m-d formatted date of interest, default yesterday
      * @return Response
     */
    public function get_hosts($count = null, $date = null)
    {
        // Process parameters
        $count = $this->ingestParameter($count, 10);
        $date = $this->ingestDate($date, 1);

        // Generate data from metric
        $metric = new Metric_cDVR_Performance_Rio_Failures();
        $worst = $metric->hosts($date, $count);


        // Set response data
        $this->setResponse('data', $worst);
        $this->setResponse('date', $date);
        $this->setResponse('count', $count);

        // Forge and return response
        return $this->forgeResponse();
    }

    /**
      * Return api response with the Worst 10 Hosts by Recording Failures
      *
      * @access public
      * @param  String $dateStart  Y-m-d formatted date of interest, default today
      * @param  String $dateEnd    Y-m-d formatted date of interest, default today
      * @param  String $region     Rio region of interest, default % (all)
      * @return Response
     */
    public function get_markets($dateStart = null, $dateEnd = null, $region = null)
    {
        // Process parameters
        $dateStart = $this->ingestDate($dateStart);
        $dateEnd = $this->ingestDate($dateEnd, $dateStart);
        $region = $this->ingestParameter($region);

        // Generate data from metric
        $metric = new Metric_cDVR_Performance_Rio_Failures();
        $markets = $metric->getMarkets($dateStart, $dateEnd, $region);


        // Set response data
        $this->setResponse('data', $markets['data']);
        $this->setResponse('totalRecordingsSummed', $markets['totalRecordingsSummed']);
        $this->setResponse('failuresSummed', $markets['failuresSummed']);
        $this->setResponse('successRate', $markets['successRate']);
        $this->setResponse('failureRate', $markets['failureRate']);

        // Forge and return response
        return $this->forgeResponse();
    }

    /**
     * Return failures per segment recorder component data
     *
     * @access public
     * @return Response
     */
    public function get_segmentrecorder()
    {
        // Call presenter/api/cdvr/performance/rio/failures/markets.php and invoke the view() function, then revert to views/api/response.php, send HTTP code 200 (OK)
        return Response::forge(Presenter::forge('api/cdvr/performance/rio/failures/segmentrecorder', 'view', NULL, 'api/response'), 200, array('Content-Type','application/json'));
    }

    /**
     * Return failures for the super8 rio component
     *
     * @access public
     * @return Response
     */
    public function get_super8()
    {
        // Call presenter/api/cdvr/performance/rio/failures/markets.php and invoke the view() function, then revert to views/api/response.php, send HTTP code 200 (OK)
        return Response::forge(Presenter::forge('api/cdvr/performance/rio/failures/super8', 'view', NULL, 'api/response'), 200, array('Content-Type','application/json'));
    }


    public function get_worst5streamswith5market($region = null, $datestart = null, $dateend = null)
    {
        // Process parameters
        $region     = $this->ingestParameter($region);
        $dateStart  = $this->ingestDate($datestart, 0);
        $dateEnd    = $this->ingestDate($dateend, $datestart);

        //Generate data from metric
        $metric = new Metric_cDVR_Performance_Rio_Failures();
        $worst = $metric->getWorst5StreamsWith5Market($dateStart, $dateEnd, $region);

        //Set response data
        $this->setResponse('data',          $worst);
        $this->setResponse('dateStart',     $dateStart);
        $this->setResponse('dateEnd',       $dateEnd);
        $this->setResponse('region',        $region);

        // Forge and return response
        return $this->forgeResponse();
    }



}
