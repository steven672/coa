<?php
/**
 * The API Controller for Super8 Availability data
 *
 * Responds to requests made programmatically for cDVR production data reports
 *
 * @package app
 * @extends Controller
 */
class Controller_API_cDVR_Performance_Super8 extends Controller_API
{

    /**
     * Return api response with Super8 Availability data from dateStart to dateEnd
     *
     * @access public
     * @param  String $dateStart Y-m-d formatted date start of range, default today
     * @param  String $dateEnd   Y-m-d formatted date end of range, default 7 days ago
     * @return Response
     */
    public function get_availability($dateStart = null, $dateEnd = null)
    {
        // Process parameters
        $dateStart = $this->ingestDate($dateStart);
        $dateEnd = $this->ingestDate($dateEnd, $dateStart);

        //Generate data metric
        $metric = new Metric_ComcastVipercDVR();
        $data = $metric->availabilitySuper8($dateStart, $dateEnd);

        // Set response data
        $this->setResponse('data', $data);
        $this->setResponse('start', $dateStart);
        $this->setResponse('end', $dateEnd);

        // Forge and return response
        return $this->forgeResponse();
    }


}
