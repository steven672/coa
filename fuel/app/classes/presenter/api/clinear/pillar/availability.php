<?php

/**
 * The API Number presenter.
 *
 * @package app
 * @extends Presenter_API
 */

// The Presenter_API class includes Model\Validator already
// use \Model\Validator;
class Presenter_API_cLinear_Pillar_Availability extends Presenter_API_cLinear_Template
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
            *   /api/clinear/Pillar/availability/2017-01-01/2017-01-10         From January 1, 2017 to January 10, 2017 in all Pillar Manual Restart Worst 10 data (YYYY-MM-DD)
         */

        // Ingest normalized application parameters from the URL
        $dateStart = $this->ingestParameter('start');
        $dateEnd   = $this->ingestParameter('end');

        // Query the database using the info needed for this API
        $responseIncidents = $this->selectDataByDateRangeAndSortExtraField(
            'viper_clinear_new',               // DB Connection Label (from app config)
            'pillar',                          // DB Table Name (MySQL)
            'average_errorfree_time_percentage', // DB extra field to be sorted
            'date_created',                    // DB Field Name for dates
            $dateStart,                        // The actual start date ingested above
            $dateEnd                           // The actual end date ingested above
        );

        // Add to the response array (data is raw data)
        $this->response = array('data' => NULL);

        // Write the response data for consumption by the client
        $this->response['data'] = $this->createArrayBucketsByField($responseIncidents['data'], 'date_created');
    }


}
