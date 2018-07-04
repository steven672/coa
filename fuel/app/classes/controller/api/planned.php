<?php
/**
 * The API Controller for cLinear data.
 *
 * Responds to requests made programmatically for cLinear production data reports
 *
 * @package app
 * @extends Controller
 */
class Controller_API_Planned extends Controller_API
{
        /**
     * Return duplicates data
     *
     * @access public
     * @return Response
     */




            /* the date or date range given
     * /api/planned/impactedservices/
     * @access public
     * @param  Int    $count of worst results to display, default 10
     * @param  String $date  Y-m-d formatted date of interest, default yesterday
     * @return Response
     */
    public function get_impactedservices($platform = null, $dateStart = null, $dateEnd = null)
    {
        // Process parameters
        $count     = $this->ingestParameter($platform);
        $dateStart = $this->ingestDate($dateStart, 0);
        $dateEnd   = $this->ingestDate($dateEnd, $dateStart);

        // Generate data from metric
        $metric = new Metric_Jiraplannedwork();
        $data = $metric-> plannedimpactedservices($platform, $dateStart, $dateEnd);

        // Set response data
        $this->setResponse('data', $data);

        // Forge and return response
        return $this->forgeResponse();
    }


    public function get_worktype()
    {

        // Call presenter/api/clinear/pillar/restarts/cox.php and invoke the view() function, then revert to views/api/response.php, send HTTP code 200 (OK)
        return Response::forge(Presenter::forge('api/planned/worktype', 'view', NULL, 'api/response'), 200, array('Content-Type','application/json'));
    }


}
