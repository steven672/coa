<?php
/**
 * The API Controller for subscriber counts data.
 *
 * Responds to requests made programmatically for cDVR production data reports
 *
 * @package app
 * @extends Controller
 */

class Controller_API_Combined_Subscriber_Counts extends Controller_API
{

    public function get_region($region = null, $datestart = null, $dateend = null)
    {
        // Process parameters
        $region     = $this->ingestParameter($region);
        $dateStart  = $this->ingestDate($datestart);
        $dateEnd    = $this->ingestDate($dateend, $datestart);

        //Generate data from metric
        $metric = new Metric_Combined_Subscriber_Counts();
        $data = $metric->getRegionalSubscriberCounts($region, $dateStart, $dateEnd);

        //Set response data
        $this->setResponse('data',          $data);
        $this->setResponse('dateStart',     $dateStart);
        $this->setResponse('dateEnd',       $dateEnd);
        $this->setResponse('region',        $region);

        // Forge and return response
        return $this->forgeResponse();
    }



}