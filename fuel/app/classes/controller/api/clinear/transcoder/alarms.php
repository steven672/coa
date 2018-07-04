<?php
/**
 * The API Controller for cLinear data.
 *
 * Responds to requests made programmatically for cLinear production data reports
 *
 * @package app
 * @extends Controller
 */
class Controller_API_cLinear_Transcoder_Alarms extends Controller_API
{
    /**
     * @access public
     * @param  Int    $count number of worst hosts to provide, default 10
     * @param  String $date  Y-m-d formatted date of interest, default yesterday
     * @return Response
     */
    public function get_hot($count = null, $dateStart = null, $dateEnd = null)
    {
        // Process parameters
        $count = $this->ingestParameter($count, 10);
        $dateStart = $this->ingestDate($dateStart, 0);
        $dateEnd   = $this->ingestDate($dateEnd, $dateStart);

       // Generate data from metric
        $metric = new Metric_ComcastVipercLinearNew();
        $data = $metric-> transcoderalarmworst10($count, $dateStart, $dateEnd);
          // Set response data
        $this->setResponse('data', $data);

        // Forge and return response
        return $this->forgeResponse();
     }

    public function get_region($dateStart = null, $dateEnd = null)
    {
        // Process parameters
        $dateStart = $this->ingestDate($dateStart, 0);
        $dateEnd   = $this->ingestDate($dateEnd, $dateStart);

        // Generate data from metric
        $metric = new Metric_ComcastVipercLinearNew();
        $data = $metric-> transcoderregionalarms($dateStart, $dateEnd);

        // Set response data
        $this->setResponse('data', $data);

        // Forge and return response
        return $this->forgeResponse();
    }



}
