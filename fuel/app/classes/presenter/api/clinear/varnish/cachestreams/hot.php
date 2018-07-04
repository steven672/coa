<?php

/**
 * The cLinear Varnish Hot API presenter.
 *
 * @package app
 * @extends Presenter_API
 */

// The Presenter_API class includes Model\Validator already
// use \Model\Validator;
class Presenter_API_cLinear_Varnish_Cachestreams_Hot extends Presenter_API_cLinear_Template
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
        $hotArray  = array('efficiency' => 'desc', 'fail' => 'desc');

        // Query the database using the info needed for this API for worst  10 failed streams
        $responseVarnishHotCacheStreams10 = $this->selectDataByDateRangeAndCountAndSortExtraField(
            'viper_clinear_new',                // DB Connection Label (from app config)
            'VarnishWorst10CacheStreams',       // DB Table Name (MySQL)
            'date_created',                     // DB Field Name for dates
            $dateStart,                         // The actual start date ingested above
            $dateEnd,                           // The actual end date ingested above
            $count,                             // The actual number ingested above
            $hotArray                          // Required: The field in the $dbTable that we'll sort on to get the hottest items, based on the index order, desc (i.e. efficiency fail)
        );

        // Add to the response array (data is raw data)
        $this->response = array('data' => NULL);

        // Build response array, bucket by date
        $this->response['data'] =
                 array(
                       'responseVarnishHotCacheStreams10' => $this->createArrayBucketsByField(
                           $responseVarnishHotCacheStreams10['data'],
                           'date_created'
                       ),
                      );

    } // End of Function View


}
