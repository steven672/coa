<?php

/**
 * The API Resolved-Incidents presenter.
 *
 * @package app
 * @extends Presenter
 */

// The Presenter_API class includes Model\Validator already
// use \Model\Validator;
class Presenter_API_cLinear_Incidents_Resolved extends Presenter_API_cLinear_Template
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
            *   /api/cdvr/legacy/ddn/sites                    All dates in all regions
            *   /api/cdvr/legacy/ddn/sites/2017-01-01         January 1, 2017 in all regions (YYYY-MM-DD)
            *   /api/cdvr/legacy/ddn/sites/2017-01-01/albq    January 1, 2017 in albq region only
            *   /api/cdvr/legacy/ddn/sites/2017-01-01/all     January 1, 2017 in all regions (YYYY-MM-DD)
            *   /api/cdvr/legacy/ddn/sites/all/albq           All dates in albq region only
            *   /api/cdvr/legacy/ddn/sites/all/all            All dates in all regions
         */

        // Ingest normalized application parameters from the URL
        $dateStart = $this->ingestParameter('start');
        $dateEnd   = $this->ingestParameter('end');

        // Query the database using the info needed for this API
        $responseIncidents = $this->selectDataByDateRange(
            'jira_metrics',                     // DB Connection Label (from app config)
            'Impacted_Service_Weekly',          // DB Table Name (MySQL)
            'date_created',                     // DB Field Name for dates
            $dateStart,                         // The actual start date ingested above
            $dateEnd                            // The actual end date ingested above
        );

        // Add to the response array (data is raw data)
        $this->response = array('data' => NULL);

        // Write the response data for consumption by the client
        $this->response['data'] = $this->createArrayBucketsByField($responseIncidents['data'], 'date_created');
    }


}

;
