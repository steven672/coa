<?php

/**
 * The API Stream Scanner Issues presenter.
 *
 * @package app
 * @extends Presenter
 */

// The Presenter_API class includes Model\Validator already
// use \Model\Validator;
class Presenter_API_cLinear_Sscanner_Hot_Cox extends Presenter_API_cLinear_Template
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
            * Ingest the start date, end date, and  and region variables
            * The URL formats for these variables are specified in the /app/config/routes.php file
            * For this API endpoint, both date and region are optional variables
            * Valid URL calls:
            *   /api/clinear/sscanner/hot                All dates in all regions
         */

        // Ingest normalized application parameters from the URL
        $dateStart = $this->ingestParameter('start');
        $dateEnd   = $this->ingestParameter('end');
        $count     = $this->ingestParameter('count');     // The number of issues

        // Query the database using the info needed for this API
        $responseWorst10Cox = $this->selectDataByDateRangeAndHot(
            'viper_watermark',                  // DB Connection Label (from app config)
            'Wworst10',                         // DB Table Name (MySQL)
            'down',                             // Required: The field in the $dbTable that we'll sort on to get the hottest items (i.e. minutes impacted)
            'date_created',                     // DB Field Name for dates
            $dateStart,                         // The actual start date ingested above
            $dateEnd,                           // The actual end date ingested above
            $count                              // The actual number of items to return, ingested above
        );

        // Add to the response array (data is raw data)
        $this->response = array('data' => NULL);

        // Build response array, bucket by date
        $this->response['data'] = array(
                                   'responseWorst10Cox' => $this->createArrayBucketsByField($responseWorst10Cox['data'], 'date_created'),
                                  );
    }


}

;
