<?php
/**
 * The API Controller for cLinear Incidents data.
 *
 * Responds to requests made programmatically for cLinear production data reports
 *
 * @package app
 * @extends Controller
 */
class Controller_API_cLinear_Incidents_Components extends Controller_API
{


    /**
     * Return market data
     *
     * @access public
     * @return Response
     */
    public function get_comcast($component = null, $dateStart = null, $dateEnd = null)
    {
        // Process parameters
        $component     = $this->ingestParameter($component);
        $dateStart = $this->ingestDate($dateStart, 180);
        $dateEnd = $this->ingestDate($dateEnd, $dateStart);

        //Generate data from metric
        $metric = new Metric_ComcastJiraMetrics();
        $data = $metric->comcastComponents($component, $dateStart, $dateEnd);


        // Set response data
        $this->setResponse('data',     $data);
        $this->setResponse('start',    $dateStart);
        $this->setResponse('end',      $dateEnd);

        // Forge and return response
        return $this->forgeResponse();
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
        return Response::forge(Presenter::forge('api/clinear/incidents/components/cox', 'view', NULL, 'api/response'), 200, array('Content-Type','application/json'));
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
        return Response::forge(Presenter::forge('api/clinear/incidents/components/shaw', 'view', NULL, 'api/response'), 200, array('Content-Type','application/json'));
    }


}
