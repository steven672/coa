<?php

/**
 * The API Template presenter.
 * This holds common functions used by many API endpoints across the application.
 *
 * @package  app
 * @extends  Presenter
 */

use \Model\Validator;

class Presenter_API_Template extends Presenter
{

    // get one data parameter and transfer it to timestamp
    public function convertDateToTimestamp($dateProvided = null)
    {
        return (new DateTime($dateProvided, new DateTimeZone('UTC')))->format('U');
    }


    // This function takes an array of elements where each element has a common field and creates buckets using the value in that field (i.e. grouping elements by date)
    // The function also removes the common field from each element to reduce payload size
    public function createArrayBucketsByField($originalDataArray = null, $searchFieldInArray = null)
    {
        // Check for required parameters
        if (!is_array($originalDataArray)
            || is_null($searchFieldInArray)
        )
        {
            return null;
        }

        // Create a new container -- this will hold the new date buckets
        $newContainer = array();

        // Iterate through all records returned from the database and group them into buckets based on date
        foreach($originalDataArray as $index => $element)
        {
            // Extract the date for this element
            $thisDate = $element[$searchFieldInArray];

            // Create the new date bucket if it doesn't exist yet
            if (!array_key_exists($thisDate, $newContainer))
            {
                $newContainer[$thisDate] = array();
            }

            // Delete the redundant date field to minimize payload size
            unset($element[$searchFieldInArray]);

            // Add the record to the correct date bucket
            $newContainer[$thisDate][] = $element;
        }

        // Update the response variable with the new bucket-ized dataset
        return $newContainer;
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

    // Get a parameter value from the URL; if it is not found, convert it to a default value
    // If the parameter value is "all", convert it to a wildcard value
    public function ingestParameter($paramName = null, $wildcardValue = '%', $defaultValue = '%')
    {
        $result = null;

        // Ensure that required variables are provided and not null
        if (!is_null($paramName))
        {
            // Get the parameter from FuelPHP
            $result = $this->request()->param($paramName, $defaultValue);

            // If the parameter value is ingested as "all", convert it to the specified wildcard
            $result = ($result === "all" ? $wildcardValue : $result);
        }

        // If the paramName requested is null, the result is null
        // Otherwise, the param name is either the value of the parameter (if found) or the default value (if not found)
        return $result;
    }

    // Check for nulls and create a FuelPHP query builder object, otherwise return null
    public function queryCreateFromTable(
        $dbTable = null                 // Required: The name of the table in the database that we're selecting data from
        )
    {
        // Ensure that required variables are provided and not null
        if (!is_null($dbTable)
        )
        {
            // Set up the query and return the new query builder object
            return (DB::select()->from($dbTable));
        }

        // Parameter check failed, don't return a query builder object
        return null;
    }

    // Check for nulls and run the query using the database connection provied, return the query builder object or null
    public function queryRunUsingConnection(
        $queryBuilderObject = null,         // Required: The query builder object to use
        $dbConnection = null                // Required: The database connection object to use (maps to objects specified in /fuel/app/config/{development|production|test}/db.php)
        )
    {
        // Ensure that required variables are provided and not null
        if (!is_null($queryBuilderObject)
            && !is_null($dbConnection)
        )
        {
            // Set up the query and return the result set as an array
            $result = $queryBuilderObject->execute(DB::instance($dbConnection));
            return $result->as_array();
        }

        // Parameter check failed, don't return a query builder object
        return null;
    }

    // Refine the query by adding a date or date range check (exit the function with null if this fails)
    public function queryWhereDateOrRange(
        $queryBuilderObject = null,         // Required: The query builder object to use
        $dbFieldDate = null,                // Required: The column in the $dbTable that holds the date for each record
        $dateProvidedStart = null,          // Required: The date to search for (may be a wildcard '%') or the start date if specifying a range; cannot be null
        $dateProvidedEnd = null             // Opt: The end date if a date range is provided
        )
    {
        // Ensure that required variables are provided and not null
        if (!is_null($queryBuilderObject)
            && !is_null($dbFieldDate)
            && !is_null($dateProvidedStart)
        )
        {
            // Intialize a new data validator object
            $validator = new Model_Validator();

            // Check whether date and region are valid (wildcard or YYYY-MM-DD format, in region list)
            if ($validator->validDate($dateProvidedStart))
            {
                // Build the date search for the query (either a single date or a date range)
                if (is_null($dateProvidedEnd) || $dateProvidedEnd === '%')
                {
                    // Select for a single date
                    $queryBuilderObject->where($dbFieldDate, 'LIKE', $dateProvidedStart);
                }
                else
                {
                    // Convert YYYY-MM-DD to unix timestamps for DB comparisons
                    $timestampStart = $this->convertDateToTimestamp($dateProvidedStart);
                    $timestampEnd = $this->convertDateToTimestamp($dateProvidedEnd);

                    // Select from a date range by converting the values to unix timestamps and comparing numbers
                    // This is ugly as fuck but it gets the job done
                    // FuelPHP doesn't seem to allow date objects to be put into the third field of the where function, so we need to use something else (originally tried using convert() in MySQL)
                    $queryBuilderObject->where(DB::expr('UNIX_TIMESTAMP(CAST(' . $dbFieldDate . ' as DATE))'), '>=', $timestampStart);
                    $queryBuilderObject->where(DB::expr('UNIX_TIMESTAMP(CAST(' . $dbFieldDate . ' as DATE))'), '<=', $timestampEnd);
                }

                // Return the updated query builder object
                return $queryBuilderObject;
            }
        }

        // Parameter check failed, don't return a query builder object
        return null;
    }

    // Within a specified 2-dimensional array [ [ key:value ], [ key:value ] ]
    // Search for a specified value within a specified array key
    // Return the whole element (sub-array) when the value  is found in the key for that element
    public function searchWithKey(
        $searchInKey = null,        // Required: search prameter
        $searchForValue = null,     // Required: actual search word
        $searchInArray = null       // Required: whole list of records
        )
    {
        foreach ($searchInArray as $index => $element)
        {
            if (strtolower($element[$searchInKey]) === strtolower($searchForValue))
            {
                return $element;
            }
        }
        return null;
    }

    // Pull all records from the specified database table matching a date and region; report errors if bad date or region
    public function selectDataByDateRange(
        $dbConnection = null,               // Required: The database connection object to use (maps to objects specified in /fuel/app/config/{development|production|test}/db.php)
        $dbTable = null,                    // Required: The name of the table in the database that we're selecting data from
        $dbFieldDate = null,                // Required: The column in the $dbTable that holds the date for each record
        $dateProvidedStart = null,          // Required: The date to search for (may be a wildcard '%') or the start date if specifying a range; cannot be null
        $dateProvidedEnd = null             // Opt: The end date if a date range is provided
        )
    {
        // Create the query builder object (exit the function with null if this fails)
        if (is_null($queryBuilderObject = $this->queryCreateFromTable($dbTable))) return null;

        // Refine the query by adding a date or date range check (exit the function with null if this fails)
        if (is_null($queryBuilderObject = $this->queryWhereDateOrRange($queryBuilderObject, $dbFieldDate, $dateProvidedStart, $dateProvidedEnd))) return null;

        // Sort the results
        $queryBuilderObject->order_by($dbFieldDate, 'asc');

        // Execute the query builder object and return the result set
        return array('data' => $this->queryRunUsingConnection($queryBuilderObject, $dbConnection));
    }

    // Pull all records from the specified database table matching a date and region; report errors if bad date or region
    public function selectDataByDateRangeAndCount(
        $dbConnection = null,               // Required: The database connection object to use (maps to objects specified in /fuel/app/config/{development|production|test}/db.php)
        $dbTable = null,                    // Required: The name of the table in the database that we're selecting data from
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

        // Sort the results
        $queryBuilderObject->order_by($dbFieldDate, 'asc');

        // Add limit number to query if not wildcard or null
        if (!is_null($count) && $count!== '%' )
        {
            $queryBuilderObject->limit($count);
        }

        // Execute the query builder object and return the result set
        return array('data' => $this->queryRunUsingConnection($queryBuilderObject, $dbConnection));
    }

    // Pull all records from the specified database table matching a date and region; report errors if bad date or region
    // This function does not provide any whitelist functionality, simply comparison of values
    public function selectDataByDateRangeAndExtraField(
        $dbConnection = null,               // Required: The database connection object to use (maps to objects specified in /fuel/app/config/{development|production|test}/db.php)
        $dbTable = null,                    // Required: The name of the table in the database that we're selecting data from
        $dbFieldDate = null,                // Required: The column in the $dbTable that holds the date for each record
        $dateProvidedStart = null,          // Required: The date to search for (may be a wildcard '%') or the start date if specifying a range; cannot be null
        $dateProvidedEnd = null,            // Opt: The end date if a date range is provided
        $dbFieldExtra = null,               // Opt: The column in the $dbTable that holds a value to search for
        $extraProvided = null               // Opt: The value in the $dbFieldExtra to search for
        )

    {
        // Execute the query builder object and return the result set
        return selectDataByDateRangeAndExtraFields(
            $dbConnection,              // Required: The database connection object to use (maps to objects specified in /fuel/app/config/{development|production|test}/db.php)
            $dbTable,                   // Required: The name of the table in the database that we're selecting data from
            $dbFieldDate,               // Required: The column in the $dbTable that holds the date for each record
            $dateProvidedStart,         // Required: The date to search for (may be a wildcard '%') or the start date if specifying a range; cannot be null
            $dateProvidedEnd,           // Opt: The end date if a date range is provided
            [
                $dbFieldExtra => $extraProvided
            ]
        );
    }


    // Pull all records from the specified database table matching a date and region; report errors if bad date or region
    // This function does not provide any whitelist functionality, simply comparison of values
    public function selectDataByDateRangeAndExtraFields(
        $dbConnection = null,               // Required: The database connection object to use (maps to objects specified in /fuel/app/config/{development|production|test}/db.php)
        $dbTable = null,                    // Required: The name of the table in the database that we're selecting data from
        $dbFieldDate = null,                // Required: The column in the $dbTable that holds the date for each record
        $dateProvidedStart = null,          // Required: The date to search for (may be a wildcard '%') or the start date if specifying a range; cannot be null
        $dateProvidedEnd = null,            // Opt: The end date if a date range is provided
        $dbFieldListAndProvided
        )

    {
        // Create the query builder object (exit the function with null if this fails)
        if (is_null($queryBuilderObject = $this->queryCreateFromTable($dbTable))) return null;

        // Refine the query by adding a date or date range check (exit the function with null if this fails)
        if (is_null($queryBuilderObject = $this->queryWhereDateOrRange($queryBuilderObject, $dbFieldDate, $dateProvidedStart, $dateProvidedEnd))) return null;

        // Sort the results
        $queryBuilderObject->order_by($dbFieldDate, 'asc');

        // Add a limiter based on the extra fields desired (i.e. vendor, market, etc)
        if (!is_null($dbFieldListAndProvided)
            && is_array($dbFieldListAndProvided)
        )
        {
            foreach ($dbFieldListAndProvided as $key => $element)
            {
                $queryBuilderObject->where($key, 'like', $element);
            }
        }

        // Execute the query builder object and return the result set
        return array('data' => $this->queryRunUsingConnection($queryBuilderObject, $dbConnection));
    }


    // Pull all records from the specified database table matching a date and region; report errors if bad date or region
    // This function does not provide any whitelist functionality, simply comparison of values
    //this function provide sort by extra db field
    public function selectDataByDateRangeAndSortExtraField(
        $dbConnection = null,               // Required: The database connection object to use (maps to objects specified in /fuel/app/config/{development|production|test}/db.php)
        $dbTable = null,                    // Required: The name of the table in the database that we're selecting data from
        $dbFieldExtra = null,               // Opt: The column in the $dbTable that holds a value to search for
        $dbFieldDate = null,                // Required: The column in the $dbTable that holds the date for each record
        $dateProvidedStart = null,          // Required: The date to search for (may be a wildcard '%') or the start date if specifying a range; cannot be null
        $dateProvidedEnd = null         // Opt: The end date if a date range is provided
        )

    {
        // Create the query builder object (exit the function with null if this fails)
        if (is_null($queryBuilderObject = $this->queryCreateFromTable($dbTable))) return null;

        // Refine the query by adding a date or date range check (exit the function with null if this fails)
        if (is_null($queryBuilderObject = $this->queryWhereDateOrRange($queryBuilderObject, $dbFieldDate, $dateProvidedStart, $dateProvidedEnd))) return null;

        // Sort the date and extra field
        $queryBuilderObject->order_by($dbFieldDate, 'asc');

        // Add a limiter based on the extra field desired (i.e. vendor, market, etc)
        if (!is_null($dbFieldExtra))
        {
            $queryBuilderObject->order_by($dbFieldExtra, 'desc');
        }

        // Execute the query builder object and return the result set
        return array('data' => $this->queryRunUsingConnection($queryBuilderObject, $dbConnection));
    }




    // Pull all records from the specified database table matching a date and limit; sort on specicified field or date
    public function selectDataByDateRangeAndCountAndSortExtraField(
        $dbConnection = null,               // Required: The database connection object to use (maps to objects specified in /fuel/app/config/{development|production|test}/db.php)
        $dbTable = null,                    // Required: The name of the table in the database that we're selecting data from
        $dbFieldDate = null,                // Required: The column in the $dbTable that holds the date for each record
        $dateProvidedStart = null,          // Required: The date to search for (may be a wildcard '%') or the start date if specifying a range; cannot be null
        $dateProvidedEnd = null,            // Opt: The end date if a date range is provided
        $count = null,                      // Opt: The number of results to show per date
        $sort = null                        // Opt: The order and direction of sorts as map of [column => direction]
        )

    {
        // Create the query builder object (exit the function with null if this fails)
        if (is_null($queryBuilderObject = $this->queryCreateFromTable($dbTable))) return null;

        // Refine the query by adding a date or date range check (exit the function with null if this fails)
        if (is_null($queryBuilderObject = $this->queryWhereDateOrRange($queryBuilderObject, $dbFieldDate, $dateProvidedStart, $dateProvidedEnd))) return null;

        // Sort the results
        if (is_null($sort))
        {
            $queryBuilderObject->order_by($dbFieldDate, 'asc');
        }
        else
        {
            foreach ($sort as $column => $direction)
            {
                $queryBuilderObject->order_by($column, $direction);
            }
        }

        // Add limit number to query if not wildcard or null
        if (!is_null($count) && $count !== '%')
        {
            $queryBuilderObject->limit($count);
        }

        // Execute the query builder object and return the result set
        return array('data' => $this->queryRunUsingConnection($queryBuilderObject, $dbConnection));
    }

    public function sortBySubValue($array, $fieldName, $asc = true)
        {
            usort($array, function ($a, $b) use ($fieldName, $asc) {
                if ($a[$fieldName] === $b[$fieldName]) {
                    return 0;
                }
                return ($a[$fieldName] > $b[$fieldName]) ? ($asc ? 1 : -1) : ($asc ? -1 : 1);
            });
            return $array;
        }


    // Converts strings to floats, performs $valA / $valB, and returns the result
    public function stringDivision(
        $valA = null,
        $valB = null
        )
    {
        // Ensure that required variables are provided and not null
        if (!is_null($valA)
            && !is_null($valB)
        )
        {
            try
            {
                // Try to divide the values and return the result
                return floatval($valA) / floatval($valB);
            }
            catch (Exception $e)
            {
                // Most likely a divide by zero error
                return NaN;
            }
        }

        // One of the parameters was null
        return null;
    }
}
