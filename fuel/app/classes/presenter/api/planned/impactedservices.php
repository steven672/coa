<?php

/**
 * The API Duplicates presenter.
 *
 * @package app
 * @extends Presenter_API
 */

// The Presenter_API class includes Model\Validator already
// use \Model\Validator;
class Presenter_API_Planned_Impactedservices extends Presenter_API_Template
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
            *   /api/planned/impactedservices/all/2017-05-02         On 05/02/2017 in all Impacted services (YYYY-MM-DD)
            *   /api/planned/impactedservices/all                      All dates and  all Impacted services (YYYY-MM-DD)
          */

        // Ingest normalized application parameters from the URL
        $platform = $this->ingestParameter('platform');
        $dateStart = $this->ingestParameter('start');
        $dateEnd   = $this->ingestParameter('end');

        // Query the database using the info needed for this API, connecting to daily data of t6c
        $response = $this->selectDataByDateRangeAndExtraFields(
            'comcast_viper_jiraccpplannedwork',                     // DB Connection Label (from app config)
            'VOPSPlannedWork',                              // DB Table Name (MySQL)
            'date_created',                     // DB Field Name for dates
            $dateStart,                         // The actual start date ingested above
            $dateEnd,                           // The actual end date ingested above
            ['VOPSImpactedServices'=> $platform] //[db field name] => variable name

        );


        $this->response = array('data' => NULL);
        // Write the response data for consumption by the client
        $this->response['data'] = $this->createArrayBucketsByField($response['data'], 'date_created');
    }


}
