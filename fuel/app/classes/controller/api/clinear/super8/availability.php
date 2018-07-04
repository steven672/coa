<?php
/**
 * The API Controller for cLinear data.
 *
 * Responds to requests made programmatically for cLinear production data reports
 *
 * @package app
 * @extends Controller
 */
class Controller_API_cLinear_Super8_Availability extends Controller_API
{
    /**
     * Return api response with n worst comcast streams for the date or date range given
     * api/clinear/super8/availability/comcast/(/:start)?(/:end)?
     * @access public
     * @param  Int    $count number of worst hosts to provide, default 10
     * @param  String $date  Y-m-d formatted date of interest, default yesterday
     * @return Response
     */
    public function get_comcast($dateStart = null, $dateEnd = null)
    {
        // Process parameters
        $dateStart = $this->ingestDate($dateStart, 7);
        $dateEnd = $this->ingestDate($dateEnd, $dateStart);

        // Generate data from metric
        $metric = new Metric_ComcastVipercLinearNew();
        $data = $metric->super8availability($dateStart, $dateEnd);

        // Set response data
        $this->setResponse('data', $data['data']);
        $this->setResponse('dataFacility', $data['dataFacility']);
        $this->setResponse('dataCregion', $data['dataCregion']);
        $this->setResponse('histogramData1', $data['histogramData1']);

        // Forge and return response
        return $this->forgeResponse();
    }

       /**
     * Return api response with n worst comcast streams for the date or date range given
     * api/clinear/super8/availability/cox/(/:start)?(/:end)?
     * @access public
     * @param  Int    $count number of worst hosts to provide, default 10
     * @param  String $date  Y-m-d formatted date of interest, default yesterday
     * @return Response
     */
    public function get_cox($dateStart = null, $dateEnd = null)
    {
        // Process parameters
        $dateStart = $this->ingestDate($dateStart, 7);
        $dateEnd = $this->ingestDate($dateEnd, $dateStart);

        // Generate data from metric
        $metric = new Metric_ComcastViperWatermarkNew();
        $data = $metric->coxsuper8availability($dateStart, $dateEnd);

        // Set response data
        $this->setResponse('data', $data);

        // Forge and return response
        return $this->forgeResponse();
    }




}
