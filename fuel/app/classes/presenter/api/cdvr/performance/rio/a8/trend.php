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
class Presenter_API_cDVR_Performance_Rio_A8_Trend extends Presenter_API_cDVR_Template
{

    /**
     * Prepare the view data, keeping this in here helps clean up
     * the controller.
     *
     * @return void
     */


     // Valid region IDs for this table (pairs of database code, human readable name)
    // Matches with the "region" db column
    // // db keys should be given as lowercase
    // public $listOfRegions;

    public function view()
    {
        /*
            * Ingest the date and region variables
            * The URL formats for these variables are specified in the /app/config/routes.php file
            * For this API endpoint, bdate is optional variables
            * Valid URL calls:
            * dev-coa/api/cdvr/performance/rio/a8/trend/2017-05-31
         */
       // Set up the region list
        // $this->listOfRegions = (new Model_RegionList())->listAllRio();

        // Ingest normalized application parameters from the URL
        $dateStart = $this->ingestParameter('start');
        $dateEnd   = $this->ingestParameter('end');


        // Query the database using the info needed for this API
        $responseA8Trend = $this->selectDataByDateRangeAndSortExtraField(
            'comcast_rio',                  // DB Connection Label (from app config)
            'rio_RegionLevelErrors@A8ScheduleUpdater',     // DB Table Name (MySQL)
            'code',
            'date_created',                     // DB Field Name for dates
            $dateStart,                         // The actual start date ingested above
            $dateEnd                           // The actual end date ingested abov
        );

        $regionArray = array();

        foreach ($responseA8Trend['data'] as $key => $value)
        {
            $regionKey = $value['cRegion'].'|'.$value['date_created'];

            if (!isset($regionArray[$regionKey]))
            {
                $regionArray[$regionKey] =
                [
                    'cRegion' => $value['cRegion'],
                    'date_created' => $value['date_created'],
                    $value['code'] => $value['count'],
                ];
            }
            else
            {
                $regionArray[$regionKey][$value['code']] = $value['count'];
            }
        }

        $regionArray = array_values($regionArray);

        $uniqueErrorCodes = array_unique(array_map(function ($i) { return $i['code']; }, $responseA8Trend['data']));
        $uniqueErrorDescriptions = array_unique(array_map(function ($i) { return $i['msg']; }, $responseA8Trend['data']));

        $newErrorCodeList = array();

        foreach ($uniqueErrorCodes as $codeIndex => $errorCode)
        {
            $newErrorCodeList[$errorCode] = array(
                'text' => (array_key_exists($codeIndex, $uniqueErrorDescriptions) ? $uniqueErrorDescriptions[$codeIndex] : null),
                'count' => 0,
                'regions' => array()
            );

            foreach ($regionArray as $regionIndex => $region)
            {
                if (array_key_exists($errorCode, $region))
                {
                    // This error code occured in this region

                    // Increment the total count for this error code
                    $newErrorCodeList[$errorCode]['count'] += $region[$errorCode];

                    // Add the region to the list for this error
                    if (!(array_key_exists($region['cRegion'], $newErrorCodeList[$errorCode]['regions'])))
                    {
                        $newErrorCodeList[$errorCode]['regions'][$region['cRegion']] = array();
                    }

                    // Add the date when these errors occurred in this region, with the number of errors that occurred
                    $newErrorCodeList[$errorCode]['regions'][$region['cRegion']][$region['date_created']] = $region[$errorCode];
                }
            }
        }

        // Pass the result to the view
        $this->set(
            'response',
            array(
                'data' => $this->createArrayBucketsByField($regionArray, 'date_created'),
                'errorCodes' => $newErrorCodeList
            )
        );
    }

}
