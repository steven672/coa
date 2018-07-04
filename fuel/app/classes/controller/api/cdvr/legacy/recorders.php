<?php
/**
 * The API Controller for cDVR Legacy recorder data.
 *
 * Responds to requests made programmatically for cDVR production data reports
 *
 * @package app
 * @extends Controller
 */
class Controller_API_cDVR_Legacy_Recorders extends Controller_API
{

   /**
     * Return MinMax (best and worst 5 markets) daily change Peak Throughput data
     *
     * @access public
     * @return Response
     */
    public function get_minmax($region = null, $dateStart = null, $dateEnd = null)
    {
        // Process parameters
        $region     = $this->ingestParameter($region);
        $dateStart  = $this->ingestDate($dateStart);
        $dateEnd    = $dateStart;
        // get one day before the start date
        $dateStart= date('Y-m-d', strtotime($dateStart .' -1 day'));


        //Generate data from metric
        $metric = new Metric_cDVR_Legacy_Recorders();
        $data = $metric->getMinMax($region, $dateStart, $dateEnd);

        // Set response data
        $this->setResponse('data',          $data);
        $this->setResponse('dateStart',     $dateStart);
        $this->setResponse('dateEnd',       $dateEnd);
        $this->setResponse('region',        $region);

        // Forge and return response
        return $this->forgeResponse();

    }


    public function get_sites($date = null)
    {

        // Set up the region list
        $listOfRegions = (new Model_RegionList())->listAllLegacy();

        // Process parameters, default date is 1 day
        $date = $this->ingestDate($date, 1);

        // Generate data from metric
        $metric = new Metric_recorders();
        $dataset = $metric->sites($date);

        // Set response data, data from mysql database
        $this->setResponse('data', $dataset);

        //set response data to include region list as well
        $this->setResponse('regions', $listOfRegions);

        // Forge and return response
        return $this->forgeResponse();
    }


    /**
     * Return throughput data
     *
     * @access public
     * @return Response
     */
    public function get_throughput($date = null, $region = null)
    {

        // Set up the region list
        $listOfRegions = (new Model_RegionList())->listAllLegacy();

        // Process parameters, default date is 1 day
        $date   = $this->ingestDate($date, 1);
        $region = $this->ingestParameter($region);

        // Generate data from metric
        $metric = new Metric_recorders();
        $dataset = $metric->throughput($date, $region);

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
        $metric = new Metric_ComcastRecorderStat();
        $dataset = $metric->recordertrend($dateStart, $dateEnd,  $region);

        // Set response data, data from mysql database
        $this->setResponse('data',      $dataset);

        //set response data to include region list as well
        $this->setResponse('regions', $listOfRegions);

        // Forge and return response
        return $this->forgeResponse();
    }

}
