<?php
/**
 * The API Controller for cDVR Legacy Cleversafe archive data.
 *
 * Responds to requests made programmatically for cDVR production data reports
 *
 * @package app
 * @extends Controller
 */
class Controller_API_cDVR_Legacy_CS extends Controller_API
{

   /**
     * Return MinMax (best and worst 5 markets) daily change Cleversafe Archive data
     *
     * @access public
     * @return Response
     */
    public function get_minmax($region = null, $datestart = null, $dateend = null)
    {
        // Process parameters
        $region     = $this->ingestParameter($region);
        $dateStart  = $this->ingestDate($datestart);
        $dateEnd    = $dateStart;
        // get one day before the start date
        $dateStart= date('Y-m-d', strtotime($dateStart .' -1 day'));


        //Generate data from metric
        $metric = new Metric_ComcastDDNStat();
        $data = $metric->getMinMaxCS($region, $dateStart, $dateEnd);

        // Set response data
        $this->setResponse('data',          $data);
        $this->setResponse('dateStart',     $dateStart);
        $this->setResponse('dateEnd',       $dateEnd);
        $this->setResponse('region',        $region);

        // Forge and return response
        return $this->forgeResponse();

    }

    public function get_sites($region = null, $datestart = null, $dateend = null)
    {
        // Process parameters
        $region     = $this->ingestParameter($region);
        $dateStart  = $this->ingestDate($datestart);
        $dateEnd    = $this->ingestDate($dateend);

        //Generate data from metric
        $metric = new Metric_ComcastDDNStat();
        $worst = $metric->getCleversafeRegionStartEndRange($region, $dateStart, $dateEnd);

        //Set response data
        $this->setResponse('data',          $worst);
        $this->setResponse('dateStart',     $dateStart);
        $this->setResponse('dateEnd',       $dateEnd);
        $this->setResponse('region',        $region);

        // Forge and return response
        return $this->forgeResponse();
    }

    public function get_versiondata()
    {
        // Call presenter/api/throughput.php and invoke the view() function, then revert to views/api/response.php, send HTTP code 200 (OK)
        return Response::forge(Presenter::forge('api/cdvr/legacy/cs/versiondata', 'view', NULL, 'api/response'), 200, array('Content-Type','application/json'));
    }


   /**
     * Return trending data for cs
     *
     * @access public
     * @return Response
     */
    public function get_trend($dateStart = null, $dateEnd = null, $region = null)
    {
        $listOfRegions = (new Model_RegionList())->listAllLegacy();

        // Process parameters
        $region     = $this->ingestParameter($region);
        $dateStart  = $this->ingestDate($dateStart, 0);
        $dateEnd    = $this->ingestDate($dateEnd, $dateStart);

        // Generate data from metric
        $metric = new Metric_ComcastDDNStat();
        $dataset = $metric->cstrend($dateStart, $dateEnd,  $region);

        // Set response data, data from mysql database
        $this->setResponse('data',      $dataset);

        //set response data to include region list as well
        $this->setResponse('regions', $listOfRegions);

        // Forge and return response
        return $this->forgeResponse();
    }

}
