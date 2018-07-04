<?php

/**
 * The cLinear API Template presenter.
 * This holds common functions used by endpoints in the cLinear API group.
 *
 * @package  app
 * @extends  Presenter
 */

// The Presenter_API_Template class includes Model\Validator already
// use \Model\Validator;

class Presenter_API_Combined_Template extends Presenter_API_Template
{
    // Pull all records from the specified database table matching a date and region; report errors if bad date or region
    public function selectDataByDateRangeAndHot(
        $dbConnection = null,               // Required: The database connection object to use (maps to objects specified in /fuel/app/config/{development|production|test}/db.php)
        $dbTable = null,                    // Required: The name of the table in the database that we're selecting data from
        $dbFieldHot,                        // Required: The field in the $dbTable that we'll sort on to get the hottest items (i.e. minutes impacted)
        $dbFieldDate = null,                // Required: The column in the $dbTable that holds the date for each record
        $dateProvidedStart = null,          // Required: The date to search for (may be a wildcard '%') or the start date if specifying a range; cannot be null
        $dateProvidedEnd = null,            // Opt: The end date if a date range is provided
        $count = null                       // Opt: The number of results to show per date
        )

    {
        // Create the query builder object (exit the function with null if this fails)
        if (is_null($queryBuilderObject = $this->queryCreateFromTable($dbTable))) return null;

        // Refine the query by adding a date or date range check (exit the function with null if this fails)
        if (is_null($queryBuilderObject = $this->queryWhereDateOrRange($queryBuilderObject, $dbFieldDate, $dateProvidedStart, $dateProvidedEnd))) return null;

        // Sort the results - sort the sub array entries by $dbFieldHot, and its parent array elements by $dbFieldDate
        // You need to first run the sort on the parent array, then the sub array

        $queryBuilderObject->order_by($dbFieldDate, 'asc');
        $queryBuilderObject->order_by($dbFieldHot, 'desc');


        // Add limit number to query if not wildcard or null
        if (!is_null($count) && $count!== '%' )
        {
            $queryBuilderObject->limit($count);
        }

        // Execute the query builder object and return the result set
        return array('data' => $this->queryRunUsingConnection($queryBuilderObject, $dbConnection));
    }

    // Pull all records from the specified database table matching a date and vendor; report errors if bad date or vendor
    // TODO: Replace this helper stub with a full function that includes a whitelist checker if needed
    public function selectDataByDateRangeAndMarket(
        $dbConnection = null,               // Required: The database connection object to use (maps to objects specified in /fuel/app/config/{development|production|test}/db.php)
        $dbTable = null,                    // Required: The name of the table in the database that we're selecting data from
        $dbFieldDate = null,                // Required: The column in the $dbTable that holds the date for each record
        $dateProvidedStart = null,          // Required: The date to search for (may be a wildcard '%') or the start date if specifying a range; cannot be null
        $dateProvidedEnd = null,            // Opt: The end date if a date range is provided
        $dbFieldMarket = null,              // Opt:
        $marketProvided = null              // Opt:
        )
    {
        return ($this->selectDataByDateRangeAndExtraFields(
            $dbConnection,              // Required: The database connection object to use (maps to objects specified in /fuel/app/config/{development|production|test}/db.php)
            $dbTable,                   // Required: The name of the table in the database that we're selecting data from
            $dbFieldDate,               // Required: The column in the $dbTable that holds the date for each record
            $dateProvidedStart,         // Required: The date to search for (may be a wildcard '%') or the start date if specifying a range; cannot be null
            $dateProvidedEnd,           // Opt: The end date if a date range is provided
            [
                $dbFieldMarket => $marketProvided
            ]
        ));
    }

    // Pull all records from the specified database table matching a date and vendor; report errors if bad date or vendor
    // TODO: Replace this helper stub with a full function that includes a whitelist checker if needed
    public function selectDataByDateRangeAndVendor(
        $dbConnection = null,               // Required: The database connection object to use (maps to objects specified in /fuel/app/config/{development|production|test}/db.php)
        $dbTable = null,                    // Required: The name of the table in the database that we're selecting data from
        $dbFieldDate = null,                // Required: The column in the $dbTable that holds the date for each record
        $dateProvidedStart = null,          // Required: The date to search for (may be a wildcard '%') or the start date if specifying a range; cannot be null
        $dateProvidedEnd = null,            // Opt: The end date if a date range is provided
        $dbFieldVendor = null,              // Opt:
        $vendorProvided = null              // Opt:
        )
    {
        return ($this->selectDataByDateRangeAndExtraFields(
            $dbConnection,              // Required: The database connection object to use (maps to objects specified in /fuel/app/config/{development|production|test}/db.php)
            $dbTable,                   // Required: The name of the table in the database that we're selecting data from
            $dbFieldDate,               // Required: The column in the $dbTable that holds the date for each record
            $dateProvidedStart,         // Required: The date to search for (may be a wildcard '%') or the start date if specifying a range; cannot be null
            $dateProvidedEnd,           // Opt: The end date if a date range is provided
            [
                $dbFieldVendor => $vendorProvided
            ]
            ));
    }
}
