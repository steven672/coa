<?php

interface Filter_Region_Interface
{


    public function getCdvrRegionList();

    public function filterByRegions($select, $dbField, $regionsArray);

    public function filterByLegacyRegions($select, $dbField, $field);
}
