<?php

/**
 * The cLinear Varnish Hot API presenter.
 *
 * @package app
 * @extends Presenter_API
 */

// The Presenter_API class includes Model\Validator already
// use \Model\Validator;
class Presenter_API_cLinear_Varnish_Hot extends Presenter_API_cLinear_Template
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
            *   /api/clinear/varnish/hot/10/2017-01-01/2017-01-10         Top 10 issues from January 1, 2017 to January 10, 2017
         */

        // Ingest normalized application parameters from the URL
        $count     = $this->ingestParameter('count');
        $dateStart = $this->ingestParameter('start');
        $dateEnd   = $this->ingestParameter('end');

        // Query the database using the info needed for this API for nat 10
        $responseVarnishHotNat10 = $this->selectDataByDateRangeAndHot(
            'viper_clinear_new',                // DB Connection Label (from app config)
            'varnish_nat_worst10',              // DB Table Name (MySQL)
            'httperror',                        // Required: The field in the $dbTable that we'll sort on to get the hottest items (i.e. minutes impacted)
            'date_created',                     // DB Field Name for dates
            $dateStart,                         // The actual start date ingested above
            $dateEnd,                           // The actual end date ingested above
            $count                              // The actual number ingested above
        );

        // query for regional worst 10
        $responseVarnishHotReg10 = $this->selectDataByDateRangeAndHot(
            'viper_clinear_new',                // DB Connection Label (from app config)
            'varnish_reg_worst10',              // DB Table Name (MySQL)
            'httperror',                        // Required: The field in the $dbTable that we'll sort on to get the hottest items (i.e. minutes impacted)
            'date_created',                     // DB Field Name for dates
            $dateStart,                         // The actual start date ingested above
            $dateEnd,                           // The actual end date ingested above
            $count                              // The actual number ingested above
        );

        // query for regional worst 10
        $responseVarnishHotReg5 = $this->selectDataByDateRangeAndHot(
            'viper_clinear_new',                // DB Connection Label (from app config)
            'varnish_worst5_streams',           // DB Table Name (MySQL)
            'pcount',                           // Required: The field in the $dbTable that we'll sort on to get the hottest items (i.e. minutes impacted)
            'date_created',                     // DB Field Name for dates
            $dateStart,                         // The actual start date ingested above
            $dateEnd,                           // The actual end date ingested above
            $count                              // The actual number ingested above
        );

        // Add to the response array (data is raw data)
        $this->response = array('data' => NULL);

        // Build response array, bucketize by date
        $this->response['data'] = array(
                                   'NATWorst10' => $this->createArrayBucketsByField($responseVarnishHotNat10['data'], 'date_created'),
                                   'RegWorst10' => $this->createArrayBucketsByField($responseVarnishHotReg10['data'], 'date_created'),
                                   'RegWorst5'  => $this->createArrayBucketsByField($responseVarnishHotReg5['data'], 'date_created'),
                                  );
    }


}
