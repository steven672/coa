<?php

/**
 * The API Controller for cDVR DASH-R Playback Worst 3 Recording ID by Market data.
 *
 * Responds to requests made programmatically for cDVR production data reports
 *
 * @package app
 * @extends Controller
 */

class Controller_API_cDVR_Playback_dashr extends Controller_API
{

    /**
     * Return dashr availability data from dateStart to dateEnd
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
        $data = $metric->availabilityDashr($dateStart, $dateEnd);

        // Set response data
        $this->setResponse('data', $data);
        $this->setResponse('start', $dateStart);
        $this->setResponse('end', $dateEnd);

        // Forge and return response
        return $this->forgeResponse();
    }


    /**
     * Return cDVR Playback DASH-R Worst 3 Recording_ID by Market data
     *
     * @access public
     * @param  Int    $count number of worst streams to provide, default 10
     * @param  String $date  Y-m-d formatted date of interest, default yesterday
     * @return Response
     */
    public function get_worst($dateStart = null, $dateEnd = null)
    {
        // Process parameters
        // $count = $this->ingestParameter($count, 10);
        // $date = $this->ingestDate($date);
        $dateStart  = $this->ingestDate($dateStart);
        $dateEnd    = $this->ingestDate($dateEnd, $dateStart);

        // Generate data from metric
        $metric = new Metric_cDVR_Playback_Dashr();
        $worst = $metric->worst($dateStart, $dateEnd);

        // Set response data
        $this->setResponse('data', $worst);
        // $this->setResponse('date', $date);
        // $this->setResponse('count', $count);
        $this->setResponse('dateStart',     $dateStart);
        $this->setResponse('dateEnd',       $dateEnd);

        // Forge and return response
        return $this->forgeResponse();
    }


    /**
     * Return api response with n worst recordingID for date
     *
     * @access public
     * @param  Int    $count number of worst streams to provide, default 10
     * @param  String $date  Y-m-d formatted date of interest, default yesterday
     * @return Response
     */
    public function get_worst10($count = null, $date = null)
    {
        // Process parameters
        $count = $this->ingestParameter($count, 10);
        $date = $this->ingestDate($date);

        // Generate data from metric
        $metric = new Metric_cDVR_Playback_Dashr();
        $worst = $metric->worstStreams($date, $count);

        // Set response data
        $this->setResponse('data', $worst);
        $this->setResponse('date', $date);
        $this->setResponse('count', $count);

        // Forge and return response
        return $this->forgeResponse();
    }

}
