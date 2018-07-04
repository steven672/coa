<?php
/**
 * The API Controller for cLinear data.
 *
 * Responds to requests made programmatically for cLinear production data reports
 *
 * @package app
 * @extends Controller
 */
class Controller_API_cLinear_SScanner_Markets extends Controller_API
{


    /**
     * Return health data
     *
     * @access public
     * @return Response
     */
    public function get_cox()
    {
        // Call presenter/api/markets.php and invoke the view() function, then revert to views/api/response.php, send HTTP code 200 (OK)
        return Response::forge(Presenter::forge('api/clinear/sscanner/markets/cox', 'view', NULL, 'api/response'), 200, array('Content-Type','application/json'));
    }


}
