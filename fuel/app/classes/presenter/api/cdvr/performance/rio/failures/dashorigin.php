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
class Presenter_API_cDVR_Performance_Rio_Failures_DASHOrigin extends Presenter_API_cDVR_Template
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
            'RioRecordingFailuresByMarket@DASHOrigin',         // DB Table Name (MySQL)
            'date_created',                 // DB Field Name for dates
            $dateStart,                     // The actual start date ingested above
            $dateEnd,                       // The actual end date ingested above
            'cRegion',                       // DB Field Name for locations ('site' : CS,DDN,Recorders; 'region' : Rio)
            $region,                        // The actual region ingested above
            'failures',                       // The region field in listOfRegions array, compare to DB region field
            $this->listOfRegions            // The listOfRegions array to compare
        );


        $regionArray = array();

        foreach ($responseRio['data'] as $key => $value)
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

        $uniqueErrorCodes = array_unique(array_map(function ($i) { return $i['code']; }, $responseRio['data']));
        $uniqueErrorDescriptions = array_unique(array_map(function ($i) { return $i['msg']; }, $responseRio['data']));

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

        // // Write the response data for consumption by the client
        // $this->response = array(
        //                    'regions' => $this->listOfRegions,
        //                    'data'    => $responseRio['data'],
        //                   );


        // $array = $this->response['data'];

        // $regionArray = array();
        // foreach ($array as $key => $value) {
        //     $regionKey = $value['cRegion'].'|'.$value['date_created'];
        //     if (! isset($regionArray[$regionKey]))
        //     {
        //         $value[$value['code']] = $value['count'];
        //         $value[$value['msg']] = $value['count'];
        //         unset($value['msg']);
        //         $regionArray[$regionKey] = $value;
        //     }
        //     else
        //     {
        //         $regionArray[$regionKey][$value['code']] = $value['count'];
        //         $regionArray[$regionKey][$value['msg']] = $value['count'];
        //     }
        // }

        // $arrayNumericIndexes = array_values($regionArray);


        // $uniqueErrorCodes = array_unique(array_map(function ($i) { return $i['code']; }, $this->response['data']));
        // $uniqueErrorDescriptions = array_unique(array_map(function ($i) { return $i['msg']; }, $this->response['data']));


        // // TODO? - Concatenate $uniqueErrorCodes and $uniqueErrorDescriptions into one array, and use one foreach loop.

        // foreach($uniqueErrorCodes as $errorCode){
        //     foreach ($arrayNumericIndexes as $rioMarket => $lineItems) {
        //         if (!array_key_exists($errorCode, $lineItems))
        //         {
        //             $arrayNumericIndexes[$rioMarket][$errorCode] = 0;
        //         }
        //         ksort($arrayNumericIndexes[$rioMarket]);
        //      }
        //  }

        // foreach($uniqueErrorDescriptions as $errorCodeDescriptions){
        //     foreach ($arrayNumericIndexes as $rioMarket => $lineItems) {
        //         if (!array_key_exists($errorCodeDescriptions, $lineItems))
        //         {
        //             $arrayNumericIndexes[$rioMarket][$errorCodeDescriptions] = 0;
        //         }
        //         ksort($arrayNumericIndexes[$rioMarket]);
        //      }
        //  }

        // $this->response['newArray'] = $this->createArrayBucketsByField($arrayNumericIndexes, 'date_created');

        // // include list of error codes and error descriptions in separate response variables
        // $this->response['errorCodes'] = $uniqueErrorCodes;
        // $this->response['errorDescriptions'] = $uniqueErrorDescriptions;

    }

}
