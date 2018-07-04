<?php

/**
 * The API Stream Scanner Issues presenter.
 *
 * @package app
 * @extends Presenter
 */

// The Presenter_API class includes Model\Validator already
// use \Model\Validator;
class Presenter_Api_Clinear_Sscanner_Availability extends Presenter_API_cLinear_Template
{


    /**
     * Prepare the view data, keeping this in here helps clean up
     * the controller.
     *
     * @return void
     */
    public function view()
    {
        /*
            * Ingest the start date, end date, and  and region variables
            * The URL formats for these variables are specified in the /app/config/routes.php file
            * For this API endpoint, both date and region are optional variables
            * Valid URL calls:
            *   /api/clinear/sscanner/availability/2017-01-31   //stream availability for all markets
         */

        // Ingest normalized application parameters from the URL
        $dateStart = $this->ingestParameter('start');
        $dateEnd   = $this->ingestParameter('end');

        // Query the database using the info needed for this API
        $responseScannerAvailability = $this->selectDataByDateRangeAndMarket(
            'viper_clinear',                    // DB Connection Label (from app config)
            'stream',                         // DB Table Name (MySQL)
            'date_created',                     // DB Field Name for dates
            $dateStart,                         // The actual start date ingested above
            $dateEnd                           // The actual end date ingested above
        );

        // Add to the response array (data is raw data)
        $this->response = array('data' => NULL);

        // Write the response data for consumption by the client
        $this->response['data'] = $this->createArrayBucketsByField($responseScannerAvailability['data'], 'date_created');
    }


}

;
