<?php

/**
 * The API Throughput presenter.
 *
 * @package  app
 * @extends  Presenter_API
 */

// The Presenter_API class includes Model\Validator already
// use \Model\Validator;

// Presenter_API_Template extends Presenter

class Presenter_API_cDVR_Rio_Trending extends Presenter_API_cDVR_Template
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
        /**
         * Ingest the date and region variables
         * The URL formats for these variables are specified in the /app/config/routes.php file
         * For this API endpoint, both date and region are optional variables
         * Valid URL calls:
         *   /api/cdvr/rio/trending                               All dates in all regions
         *   /api/cdvr/rio/trending/2016-07-15/2017-01-16         Specific date range in all regions (YYYY-MM-DD)
         *   /api/cdvr/rio/trending/2016-07-15/2017-01-16/albq    Specific date range in albq region only
         *   /api/cdvr/rio/trending/all/all/all                   All dates in all regions
         */

        // Set up the region list
        $this->listOfRegions = (new Model_RegionList())->listAllRio();

        // Ingest normalized application parameters from the URL
        $dateStart = $this->ingestParameter('start');
        $dateEnd = $this->ingestParameter('end');
        $region = $this->ingestParameter('region');

        // Query the database using the info needed for this API
        $responseRio = $this->selectDataByDateRangeAndRegion(
            'ddn_stat',                     // DB Connection Label (from app config)
            'cleversafe_sites_rio',         // DB Table Name (MySQL)
            'date',                         // DB Field Name for dates
            $dateStart,                     // The actual start date ingested above
            $dateEnd,                       // The actual end date ingested above
            'site',                         // DB Field Name for locations ('site' : CS,DDN,Recorders; 'region' : Rio)
            $region,                        // The actual region ingested above
            'rio',                          // The region field in listOfRegions array, compare to DB region field
            $this->listOfRegions            // The listOfRegions array to compare
        );

        // Build response array
        $this->response = array(
            'regions' => $this->listOfRegions,
            'data' => array()
            );

        // Iterate over region list from CS, using normalized region names
        foreach($responseRio['data'] as $index => $data)
        {
            // Map this db region to the main regions plain text
            $region = $this->findSubArrayByValue($responseRio['regions'], 'rio', $data['site']);
            $regionName = $region['text'];

            // Create the response->region data key if it doesn't exist
            if (!array_key_exists($regionName, $this->response['data']))
            {
                $this->response['data'][$regionName] = array();
            }

            // Create the response->region->date key if it doesn't exist
            if (!array_key_exists($data['date'], $this->response['data'][$regionName]))
            {
                $this->response['data'][$regionName][$data['date']] = array();
            }

            // Put the day's utilization ratio into the response->region->date->cs value
            $this->response['data'][$regionName][$data['date']]['total'] = $this->stringDivision($data['total_used_capacity'], $data['total_usable_capacity']);
        }

        // Sort each dataset by date
        foreach($this->response['data'] as $key => $array)
        {
            ksort($this->response['data'][$key]);
        }
    }

    // Search a given array and return the element with the desired value
    public function findSubArrayByValue($searchArray, $searchSubKey, $searchValue)
    {
        foreach ($searchArray as $key => $subArray)
        {
            if (strtolower($subArray[$searchSubKey]) === strtolower($searchValue))
            {
                return $subArray;
            }
        }
    }
}

?>