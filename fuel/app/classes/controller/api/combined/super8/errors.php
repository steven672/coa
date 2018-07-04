<?php
/**
 * The API Controller for viper data.
 *
 * Responds to requests made programmatically for cLinear production data reports
 *
 * @package app
 * @extends Controller
 */
class Controller_API_Combined_Super8_Errors extends Controller_API
{

    /**
     * Return duplicates data
     *
     * @access public
     * @return Response
     */
    public function get_summary()
    {
        // Call presenter /api/combined/super8/errors/summary.php and invoke the view() function, then revert to views/api/response.php, send HTTP code 200 (OK)
        return Response::forge(Presenter::forge('api/combined/super8/errors/summary', 'view', NULL, 'api/response'), 200, array('Content-Type','application/json'));
    }


        /**
     * the date or date range given
     * api/combined/super8/errors/cdvr/
     * api/combined/super8/errors/cdvr/2017-08-05/2017-08-08
     * @access public
     * @param  String $date  Y-m-d formatted date of interest, default yesterday
     * @return Response
     */
    public function get_cdvr($dateStart = null, $dateEnd = null)
    {
        // Process parameters
        $dateStart = $this->ingestDate($dateStart, 0);
        $dateEnd   = $this->ingestDate($dateEnd, $dateStart);

        // Generate data from metric
        $metric = new Metric_Clinear_Super8_Hot_Error_Codes();
        $data = $metric-> super8errorscdvr($dateStart, $dateEnd);

        // Set response data
        $this->setResponse('data', $data);

        // Forge and return response
        return $this->forgeResponse();
    }



    // get clinear data
        /**
     * the date or date range given
     * api/combined/super8/errors/cdvr/
     * api/combined/super8/errors/cdvr/2017-08-05/2017-08-08
     * @access public
     * @param  String $date  Y-m-d formatted date of interest, default yesterday
     * @return Response
     */
    public function get_clinear($dateStart = null, $dateEnd = null)
    {
        // Process parameters
        $dateStart = $this->ingestDate($dateStart, 0);
        $dateEnd   = $this->ingestDate($dateEnd, $dateStart);

        // Generate data from metric
        $metric = new Metric_Clinear_Super8_Hot_Error_Codes();
        $data = $metric-> super8errorsclinear($dateStart, $dateEnd);

        // Set response data
        $this->setResponse('data', $data);

        // Forge and return response
        return $this->forgeResponse();
    }



    // get ivod data
        /**
     * the date or date range given
     * api/combined/super8/errors/cdvr/
     * api/combined/super8/errors/cdvr/2017-08-05/2017-08-08
     * @access public
     * @param  String $date  Y-m-d formatted date of interest, default yesterday
     * @return Response
     */
    public function get_ivod($dateStart = null, $dateEnd = null)
    {
        // Process parameters
        $dateStart = $this->ingestDate($dateStart, 0);
        $dateEnd   = $this->ingestDate($dateEnd, $dateStart);

        // Generate data from metric
        $metric = new Metric_Clinear_Super8_Hot_Error_Codes();
        $data = $metric-> super8errorsivod($dateStart, $dateEnd);

        // Set response data
        $this->setResponse('data', $data);

        // Forge and return response
        return $this->forgeResponse();
    }



    // get top 10 errors by platform
    public function get_top10()
    {
        // Call presenter /api/combined/super8/errors/ivod.php and invoke the view() function, then revert to views/api/response.php, send HTTP code 200 (OK)
        return Response::forge(Presenter::forge('api/combined/super8/errors/top10', 'view', NULL, 'api/response'), 200, array('Content-Type','application/json'));
    }

}
