<?php

/**
 * The cLinear Varnish Hot API presenter.
 *
 * @package app
 * @extends Presenter_API
 */

// The Presenter_API class includes Model\Validator already
// use \Model\Validator;
class Presenter_API_cLinear_Varnish_Worst10responsetime extends Presenter_API_cLinear_Template
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
            * Ingest the date and number variables
            * The URL formats for these variables are specified in the /app/config/routes.php file
            * Valid URL calls:
            *   /api/clinear/varnish/worst10responsetime/2017-05-16         Worst 10 streams (worst varnish response time) from May 15, 2017 to May 16, 2017
         */

        // Ingest normalized application parameters from the URL
        $dateStart = $this->ingestParameter('start');
        $dateEnd   = $this->ingestParameter('end');


        // Query the database using the info needed for this API for nat 10
        $responseVarnishWorst10responsetime = $this->selectDataByDateRangeAndSortExtraField(
            'viper_clinear_new',                // DB Connection Label (from app config)
            'Varnishworst10channelswithresponsetime',              // DB Table Name (MySQL)
            'CountTimes',                              // The extra field to sort data by
            'date_created',                     // DB Field Name for dates
            $dateStart,                         // The actual start date ingested above
            $dateEnd                           // The actual end date ingested above
        );

        // Add to the response array (data is raw data)
        $this->response = array('data' => NULL);

        // Build response array, bucketize by date
        $this->response['data'] = $this->createArrayBucketsByField($responseVarnishWorst10responsetime['data'], 'date_created');
    }



}
