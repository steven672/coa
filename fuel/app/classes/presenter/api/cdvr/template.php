<?php

/**
 * The API Template presenter.
 * This holds common functions used by most/all API endpoints.
 *
 * @package  app
 * @extends  Presenter
 */

use \Model\Validator;

class Presenter_API_cDVR_Template extends Presenter_API_Template
{
    // Using the provided query object and parameters (if it is not null), nest an or-where list of acceptable regions
    // arrayFieldRegion is the field in the listOfRegions, fieldRegion is the field in the db, you need
    // all three parameters to run fn.
    // This is instead of simply using a wildcard to search for all regions; this allows us to specify a whitelist of acceptable region results
    public function addAllRegions(
        $queryBuilderObject = null,             // Required: The FuelPHP Query Builder object that has already been created, such as DB::select()
        $dbFieldRegion = null,              // Required: The column in the database where the region name is stored
        $arrayFieldRegion = null,           // Required: The field name in the associative array listOfRegions that maps to the database column values
        $listOfRegionsProvided = null       // Required: An associative array with the list of acceptable regions
        )
    {
        // Ensure that required variables are provided and not null
        if (!is_null($queryBuilderObject)
            && !is_null($dbFieldRegion)
            && !is_null($arrayFieldRegion)
            && !is_null($listOfRegionsProvided)
        )
        {
            // Begin the nested "where" statement
            // Example query before where_open: select * from table where date='2017-02-01'
            // Example query after where_open: select * from table where date='2017-02-01' and (
            $queryBuilderObject->where_open();

                // Loop through the listOfRegions and add to the SQL query for each acceptable region option (white list)
            foreach ($listOfRegionsProvided as $index => $regionProvided)
                {
                // Use a regular where for the first item, and an or-where for each subsequent item
                if ($index == 0)
                {
                    // Use the database code for the region (0 index)
                    $queryBuilderObject->where($dbFieldRegion, $regionProvided[$arrayFieldRegion]);
                }
                else
                {
                    // Use the database code for the region (0 index)
                    $queryBuilderObject->or_where($dbFieldRegion, $regionProvided[$arrayFieldRegion]);
                }
            }

            // End the nested "where" statement
            // Example query before where_open: select * from table where date='2017-02-01' and (region='albq' or region='detroit'
            // Example query after where_open: select * from table where date='2017-02-01' and (region='albq' or region='detroit')
            $queryBuilderObject->where_close();
        }
        return $queryBuilderObject;
    }

    public function addCalculation ($newColumnName, $responseObject, $calculation)
    {
        // Add more calculations and insights
        // Check whether the data array has been created
        if (array_key_exists($responseObject, $this->response))
        {
            // Check whether the data object is the correct structure
            if ($this->response[$responseObject] !== array())
            {
                // The data array exists and is not empty, so let's operate on each of the result elements
                foreach ($this->response[$responseObject] as $index => $result)
                {
                    // Calculate the percent capacity used for each site/region
                    $result[$newColumnName] = $calculation($result);

                    // Save the modified entry to the result set
                    $this->response[$responseObject][$index] = $result;
                }
            }
        }
        else
        {
            // Ensure predictable default behavior for the client
            $this->response[$responseObject] = array();
        }
    }


    // Perform a calculation and save it into the response (save as a new element in each sub-array of the response object)
    public function addCalculationDivideTwoColumns(
        $newColumnName = null,            // Required: The name of the new column, in string format, ex: 'total_used_capacity_ratio'.
        $responseObject = null,            //
        $numeratorColumn = null,          //
        $divisorColumn = null
        )
    {
        $calculation = function ($result) use ($numeratorColumn, $divisorColumn) {
            return $this->stringDivision($result[$numeratorColumn], $result[$divisorColumn]);
        };
        $this->addCalculation($newColumnName, $responseObject, $calculation);
    }

    // Perform a calculation and save it into the response (save as a new element in each sub-array of the response object)
    public function addCalculationDivideByX(
        $newColumnName = null,            // Required: The name of the new column, in string format, ex: 'total_used_capacity_ratio'.
        $responseObject = null,            //
        $numeratorColumn = null,          //
        $divisor = '2'
        )
    {
        $calculation = function ($result) use ($numeratorColumn, $divisor) {
            return $this->stringDivision($result[$numeratorColumn], '2');
        };
        $this->addCalculation($newColumnName, $responseObject, $calculation);
    }

