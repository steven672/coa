<?php
/**
 * The API Controller for recording failures by rio market
 *
 * Responds to requests made programmatically for cDVR production data reports
 *
 * @package app
 * @extends Controller
 */
class Controller_API_cDVR_Performance_Rio_c3rm extends Controller_API
{


    /**
     * Return failures per rio market data
     *
     * @access public
     * @return Response
     */
    public function get_trend()
    {
        // Call presenter/api/cdvr/performance/rio/failures/markets.php and invoke the view() function, then revert to views/api/response.php, send HTTP code 200 (OK)
        return Response::forge(Presenter::forge('api/cdvr/performance/rio/c3rm/trend', 'view', NULL, 'api/response'), 200, array('Content-Type','application/json'));
    }


}
