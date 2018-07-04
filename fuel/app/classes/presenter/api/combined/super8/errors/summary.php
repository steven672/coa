<?php
/**
 * The API Number presenter.
 *
 * @package app
 * @extends Presenter_API
 */
// The Presenter_API class includes Model\Validator already
// use \Model\Validator;
class Presenter_API_Combined_Super8_Errors_Summary extends Presenter_API_Combined_Template
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
            *   /api/combined/super8/errors/summary/5/2017-01-01/2017-01-10         From January 1, 2017 to January 10, 2017 in all viper  top 5 data (YYYY-MM-DD)
            */

        // Ingest normalized application parameters from the URL
        $count     = $this->ingestParameter('count');
        $region    = $this->ingestParameter('region');
        $dateStart = $this->ingestParameter('start');
        $dateEnd   = $this->ingestParameter('end');

        // Query the database using the info needed for this API
        $responseAverageAvailibility = $this->selectDataForCombinedSuper8DailyErrorsSummaryByRegion(
            'viper_super8Daily',                // DB Connection Label (from app config)
            $dateStart,                         // The actual start date ingested above
            $dateEnd,                            // The actual end date ingested above
            $count,                               // The limit count for the items
            $region
        );

        // Add to the response array (data is raw data)
        $this->response = array('data' => NULL);
        // Build response array, bucketize by date
        $this->response['data'] = $this->createArrayBucketsByField($responseAverageAvailibility['data'], 'date');
    }


    // Query the database for the average availability data for the date/range specified
    protected function selectDataForCombinedSuper8DailyErrorsSummaryByRegion(
        $dbConnection = NULL,
        // Required: The database connection object to use (maps to objects specified in /fuel/app/config/{development|production|test}/db.php)
        $dateProvidedStart = NULL,
        // Required: The date to search for (may be a wildcard '%') or the start date if specifying a range; cannot be null
        $dateProvidedEnd = NULL,
        // Opt: The end date if a date range is provided
        $limit=10,                          // Opt: The total num items will be listed
        $region
    )
    {
        // Create the query builder object
        // The array() notation provides aliases for fields
        // DB::select(array('a.cfacility', 'facility'))->from(array('comcast_viper_clinear_new.pillar', 'a'));
        // SELECT 'a.cfacility' 'facility' FROM 'comcast_viper_clinear_new.pillar' 'a'
        $queryBuilderObject = DB::select(
            array(
             'cRegion',
             'cRegion',
            ),
            array(
             'Delivery_Lane',
             'Delivery_Lane',
            ),
            array(
             'Error_Code',
             'Error_Code',
            ),
            array(
             'count',
             'count',
            ),
            array(
             'percent',
             'percent',
            ),
            array(
             'date_created',
             'date',
            )
        );

        // Specify the original table
        $queryBuilderObject->from(array('super8Daily.Super8Top10ErrorByRegion', 'a'));

        // Refine the query by adding a date or date range check (exit the function with null if this fails)
        if (is_null($queryBuilderObject = $this->queryWhereDateOrRange($queryBuilderObject, $dbFieldDate = 'date_created', $dateProvidedStart, $dateProvidedEnd))) return NULL;

        $queryBuilderObject->and_where('cRegion','like',$region);
        //echo DB::last_query();

        // Sort the results
        $queryBuilderObject->order_by('count', 'desc');

        // Add limit number to query if not wildcard or null
        if (!is_null($limit) && $limit !== '%')
        {
            $queryBuilderObject->limit($limit);
        }

        // Execute the query builder object and return the result set
        return array('data' => $this->queryRunUsingConnection($queryBuilderObject, $dbConnection));
    }


}
