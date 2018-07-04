<?php
/**
 *
 * @package app
 */
abstract class Metric_Base
{
    protected $databaseConnection;
    protected $dateFilter;

    protected $regionModel;
    protected $region;

    /**
    * The cdvr region list for the metric
    *
    * @access protected
    * @return Associate array
    */
    protected function getCdvrRegionList()
    {
        return $this->regionModel->listAllLegacy();
    }

    /**
    * The Rio regions list for the metric
    *
    * @access protected
    * @return Associate array
    */
    protected function getRioRegionList()
    {
        return $this->regionModel->listAllRio();
    }

    /**
    * The database type for the metric
    *
    * @abstract
    * @return String
    */
    abstract protected function getDatabaseType();

    /**
    * The database connection string for the metric
    *
    * @abstract
    * @return String
    */
    abstract protected function getConnection();

    /**
     * Public constructor. Can accept a database conneciton for testing/DI
     *
     * @access public
     * @param  Fuel\Core\Database_Connection $databaseConnection can be passed in for DI
     * @return Response
     */
    public function __construct($databaseConnection = null)
    {
        $this->regionModel = new Model_RegionList();
        $this->region = $this->provideRegionFilter();
        $this->databaseConnection = $databaseConnection;
    }

    // get one data parameter and transfer it to timestamp
    public function convertDateToTimestamp($dateProvided = null)
    {
        return (new DateTime($dateProvided, new DateTimeZone('UTC')))->format('U');
    }

    /**
     * Return relevant DB instance for this metric
     *
     * @access protected
     * @return Fuel\Core\Database_Connection
     */
    protected function databaseConnection()
    {
        if (is_null($this->databaseConnection))
        {
            $this->databaseConnection = DB::instance($this->getConnection());
        }
        return $this->databaseConnection;
    }

    /**
     * Return Filter_Date instance for the specified database type
     *
     * @access protected
     * @param  String $table
     * @param  String $column
     * @return Filter_DateInterface
     */
    protected function provideDateFilter($table, $column)
    {
        switch ($this->getDatabaseType()) {
            case 'mysql':
            default:
                return new Filter_Date_Mysql($table, $column);
                break;
        }
    }
    /**
     * Return Filter_Region instance for the specified database type
     *
     * @access protected
     * @param  String $table
     * @param  String $column
     * @return Filter_RegionInterface
     */
    protected function provideRegionFilter()
    {
        switch ($this->getDatabaseType()) {
            case 'mysql':
            default:
                return new Filter_Region_Mysql();
                break;
        }
    }

    /**
     * Run the specified query using the currently configured database connection, with
     * optional query caching provided by FuelPHP (cache key is md5 of query). Providing
     * false as the second argument prevents caching.
     *
     * @access protected
     * @param  Fuel\Core\Database_Query_Builder $queryBuilderObject Query to be executed
     * @param  Integer|False                    $cacheExpiration Expiration time in sec or false for uncached query
     * @return Array Database results
     */
    public function runQuery($queryBuilderObject, $cacheExpiration = 900)
    {
        if ($cacheExpiration !== false)
        {
            $result = $queryBuilderObject->execute($this->databaseConnection());
        }
        else
        {
            $result = $queryBuilderObject->execute($this->databaseConnection());
        }
        return $result->as_array();
    }


    public function debugLastQuery()
    {
        $this->debug(DB::last_query($this->getConnection()));
    }


    public function debug($data = 'here')
    {
        print_r($data);
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

    public function searchWithKey(
        $searchInKey        = null,         // Required: search prameter
        $searchForValue     = null,         // Required: actual search word
        $searchInArray      = null          // Required: whole list of records
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


    // This function takes an array of elements where each element has a common field and creates buckets using the value in that field (i.e. grouping elements by date)
    // The function also removes the common field from each element to reduce payload size
    protected function createArrayBucketsByField($originalDataArray = null, $searchFieldInArray = null)
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

    public function createArrayBucketsByTwoField($originalDataArray = null, $searchFieldInArrayOne = null, $searchFieldInArrayTwo = null )
    {
         // Check for required parameters
        if (!is_array($originalDataArray)
            || is_null($searchFieldInArrayOne)
            || is_null($searchFieldInArrayTwo)
        )
        {
            return null;
        }

        // Create a new container -- this will hold the new date buckets
        $newContainer = $this->createArrayBucketsByField($originalDataArray, $searchFieldInArrayOne);

        foreach ($newContainer as $index => $element)
        {
            $newContainer[$index] = $this->createArrayBucketsByField($element, $searchFieldInArrayTwo);
        }
       //Update the response variable with the new bucket-ized dataset
        return $newContainer;
    }


    // Two following functions allow replacing strings within multidimentional arrays with other strings
    // Auxiliary function for deepReplace
    public function _replaceWithAnything($search,$replace,$subject)
    {
        if(!is_array($search) || !is_array($replace)){
            $search=array($search);
            $replace=array($replace);
        }

        $match=array_search($subject,$search,true);
        if($match!==false && array_key_exists($match,$replace))
            $subject=$replace[$match];
        return $subject;
    }

    // Main function:
    public function deepReplace(
            $search     = null,         // Required: array of string to replace current strings ex: array("a8-updater", "archive-agent"...)
            $replace    = null,         // Required: array of string to replace current strings ex: array("A8 Updater", "Archive Agent"...)
            $subject    = null          // Required: the original multidimensional array, which can be the format of the output of
                                        // $results =  $this->runQuery($select), for example, [{"field1":"aaa", "field2":"bbb"},{"field1":"ccc", "field2":"ddd"} ..etc..].
            )
    {
        if(!is_array($subject))
            return $this->_replaceWithAnything($search,$replace,$subject);
        foreach($subject as &$val){
            if(is_array($val)){
                $val=$this->deepReplace($search,$replace,$val);
                continue;
            }
            $val=$this->_replaceWithAnything($search,$replace,$val);
        }
        return $subject;
    }
}

