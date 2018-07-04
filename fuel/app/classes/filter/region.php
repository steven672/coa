<?php
/**
 *
 * @package app
 */
abstract class Filter_Region
{
    /** @var String Table name to be date filtered */
    protected $table;
    /** @var String Column name containing dates*/
    protected $column;
    /** @var Array of strings name containing region names*/
    protected $regionModel;

    public function __construct($table = '', $column = '')
    {
        $this->table = $table;
        $this->column = $column;
        $this->regionModel = new Model_RegionList();
    }
    // * @access protected
    // * @return Associate array containing strings names of Legacy Regions
    // */
    public function getCdvrRegionList()
    {
        return $this->regionModel->listAllLegacy();
    }

    // a protected function used by the filterByLegacyRegions function, visible in
    // all classes that extend the Filter_Region class
    protected function getLegacyRegionList($field)
    {
        return array_map(function ($i) use ($field) { return $i[$field]; }, $this->getCdvrRegionList());
    }

    // a more specific verion of filterByRegions - returns associative array containing the string names
    // from the field in the legacy regionslist which match the field name given
    abstract public function filterByLegacyRegions($select, $dbField, $field);


    // generic function to pull on db records matching a region in $regionsArray
    abstract public function filterByRegions($select, $dbField, $regionsArray);


}
