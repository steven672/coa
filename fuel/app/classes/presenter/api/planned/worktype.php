<?php

/**
 * The API Duplicates presenter.
 *
 * @package app
 * @extends Presenter_API
 */

// The Presenter_API class includes Model\Validator already
// use \Model\Validator;
class Presenter_API_Planned_WorkType extends Presenter_API_Template
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
            *   /api/worktype/2017-05-02         RCA Planned word completed On 05/02/2017 (YYYY-MM-DD)
            *   /api/worktype/Root Cause Analysis/2017-05-02         RCA Planned word completed On 05/02/2017 (YYYY-MM-DD)
            *   /api/worktype/Root Cause Analysis/2017-05-11/2017-05-27         RCA Planned word completed between 05/11/2017 and 05-27-2017 (YYYY-MM-DD)
          */

        // Ingest normalized application parameters from the URL
        $request = $this->ingestParameter('request');
        $dateStart = $this->ingestParameter('start');
        $dateEnd   = $this->ingestParameter('end');

        // Query the database using the info needed for this API, connecting to daily data of t6c
        $response = $this->selectDataByDateRangeAndExtraFields(
            'comcast_viper_jiraccpplannedwork',                     // DB Connection Label (from app config)
            'VOPSPlannedWork',                              // DB Table Name (MySQL)
            'date_created',                     // DB Field Name for dates
            $dateStart,                         // The actual start date ingested above
            $dateEnd,                           // The actual end date ingested above
            ['VOPSRequestType'=> $request]      //[db field name] => variable name
        );


        $this->response = array('data' => NULL);
        // Write the response data for consumption by the client
        $this->response['data'] = $this->createArrayBucketsByField($response['data'], 'date_created');
    }


}
