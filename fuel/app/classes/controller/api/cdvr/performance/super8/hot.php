<?php
/**
 * The API Controller for cDVR Super8 iVOD Worst 10 Streams by Market
 *
 * Responds to requests made programmatically for cDVR production data reports
 *
 * @package app
 * @extends Controller
 */
class Controller_API_cDVR_Performance_Super8_Hot extends Controller_API
{


    /**
     * Return throughput data
     *
     * @access public
     * @return Response
     */
    public function get_ivod()
    {
        // Call presenter/api/cdvr/performance/super8/hot/ivod.php and invoke the view() function, then revert to views/api/response.php, send HTTP code 200 (OK)
        return Response::forge(Presenter::forge('api/cdvr/performance/super8/hot/ivod', 'view', NULL, 'api/response'), 200, array('Content-Type','application/json'));
    }


}
