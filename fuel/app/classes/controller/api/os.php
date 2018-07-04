<?php
/**
 * The API Controller for viper data.
 *
 * Responds to requests made programmatically for cLinear production data reports
 *
 * @package app
 * @extends Controller
 */
class Controller_API_Os extends Controller_API
{

    /**
     * Return duplicates data
     *
     * @access public
     * @return Response
     */
    public function get_versions()
    {
        // Call presenter /api/combined/super8/errors/summary.php and invoke the view() function, then revert to views/api/response.php, send HTTP code 200 (OK)
        return Response::forge(Presenter::forge('api/os/versions', 'view', NULL, 'api/response'), 200, array('Content-Type','application/json'));
    }

}
