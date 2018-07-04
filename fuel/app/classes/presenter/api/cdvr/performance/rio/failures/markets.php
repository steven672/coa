<?php

/**
 * The API Rio presenter.
 *
 * @package app
 * @extends Presenter_API
 */

// The Presenter_API class includes Model\Validator already
// use \Model\Validator;
// Presenter_API_Template extends Presenter
class Presenter_API_cDVR_Performance_Rio_Failures_Markets extends Presenter_API_cDVR_Template
{

    // Valid region IDs for this table (pairs of database code, human readable name)
    // Matches with the "region" db column
    // db keys should be given as lowercase
    public $listOfRegions;


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
            *   /api/cdvr/rio/sites                    All dates in all regions
            *   /api/cdvr/rio/sites/2017-01-01         January 1, 2017 in all regions (YYYY-MM-DD)
            *   /api/cdvr/rio/sites/2017-01-01/albq    January 1, 2017 in albq region only
            *   /api/cdvr/rio/sites/2017-01-01/all     January 1, 2017 in all regions (YYYY-MM-DD)
            *   /api/cdvr/rio/sites/all/albq           All dates in albq region only
            *   /api/cdvr/rio/sites/all/all            All dates in all regions
         */

        // Set up the region list
        $this->listOfRegions = (new Model_RegionList())->listAllRio();

        // Ingest normalized application parameters from the URL
        $dateStart = $this->ingestParameter('start');
        $dateEnd = $this->ingestParameter('end');
        $region = $this->ingestParameter('region');


        // SELECT * FROM comcast_rio.Rio_recording_status;

        // Query the database using the info needed for this API
        $responseRio = $this->selectDataByDateRangeAndRegion(
            'comcast_rio',                  // DB Connection Label (from app config)
            'Rio_recording_status',         // DB Table Name (MySQL)
            'date_created',                 // DB Field Name for dates
            $dateStart,                     // The actual start date ingested above
            $dateEnd,                       // The actual end date ingested above
            'market',                       // DB Field Name for locations ('site' : CS,DDN,Recorders; 'region' : Rio)
            $region,                        // The actual region ingested above
            'status',                       // The region field in listOfRegions array, compare to DB region field
            $this->listOfRegions            // The listOfRegions array to compare
        );

        // extract successes and failures from each market
        $totalRecordingsArray = array_column($responseRio['data'], 'recording_total');
        $failuresArray = array_column($responseRio['data'], 'recording_failed');

        // sum the successes into one variable and the failures into another
        $totalRecordingsSummed = array_sum($totalRecordingsArray);
        $failuresSummed = array_sum($failuresArray);

        // calculate the success and failure rates
        $successRate = ($totalRecordingsSummed / ($totalRecordingsSummed + $failuresSummed));
        $failureRate = ($failuresSummed / ($totalRecordingsSummed + $failuresSummed));

        $responseRio['totalRecordingsSummed'] = $totalRecordingsSummed;
        $responseRio['failuresSummed'] = $failuresSummed;
        $responseRio['successRate'] = $successRate;
        $responseRio['failureRate'] = $failureRate;

        // map the raw site name text to more user friendly/readable text using the $listOfRegionsRio array.
        foreach ($responseRio['data'] as $key => $value)
        {
            $region = $this->findSubArrayByValue($responseRio['regions'], 'status', $value['market']);
            $responseRio['data'][$key]['market'] = $region['text'];;
        }

        unset($responseRio['regions']);

        $this->set(
            'response',
            $responseRio
        );

    }


}
