<?php

/**
 * The API Duplicates presenter.
 *
 * @package app
 * @extends Presenter_API
 */

// The Presenter_API class includes Model\Validator already
// use \Model\Validator;
class Presenter_API_Player_Overallavailability extends Presenter_API_Template
{


    /**
     * Prepare the view data, keeping this in here helps clean up
     * the controller.
     *
     * @return void
     */

    /**
     * @return userinformation
     */

    public function view()
    {
        /*
            * Ingest the date and region variables
            * The URL formats for these variables are specified in the /app/config/routes.php file
            * For this API endpoint, number of days is optional
            * Valid URL calls:
            *   /api/player/trendregion/         For the last 30 days, return player data aggregated by region
            *.  /api/player/trendregion/7/.      For the last 7 days, return player data aggregated by region
         */

        // Ingest normalized application parameters from the URL
        $dateStart = $this->ingestParameter('start');
        $dateEnd   = $this->ingestParameter('end');
        $dbConnection = 'headwaters';
        $dbTable = 'headwaters_stream_daily_events';
        $dbFieldDate = 'date';
        $dateProvidedStart = $dateStart;
        $dateProvidedEnd = $dateEnd;

        // Create the query builder object (exit the function with null if this fails)
        if (!is_null($dbTable))
        {
            // Set up the query and return the new query builder object
            $queryBuilderObject =
                DB::select(
                    $dbFieldDate,
                    array(DB::expr('sum(succeeded_devices) / (sum(succeeded_devices) + sum(failed_devices))'), 'device_availability'),
                    array(DB::expr('avg(success_rate)'), 'success_rate')
                )->from($dbTable)->group_by($dbFieldDate);
        }
        else
        {
            return null;
        }



        // Refine the query by adding a date or date range check (exit the function with null if this fails)
        if (is_null($queryBuilderObject = $this->queryWhereDateOrRange($queryBuilderObject, $dbFieldDate, $dateProvidedStart, $dateProvidedEnd))) return null;

        // Execute the query builder object and return the result set
        $responsePlayerAvailability = array('data' => $this->queryRunUsingConnection($queryBuilderObject, $dbConnection));

        // Add to the response array (data is raw data)
        $this->response = array('data' => NULL);

        // Build response array, bucketize by date
        $this->response['data'] = $this->createArrayBucketsByField($responsePlayerAvailability['data'], 'date');

    }

}
