<?php
/**
 * The API Controller for cDVR Rio data.
 *
 * Responds to requests made programmatically for cDVR production data reports
 *
 * @package app
 * @extends Controller
 */
class Controller_API_cDVR_Rio extends Controller_API
{


    /**
     * Return throughput data
     *
     * @access public
     * @return Response
     */
    public function get_health($date = null, $region = null)
    {

        // Set up the region list
        $listOfRegions = (new Model_RegionList())->listAllRio();

        // Process parameters, default date is 1 day
        $date   = $this->ingestDate($date, 1);
        $region = $this->ingestParameter($region);

        // Generate data from metric
        $metric = new Metric_ComcastDDNStat();
        $dataset = $metric->health($date, $region);

        // Set response data, data from mysql database
        $this->setResponse('data', $dataset);
        $this->setResponse('date', $date);
        $this->setResponse('region', $region);
        //set response data to include region list as well
        $this->setResponse('regions', $listOfRegions);

        // Forge and return response
        return $this->forgeResponse();
    }



    /**
     * Return the count of restarts per Rio component per market
     *
     * @access public
     * @return Response
     */
    public function get_restarts($region = null, $datestart = null, $dateend = null)
    {
        // Process parameters
        $region     = $this->ingestParameter($region);
        $dateStart  = $this->ingestDate($datestart);
        $dateEnd    = $this->ingestDate($dateend, $datestart);

        //Generate data from metric
        $metric = new Metric_Rio();
        $worst = $metric->restarts($region, $dateStart, $dateEnd);

        //Set response data
        $this->setResponse('data',          $worst);
        $this->setResponse('dateStart',     $dateStart);
        $this->setResponse('dateEnd',       $dateEnd);
        $this->setResponse('region',        $region);

        // Forge and return response
        return $this->forgeResponse();
    }


    /**
     * Return sites data
     *
     * @access public
     * @return Response
     */
    public function get_sites($date = null, $region = null)
    {

        // Set up the region list
        $listOfRegions = (new Model_RegionList())->listAllRio();

        // Process parameters, default date is 1 day
        $date   = $this->ingestDate($date, 1);
        $region = $this->ingestParameter($region);

        // Generate data from metric
        $metric = new Metric_ComcastDDNStat();
        $dataset = $metric->getsites($date, $region);

        // Set response data, data from mysql database
        $this->setResponse('data', $dataset);
        $this->setResponse('date', $date);
        $this->setResponse('region', $region);
        //set response data to include region list as well
        $this->setResponse('regions', $listOfRegions);

        // Forge and return response
        return $this->forgeResponse();
    }




        /**
         * Return trending data
         *
         * @access public
         * @return Response
         */
    public function get_trending()
    {
        // Call presenter/api/health.php and invoke the view() function, then revert to views/api/response.php, send HTTP code 200 (OK)
        return Response::forge(Presenter::forge('api/cdvr/rio/trending', 'view', NULL, 'api/response'), 200, array('Content-Type','application/json'));
    }

    /**
     * Return the worst capacity utilization by market data
     *
     * @access public
     * @return Response
     */
    public function get_worstfivecapacity($datestart = null, $dateend = null)
    {
        // Process parameters
        $dateStart  = $this->ingestDate($datestart);
        $dateEnd    = $this->ingestDate($dateend, $datestart);

        //Generate data from metric
        $metric = new Metric_ComcastDDNStat();
        $worst = $metric->getworstfivecapacity($dateStart, $dateEnd);

        //Set response data
        $this->setResponse('data',          $worst);
        $this->setResponse('dateStart',     $dateStart);
        $this->setResponse('dateEnd',       $dateEnd);

        // Forge and return response
        return $this->forgeResponse();
    }





}
