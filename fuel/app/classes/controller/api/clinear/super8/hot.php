<?php
/**
 * The API Controller for cLinear data.
 *
 * Responds to requests made programmatically for cLinear production data reports
 *
 * @package app
 * @extends Controller
 */
class Controller_API_cLinear_Super8_Hot extends Controller_API
{

    // public function get_cox()
    // {
    //     // Call presenter/api/clinear/super8/hot.php and invoke the view() function, then revert to views/api/response.php, send HTTP code 200 (OK)
    //     return Response::forge(Presenter::forge('api/clinear/super8/hot/cox', 'view', NULL, 'api/response'), 200, array('Content-Type','application/json'));
    // }

        /**
     * Return api response with n worst comcast streams for the date or date range given
     * api/clinear/super8/availability/comcast/(/:start)?(/:end)?
     * @access public
     * @param  Int    $count number of worst hosts to provide, default 10
     * @param  String $date  Y-m-d formatted date of interest, default yesterday
     * @return Response
     */
    public function get_comcast($count = null, $dateStart = null, $dateEnd = null)
    {
        // Process parameters
        $count     = $this->ingestParameter($count, 10);
        $dateStart = $this->ingestDate($dateStart, 0);
        $dateEnd   = $this->ingestDate($dateEnd, $dateStart);

        // Generate data from metric
        $metric = new Metric_ComcastVipercLinearNew();
        $data = $metric->super8worst10($count, $dateStart, $dateEnd);

        // Set response data
        $this->setResponse('data', $data);

        // Forge and return response
        return $this->forgeResponse();
    }

            /**
     * Return api response with n worst comcast streams for the date or date range given
     * api/clinear/super8/hot/cox/10/(/:start)?(/:end)?
     * @access public
     * @param  Int    $count number of worst hosts to provide, default 10
     * @param  String $date  Y-m-d formatted date of interest, default yesterday
     * @return Response
     */
    public function get_cox($count = null, $dateStart = null, $dateEnd = null)
    {
        // Process parameters
        $count     = $this->ingestParameter($count, 10);
        $dateStart = $this->ingestDate($dateStart, 0);
        $dateEnd   = $this->ingestDate($dateEnd, $dateStart);

        // Generate data from metric
        $metric = new Metric_ComcastViperWatermarkNew();
        $data = $metric->coxsuper8worst10($count, $dateStart, $dateEnd);

        // Set response data
        $this->setResponse('data', $data);

        // Forge and return response
        return $this->forgeResponse();
    }



}
