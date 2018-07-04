<?php

/**
 * The API Number presenter.
 *
 * @package app
 * @extends Presenter_API
 */

// The Presenter_API class includes Model\Validator already
// use \Model\Validator;
class Presenter_API_cLinear_Transcoder_Continuity_Hot extends Presenter_API_cLinear_Template
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
                    *   /api/clinear/pillar/hot                All dates in all regions
         */

        // Ingest normalized application parameters from the URL
        $dateStart = $this->ingestParameter('start');
        $dateEnd   = $this->ingestParameter('end');
        $count     = $this->ingestParameter('count');     // The number of issues

        // Query the database using the info needed for this API for nat 10
        $responseTranscoderHotContinuity10 = $this->selectDataByDateRangeAndHot(
            'viper_clinear_new',              // DB Connection Label (from app config)
            'transcoder_continuity_worst10',     // DB Table Name (MySQL)
            'failed',                           // Required: The field in the $dbTable that we'll sort on to get the hottest items (i.e. minutes impacted)
            'date_created',                     // DB Field Name for dates
            $dateStart,                         // The actual start date ingested above
            $dateEnd,                           // The actual end date ingested above
            $count                              // The actual number ingested above
        );

        // Add to the response array (data is raw data)
        $this->response = array('data' => NULL);

        // Build response array, bucket by date
        $this->response['data'] = array(
                                   'responseTranscoderHotContinuity10' => $this->createArrayBucketsByField(
                                       $responseTranscoderHotContinuity10['data'],
                                       'date_created'
                                   ),
                                  );
    }


}
