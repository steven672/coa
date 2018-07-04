<?php
/**
 * The API Controller for cLinear Combined Availability data.
 *
 * Responds to requests made programmatically for cLinear production data reports
 *
 * @package app
 * @extends Controller
 */
class Controller_API_cLinear_Combined_Availability_Raw extends Controller_API
{


    /**
     * Return raw avilability data
     *
     * @access public
     * @return Response
     */
    // public function get_comcast()
    // {
    //     // Call presenter/api/clinear/combined/availability/raw.php and invoke the view() function, then revert to views/api/response.php, send HTTP code 200 (OK)
    //     return Response::forge(Presenter::forge('api/clinear/combined/availability/raw/comcast', 'view', NULL, 'api/response'), 200, array('Content-Type','application/json'));
    // }

    public function get_comcast($start = null, $end = null)
    {
        // Process parameters
        $start = $this->ingestDate($start, 0);
        $end = $this->ingestDate($end, 0);

        // Generate data from metric
        $metric = new Metric_e2eanalysis();
        $comcast = $metric->comcast($start, $end);

        // Set response data
        $this->setResponse('data', $comcast);
        $this->setResponse('start', $start);
        $this->setResponse('end', $end);

        // Forge and return response
        return $this->forgeResponse();
    }

    public function get_regioncomcast($start = null, $end = null)
    {
        // Process parameters
        $start = $this->ingestDate($start, 0);
        $end = $this->ingestDate($end, 0);

        // Generate data from metric
        $metric = new Metric_e2eanalysis();
        $comcast = $metric->regioncomcast($start, $end);

        // Set response data
        $this->setResponse('data', $comcast);
        $this->setResponse('start', $start);
        $this->setResponse('end', $end);

        // Forge and return response
        return $this->forgeResponse();
    }


}
