<?php
/**
 *
 * @package app
 */
class Filter_Region_Mysql extends Filter_Region implements Filter_Region_Interface
{


    protected function decorateRegionsArrayQuery($select, $dbField, $regionsArray)
    {
        $select->where($dbField,'in', $regionsArray);
        // Return the updated query builder object
        return $select;
    }

    //default parameter names are different btwn public and protected functions in region mysql file
    public function filterByLegacyRegions($select, $dbField, $field)
    {
        return $this->decorateRegionsArrayQuery($select, $dbField, $this->getLegacyRegionList($field));
    }

    //a more generic function than the one above - default parameter names are different
    //  btwn public and protected functions in region mysql file -
    public function filterByRegions($select, $dbField, $regionsArray)
    {
        return $this->decorateRegionsArrayQuery($select, $dbField, $regionsArray);
    }


}
