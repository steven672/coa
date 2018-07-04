<?php
/**
 * The API Number presenter.
 *
 * @package app
 * @extends Presenter_API
 */
// The Presenter_API class includes Model\Validator already
// use \Model\Validator;
class Presenter_API_Combined_Super8_Errors_iVOD extends Presenter_API_Combined_Template
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
            *   /api/combined/super8/errors/ivod/2017-04-04/2017-04-05         From April 04, 2017 to April 05, 2017 in all ivods  deliver_Lane counts data (YYYY-MM-DD)
            */

        // Ingest normalized application parameters from the URL
        $dateStart = $this->ingestParameter('start');
        $dateEnd   = $this->ingestParameter('end');

        // Query the database using the info needed for this API
        $responseAverageAvailibility = $this->selectDataForCombinedSuper8DailyErrorscDVR(
            'viper_super8Daily',                // DB Connection Label (from app config)
            $dateStart,                         // The actual start date ingested above
            $dateEnd                            // The actual end date ingested above

        );

        // Add to the response array (data is raw data)
        $this->response = array('data' => NULL);
        // Build response array, bucketize by date
        $this->response['data'] = $this->createArrayBucketsByField($responseAverageAvailibility['data'], 'date');
    }


    // Query the database for the average availability data for the date/range specified
    protected function selectDataForCombinedSuper8DailyErrorscDVR(
        $dbConnection = NULL,
        // Required: The database connection object to use (maps to objects specified in /fuel/app/config/{development|production|test}/db.php)
        $dateProvidedStart = NULL,
        // Required: The date to search for (may be a wildcard '%') or the start date if specifying a range; cannot be null
        $dateProvidedEnd = NULL

    )
    {
        // Create the query builder object
        // The array() notation provides aliases for fields
        // DB::select(array('a.cfacility', 'facility'))->from(array('comcast_viper_clinear_new.pillar', 'a'));
        // SELECT 'a.cfacility' 'facility' FROM 'comcast_viper_clinear_new.pillar' 'a'
        $queryBuilderObject = DB::select(
            array(
             'Delivery_Lane',
             'Delivery_Lane',
            ),
            array(
             'count',
             'count',
            ),
            array(
             'date_created',
             'date',
            )
        );

        // Specify the original table
        $queryBuilderObject->from(array('super8Daily.TopDeliveryLanesWithMostErrors', 'a'));

        // Refine the query by adding a date or date range check (exit the function with null if this fails)
        if (is_null($queryBuilderObject = $this->queryWhereDateOrRange($queryBuilderObject, $dbFieldDate = 'date_created', $dateProvidedStart, $dateProvidedEnd))) return NULL;

        //echo DB::last_query();
         $queryBuilderObject->and_where('Delivery_Lane','like','iVOD');

        // Sort the results
        $queryBuilderObject->order_by('count', 'desc');

        // Execute the query builder object and return the result set
        return array('data' => $this->queryRunUsingConnection($queryBuilderObject, $dbConnection));
    }


}
