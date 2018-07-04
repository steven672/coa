<?php
/**
 * The API Controller for cLinear data.
 *
 * Responds to requests made programmatically for cLinear production data reports
 *
 * @package app
 * @extends Controller
 */
class Controller_API_cLinear_Varnish_Cachestreams extends Controller_API
{


    /**
     * Return duplicates data
     *
     * @access public
     * @return Response
     */

    public function get_hot()
    {
        // Call presenter/api/clinear/varnish/hot.php and invoke the view() function, then revert to views/api/response.php, send HTTP code 200 (OK)
        return Response::forge(Presenter::forge('api/clinear/varnish/cachestreams/hot', 'view', NULL, 'api/response'), 200, array('Content-Type','application/json'));
    }



}
