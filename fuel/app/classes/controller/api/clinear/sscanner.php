<?php
/**
 * The API Controller for cLinear Stream Scanner data.
 *
 * Responds to requests made programmatically for cLinear production data reports
 *
 * @package app
 * @extends Controller
 */
class Controller_API_cLinear_Sscanner extends Controller_API
{


    /**
     * Return availability
     *
     * @access public
     * @return Response
     */
    public function get_availability()
    {
        // Call presenter/api/clinear/incidents/sscanner/availability.php and invoke the view() function, then revert to views/api/response.php, send HTTP code 200 (OK)
        return Response::forge(Presenter::forge('api/clinear/sscanner/availability', 'view', NULL, 'api/response'), 200, array('Content-Type','application/json'));
    }


    public function get_hot()
    {
        // Call presenter/api/markets.php and invoke the view() function, then revert to views/api/response.php, send HTTP code 200 (OK)
        return Response::forge(Presenter::forge('api/clinear/sscanner/hot', 'view', NULL, 'api/response'), 200, array('Content-Type','application/json'));
    }


}
