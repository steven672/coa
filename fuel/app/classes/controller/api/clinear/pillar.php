<?php
/**
 * The API Controller for cLinear data.
 *
 * Responds to requests made programmatically for cLinear production data reports
 *
 * @package app
 * @extends Controller
 */
class Controller_API_cLinear_Pillar extends Controller_API
{


    /**
     * Return cLinear Products data
     *
     * @access public
     * @return Response
     */
    public function get_availability()
    {
        // Call presenter/api/clinear/pillar/availability.php and invoke the view() function, then revert to views/api/response.php, send HTTP code 200 (OK)
        return Response::forge(Presenter::forge('api/clinear/pillar/availability', 'view', NULL, 'api/response'), 200, array('Content-Type','application/json'));
    }


    public function get_hot()
    {
        // Call presenter/api/clinear/pillar/hot.php and invoke the view() function, then revert to views/api/response.php, send HTTP code 200 (OK)
        return Response::forge(Presenter::forge('api/clinear/pillar/hot', 'view', NULL, 'api/response'), 200, array('Content-Type','application/json'));
    }


    public function get_restarts()
    {
        // Call presenter/api/clinear/pillar/restarts.php and invoke the view() function, then revert to views/api/response.php, send HTTP code 200 (OK)
        return Response::forge(Presenter::forge('api/clinear/pillar/restarts', 'view', NULL, 'api/response'), 200, array('Content-Type','application/json'));
    }


    public function get_restartscox($count = null, $dateStart = null, $dateEnd = null)
    {
        // Process parameters
        $count      = $this->ingestParameter($count, 100);
        $dateStart  = $this->ingestDate($dateStart, 0);
        $dateEnd    = $this->ingestDate($dateEnd, $dateStart);

        // Generate data from metric
        $metric = new Metric_ComcastViperWatermarkNew();
        $data = $metric->restartsMinutesCox($count, $dateStart, $dateEnd);

        // Set response data
        $this->setResponse('data',   $data);
        $this->setResponse('start',  $dateStart);
        $this->setResponse('end',    $dateEnd);
        $this->setResponse('count',  $count);

        $this->setResponse('data', $data);

        // Forge and return response
        return $this->forgeResponse();
    }

    public function get_panics()
    {
        // Call presenter/api/clinear/pillar/panics.php and invoke the view() function, then revert to views/api/response.php, send HTTP code 200 (OK)
        return Response::forge(Presenter::forge('api/clinear/pillar/panics', 'view', NULL, 'api/response'), 200, array('Content-Type','application/json'));
    }


}
