<?php

    // Holds common data validation functions used elsewhere
class Model_Validator
{
    // Determine whether a date is given in the specified format (Y-m-d corresponds to YYYY-MM-DD)
    public function validDate($date = NULL, $format = 'Y-m-d')
    {
        // Check whether wildcard provided (valid)
        if ($date == '%') return TRUE;

        // Validate a provided date
        $dt = DateTime::createFromFormat($format, $date);
        return $dt !== FALSE && !array_sum($dt->getLastErrors());
    }


    // Determine whether a region is contained in a given list of regions, assumes that the search column is "db"
    public function validRegion($region = NULL, $list = NULL, $field = 'db')
    {
        // Check whether values provided
        if ($region == NULL or $list == NULL) return FALSE;

        // Check whether wildcard provided (valid)
        if ($region == '%') return TRUE;

        // Force all values to lowercase during search to eliminate false negatives
        $region = strtolower($region);

        // array_search returns a numeric index if found or false if not found
        // The is_int function forces the value to boolean true if found
        return (is_int(array_search($region, array_column($list, $field))));
    }


}
