<?php
/**
 * The API Controller for cDVR Legacy data.
 *
 * Responds to requests made programmatically for cDVR production data reports
 *
 * @package app
 * @extends Controller
 */
class Controller_API_cDVR_Legacy extends Controller_API
{


    /**
     * Return api response with n worst recordingID for date
     *
     * @access public
     * @param  Int    $count number of worst streams to provide, default 10
     * @param  String $date  Y-m-d formatted date of interest, default yesterday
     * @return Response
     */
    public function get_health( $date = null, $region = null )
    {
        // Process parameters
        $region     = $this->ingestParameter($region);
        $date       = $this->ingestDate($date);

        //Generate data from metric
        $metric = new Metric_cDVR_Legacy();
        $data   = $metric->getHealth($region, $date);

        // Set response data
        $this->setResponse('data',          $data);
        $this->setResponse('date',          $date);
        $this->setResponse('region',        $region);

        // Forge and return response
        return $this->forgeResponse();
    }



    /**
     * Return piority market data (market with the worst performance during previous day)
     *
     * @access public
     * @return Response
     */

    public function get_priority( $datestart = null, $dateend = null, $region= null)
    {
        // Process parameters
        $region     = $this->ingestParameter($region);
        $dateStart  = $this->ingestDate($datestart);
        $dateEnd    = $this->ingestDate($dateend);

        //Generate data from metric
        $metric = new Metric_cDVR_Legacy();
        $data = $metric->getPriority($region, $dateStart, $dateEnd);

        //Set response data
        $this->setResponse('data',          $data);
        $this->setResponse('dateStart',     $dateStart);
        $this->setResponse('dateEnd',       $dateEnd);
        $this->setResponse('region',        $region);


        // Forge and return response
        return $this->forgeResponse();
    }

   /**
     * Return MinMax (best and worst 5 markets) daily change data for Legacy Recorders
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
        $metric = new Metric_cDVR_Legacy();
        $data = $metric->getMinMax($region, $dateStart, $dateEnd);
        // Set response data
        $this->setResponse('data',          $data);
        $this->setResponse('dateStart',     $dateStart);
        $this->setResponse('dateEnd',       $dateEnd);
        $this->setResponse('region',        $region);
        // Forge and return response
        return $this->forgeResponse();
    }

}
