<?php

/**
 * The API Number presenter.
 *
 * @package app
 * @extends Presenter_API
 */

// The Presenter_API class includes Model\Validator already
// use \Model\Validator;
class Presenter_API_cDVR_Performance_Rio_c3rm_Trend extends Presenter_API_cDVR_Template
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
        $responseC3Trend = $this->selectDataByDateRangeAndSortExtraField(
            'comcast_rio',                                                          // DB Connection Label (from app config)
            'RecordingPlaybackFails@C3RecorderManager',                             // DB Table Name (MySQL)
            'count',                                                                // DB extra field to be sorted
            'date_created',                                                         // DB Field Name for dates
            $dateStart,                                                             // The actual start date ingested above
            $dateEnd                                                                // The actual end date ingested above
        );

        // Add to the response array (data is raw data)
        // Write the response data for consumption by the client
        $this->response = array('data'    => $responseC3Trend['data'],);

        $array = $this->response['data'];
        $regionArray = array();

        foreach ($array as $key => $value) {
            $regionKey = $value['cRegion'].'|'.$value['date_created'];
            if ( !array_key_exists($regionKey, $regionArray) )
            {
                unset($value['msg']);                                               // remove uncessary items, keep the error code count and cRegion information.
                unset($value['REASON']);
                $value[$value['CODE']] = intval($value['count']);
                unset($value['count']);
                unset($value['CODE']);
                $regionArray[$regionKey] = $value;
            }
            else
            {
                $regionArray[$regionKey][$value['CODE']] = array_key_exists($value['CODE'], $regionArray[$regionKey]) ? $regionArray[$regionKey][$value['CODE']] + intval($value['count']) : intval($value['count']) ;
            }
        }

        $arrayNumericIndexes = array_values($regionArray);

        // Write the response data for consumption by the client
        $this->response['data'] = $this->createArrayBucketsByField($arrayNumericIndexes, 'date_created');
    }


}
