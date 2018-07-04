<?php

/**
 * The API Pillar Panics presenter.
 *
 * @package app
 * @extends Presenter_API
 */

// The Presenter_API class includes Model\Validator already
// use \Model\Validator;
class Presenter_API_cLinear_Pillar_Panics extends Presenter_API_cLinear_Template
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
            * Ingest the date and count variables
            * The URL formats for these variables are specified in the /app/config/routes.php file
            * For this API endpoint, both end date and count are optional variables (count defaults to 'all')
            * Valid URL calls:
            *   /api/clinear/pillar/panics/2017-01-01/2017-01-10
         */

        // Ingest normalized application parameters from the URL
        $count     = $this->ingestParameter('count');
        $dateStart = $this->ingestParameter('start');
        $dateEnd   = $this->ingestParameter('end');

        // Query the database using the info needed for this API
        $responseIncidents = $this->selectDataByDateRangeAndCount(
            'viper_clinear_new',                            // DB Connection Label (from app config)
            'pillar_panic_per_facility_region',             // DB Table Name (MySQL)
            'date_created',                                 // DB Field Name for dates
            $dateStart,                                     // The actual start date ingested above
            $dateEnd,                                       // The actual end date ingested above
            $count                                          // the actual 'number of items' variable ingested above
        );

        // Add to the response array (data is raw data)
        $this->response = array('data' => NULL);

        // Write the response data for consumption by the client
        $this->response['data'] = $this->createArrayBucketsByField($responseIncidents['data'], 'date_created');
    }


}
