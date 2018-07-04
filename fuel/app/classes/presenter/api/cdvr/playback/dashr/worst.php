<?php

/**
 * The API cDVR DASH-R Playback Worst 3 Recording ID by Market presenter.
 *
 * @package app
 * @extends Presenter
 */

// The Presenter_API class includes Model\Validator already
// use \Model\Validator;
class Presenter_API_cDVR_Playback_dashr_Worst extends Presenter_API_cLinear_Template
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
            * For this API endpoint, both date and region are optional variables
            * Valid URL calls:
            * api/cdvr/playback/dashr/worst/
            * api/cdvr/playback/dashr/worst/2017-05-10
            * api/cdvr/playback/dashr/worst/2017-05-10/2017-05-11
         */

        // Ingest normalized application parameters from the URL
        $dateStart = $this->ingestParameter('start');
        $dateEnd   = $this->ingestParameter('end');

        // Query the database using the info needed for this API
        $responseWorstThreeRecIDPerMarket = $this->selectDataByDateRangeAndSortExtraField(
            'comcast_viper_cdvr',               // DB Connection Label (from app config)
            'dash_r_worst3_per_region',         // DB Table Name (MySQL)
            'cregion',                          // DB extra field to be sorted
            'date_created',                     // DB Field Name for dates
            $dateStart,                         // The actual start date ingested above
            $dateEnd                            // The actual end date ingested above
        );

        // Add to the response array (data is raw data)
        $this->response = array('data' => NULL);

        // Write the response data for consumption by the client
        $this->response['data'] = $this->createArrayBucketsByField($responseWorstThreeRecIDPerMarket['data'], 'date_created');
    }


}