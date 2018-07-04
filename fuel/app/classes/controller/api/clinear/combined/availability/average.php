<?php
/**
 * The API Controller for cLinear Combined Availability data.
 *
 * Responds to requests made programmatically for cLinear production data reports
 *
 * @package app
 * @extends Controller
 */
class Controller_API_cLinear_Combined_Availability_Average extends Controller_API
{

        public function get_comcast($dateStart = null, $dateEnd = null)
    {
        // Process parameters
        $dateStart = $this->ingestDate($dateStart, 0);
        $dateEnd = $this->ingestDate($dateEnd, $dateStart);

        // Generate data from metric
        $metric = new Metric_ComcastVipercLinearNew();
        $comcast = $metric->comcastAvailabilityAverage($dateStart, $dateEnd);
        // Set response data
        $this->setResponse('data', $comcast);
        $this->setResponse('start', $dateStart);
        $this->setResponse('end', $dateEnd);

        // Forge and return response
        return $this->forgeResponse();
    }


        public function get_cox($dateStart = null, $dateEnd = null)
    {
        // Process parameters
        $dateStart = $this->ingestDate($dateStart, 0);
        $dateEnd = $this->ingestDate($dateEnd, $dateStart);

        // Generate data from metric
        $metric = new Metric_ComcastVipercLinearNew();
        $comcast = $metric->coxAvailabilityAverage($dateStart, $dateEnd);
        // Set response data
        $this->setResponse('data', $comcast);
        $this->setResponse('start', $dateStart);
        $this->setResponse('end', $dateEnd);

        // Forge and return response
        return $this->forgeResponse();
    }

}