    // Perform a calculation and save it into the response (save as a new element in each sub-array of the response object)
    public function addCalculationGetPercentage(
        $newColumnName = null,            // Required: The name of the new column, in string format, ex: 'total_used_capacity_ratio'.
        $responseObject = null,
        $column        = null             // Required:
        )
    {
         $calculation = function ($result) use ($column) {
            return ((1 * $result[$column]) / 100);
        };
        $this->addCalculation($newColumnName, $responseObject, $calculation);
    }



    // Call selection function for a specific date
    // This is a helper function/wrapper and contains no actual logic itself
    public function selectDataByDateAndRegion(
        $dbConnection = null,               // Required: The database connection object to use (maps to objects specified in /fuel/app/config/{development|production|test}/db.php)
        $dbTable = null,                    // Required: The name of the table in the database that we're selecting data from
        $dbFieldDate = null,                // Required: The column in the $dbTable that holds the date for each record
        $dateProvided = null,               // Required: The date to search for (may be a wildcard '%', cannot be null)
        $dbFieldRegion = null,              // Required: The column in the $dbTable that holds the region name for each record
        $regionProvided = null,                 // Required: The region to search for (can be a wildcard '%' but must be provided either way, cannot be null)
        $arrayFieldRegion = null,           // Opt: The field within the $listOfRegionsProvided that holds the desired region name mapping
        $listOfRegionsProvided = null       // Required: An associative array with the list of acceptable regions
        )
    {
        return $this->selectDataByDateRangeAndRegion(
            $dbConnection,
            $dbTable,
            $dbFieldDate,
            $dateProvided,
            null,
            $dbFieldRegion,
            $regionProvided,
            $arrayFieldRegion,
            $listOfRegionsProvided
        );
    }

    // Pull all records from the specified database table matching a date and region; report errors if bad date or region
    public function selectDataByDateRangeAndRegion(
        $dbConnection = null,               // Required: The database connection object to use (maps to objects specified in /fuel/app/config/{development|production|test}/db.php)
        $dbTable = null,                    // Required: The name of the table in the database that we're selecting data from
        $dbFieldDate = null,                // Required: The column in the $dbTable that holds the date for each record
        $dateProvidedStart = null,          // Required: The date to search for (may be a wildcard '%') or the start date if specifying a range; cannot be null
        $dateProvidedEnd = null,            // Opt: The end date if a date range is provided
        $dbFieldRegion = null,              // Required: The column in the $dbTable that holds the region name for each record
        $regionProvided = null,                 // Required: The region to search for (can be a wildcard '%' but must be provided either way, cannot be null)
        $arrayFieldRegion = null,           // Opt: The field within the $listOfRegionsProvided that holds the desired region name mapping
        $listOfRegionsProvided = null       // Required: An associative array with the list of acceptable regions
        )
    {
        // Create the query builder object (exit the function with null if this fails)
        if (is_null($queryBuilderObject = $this->queryCreateFromTable($dbTable))) return null;

        // Refine the query by adding a date or date range check (exit the function with null if this fails)
        if (is_null($queryBuilderObject = $this->queryWhereDateOrRange($queryBuilderObject, $dbFieldDate, $dateProvidedStart, $dateProvidedEnd))) return null;

        // Sort the results
        $queryBuilderObject->order_by($dbFieldDate, 'asc');

        // Ensure that required variables are provided and not null
        if (!is_null($dbFieldRegion)
            && !is_null($regionProvided)
            && !is_null($arrayFieldRegion)
        )
        {
            // Intialize a new data validator object
            $validator = new Model_Validator();

            // Build the region search for the query, constrain to acceptble list if wildcard given
            if ($regionProvided === '%')
            {
                $queryBuilderObject = $this->addAllRegions(
                    $queryBuilderObject,
                    $dbFieldRegion,
                    $arrayFieldRegion,
                    $listOfRegionsProvided
                );
            }
            else
            {
                $queryBuilderObject->where($dbFieldRegion, 'LIKE', $regionProvided);
            }

            // Also sort the results by region
            $queryBuilderObject->order_by($dbFieldRegion, 'asc');
        }
        else
        {
            return null;
        }

        // Execute the query builder object and return the result set
        return array(
            'regions' => $listOfRegionsProvided,
            'data' => $this->queryRunUsingConnection($queryBuilderObject, $dbConnection)
            );
    }
}
