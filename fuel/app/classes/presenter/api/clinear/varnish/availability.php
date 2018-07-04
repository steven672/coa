<?php

/**
 * The cLinear Varnish availability API presenter.
 *
 * @package app
 * @extends Presenter_API
 */

// The Presenter_API class includes Model\Validator already
// use \Model\Validator;
class Presenter_API_cLinear_Varnish_Availability extends Presenter_API_cLinear_Template
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
            *   /api/clinear/varnish/availability/2017-01-01/2017-01-10         stream hAvailability from January 1, 2017 to January 10, 2017
         */

        // Ingest normalized application parameters from the URL
        $dateStart = $this->ingestParameter('start');
        $dateEnd   = $this->ingestParameter('end');

        // Query the database using the info needed for this API for varnish stream availability
        $responseVarnishAvailability = $this->selectDataByDateRangeAndSortExtraField(
            'viper_clinear_new',                // DB Connection Label (from app config)
            'varnish_error_free',              // DB Table Name (MySQL)
            'count',                            // DB field need for sort
            'date_created',                     // DB Field Name for dates
            $dateStart,                         // The actual start date ingested above
            $dateEnd                           // The actual end date ingested above
        );

        // Add to the response array (data is raw data)
        $this->response = array('data' => NULL);

        // Build response array, bucketize by date
        $this->response['data'] = $this->createArrayBucketsByField($responseVarnishAvailability['data'], 'date_created');
    }


}
