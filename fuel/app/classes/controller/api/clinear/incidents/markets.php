<?php
/**
 * The API Controller for cLinear Incidents data.
 *
 * Responds to requests made programmatically for cLinear production data reports
 *
 * @package app
 * @extends Controller
 */
class Controller_API_cLinear_Incidents_markets extends Controller_API
{


    /**
     * Return market data
     *
     * @access public
     * @return Response
     */
    public function get_comcast()
    {
        // Call presenter/api/clinear/incidents/markets.php and invoke the view() function, then revert to views/api/response.php, send HTTP code 200 (OK)
        return Response::forge(Presenter::forge('api/clinear/incidents/markets/comcast', 'view', NULL, 'api/response'), 200, array('Content-Type','application/json'));
    }


    /**
     * Return market data
     *
     * @access public
     * @return Response
     */
    public function get_cox()
    {
        // Call presenter/api/clinear/incidents/markets.php and invoke the view() function, then revert to views/api/response.php, send HTTP code 200 (OK)
        return Response::forge(Presenter::forge('api/clinear/incidents/markets/cox', 'view', NULL, 'api/response'), 200, array('Content-Type','application/json'));
    }


    /**
     * Return market data
     *
     * @access public
     * @return Response
     */
    public function get_shaw()
    {
        // Call presenter/api/clinear/incidents/markets.php and invoke the view() function, then revert to views/api/response.php, send HTTP code 200 (OK)
        return Response::forge(Presenter::forge('api/clinear/incidents/markets/shaw', 'view', NULL, 'api/response'), 200, array('Content-Type','application/json'));
    }


}
