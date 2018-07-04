<?php
/**
 * The API Controller for cLinear Incidents data.
 *
 * Responds to requests made programmatically for cLinear production data reports
 *
 * @package app
 * @extends Controller
 */
class Controller_API_cLinear_Incidents extends Controller_API
{


    /**
     * Return duplicates data
     *
     * @access public
     * @return Response
     */
    public function get_duplicates()
    {
        // Call presenter/api/clinear/incidents/duplicates.php and invoke the view() function, then revert to views/api/response.php, send HTTP code 200 (OK)
        return Response::forge(Presenter::forge('api/clinear/incidents/duplicates', 'view', NULL, 'api/response'), 200, array('Content-Type','application/json'));
    }


        /**
         * Return noStarted data
         *
         * @access public
         * @return Response
         */
    public function get_notstarted()
    {
        // Call presenter/api/clinear/incidents/nostarted.php and invoke the view() function, then revert to views/api/response.php, send HTTP code 200 (OK)
        return Response::forge(Presenter::forge('api/clinear/incidents/notstarted', 'view', NULL, 'api/response'), 200, array('Content-Type','application/json'));
    }


        /**
         * Return resolved data
         *
         * @access public
         * @return Response
         */
    public function get_resolved()
    {
        // Call presenter/api/clinear/incidents/resolved.php and invoke the view() function, then revert to views/api/response.php, send HTTP code 200 (OK)
        return Response::forge(Presenter::forge('api/clinear/incidents/resolved', 'view', NULL, 'api/response'), 200, array('Content-Type','application/json'));
    }


            /**
             * Return vednor data
             *
             * @access public
             * @return Response
             */
    public function get_vendors()
    {
        // Call presenter/api/clinear/incidents/markets.php and invoke the view() function, then revert to views/api/response.php, send HTTP code 200 (OK)
        return Response::forge(Presenter::forge('api/clinear/incidents/vendors', 'view', NULL, 'api/response'), 200, array('Content-Type','application/json'));
    }


}
