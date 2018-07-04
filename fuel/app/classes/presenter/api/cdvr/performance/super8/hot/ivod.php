<?php

/**
 * The API cDVR Super8 iVOD Worst 10 Streams by Market presenter.
 *
 * @package app
 * @extends Presenter_API
 */

// The Presenter_API class includes Model\Validator already
// use \Model\Validator;
class Presenter_API_cDVR_Performance_Super8_Hot_iVOD extends Presenter_API_cdvr_Template
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
            * Ingest the date and region variables
            * The URL formats for these variables are specified in the /app/config/routes.php file
            * For this API endpoint, bdate is optional variables
            * Valid URL calls:
            * dev-coa/api/cdvr/performance/super8/hot/ivod
         */

        // Ingest normalized application parameters from the URL
        $dateStart = $this->ingestParameter('start');
        $dateEnd   = $this->ingestParameter('end');

        // Query the database using the info needed for this API
        $responseiVODSuper8Worst10 = $this->selectDataByDateRange(
            'comcast_viper_cdvr',               // DB Connection Label (from app config)
            'ivod_super8_worst10',              // DB Table Name (MySQL)
            'date_created',                     // DB Field Name for dates
            $dateStart,                         // The actual start date ingested above
            $dateEnd                            // The actual end date ingested above
        );


        // Add to the response array (data is raw data)
        $this->response = array('data' => NULL);

        // Build response array, bucketize by date
        $this->response['data'] = $this->createArrayBucketsByField($responseiVODSuper8Worst10['data'], 'date_created');


    }

}
