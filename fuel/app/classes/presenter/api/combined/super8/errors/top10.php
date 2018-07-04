<?php

/**
 * The combined Super 8 Top 10 Error API presenter.
 *
 * @package app
 * @extends Presenter_API
 */

// The Presenter_API class includes Model\Validator already
// use \Model\Validator;
class Presenter_API_combined_super8_errors_Top10 extends Presenter_API_Template
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
            *   /api/combined/super8/errors/top10/2017-05-16         Top 10 errors at Super8 (all platforms) on May 16, 2017
            *   /api/combined/super8/errors/top10/cLinear/2017-05-25    Top 10 errors at Super8 (cLinear) on May 25, 2017
            *   /api/combined/super8/errors/top10/    Top 10 errors at Super8 (cLinear) on all days
        */


        // Ingest normalized application parameters from the URL
        $platform = $this->ingestParameter('platform');
        $dateStart = $this->ingestParameter('start');
        $dateEnd   = $this->ingestParameter('end');


        // Query the database using the info needed for this API, connecting to daily data of t6c
        $response = $this->selectDataByDateRangeAndExtraFields(
            'viper_super8Daily',                     // DB Connection Label (from app config)
            'Super8Top10Error',                              // DB Table Name (MySQL)
            'date_created',                     // DB Field Name for dates
            $dateStart,                         // The actual start date ingested above
            $dateEnd,                           // The actual end date ingested above
            ['Delivery_Lane'=> $platform] //[db field name] => variable name
        );

        // Add to the response array (data is raw data)
        $this->response = array('data' => NULL);

        // Write the response data for consumption by the client
        $this->response['data'] = $this->createArrayBucketsByField($response['data'], 'date_created');
    }

}
