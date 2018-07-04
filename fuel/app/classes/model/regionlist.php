<?php

    // Holds the list of regions used by cDVR
class Model_RegionList
{
    // Valid region IDs for this table (pairs of database code, human readable name)
    // Matches with the "region" db column
    // db keys should be given as lowercase
    private $listOfRegionsLegacy = array(
    array('cs' => 'albuquerque',               'ddn' => 'albuquerque',               'recorders' => '#CISCO: ALBQ',             'throughput' => 'albq',               'text' => 'Albuquerque (C)'),
    array('cs' => 'vinings',                   'ddn' => 'vinings',                   'recorders' => '#ARRIS: VNGS',             'throughput' => 'vinings',            'text' => 'Atlanta (A)'),
    array('cs' => 'sanjose_sfba',              'ddn' => 'sanjose_sfba',              'recorders' => '#CISCO: SJOS',             'throughput' => 'sjos',               'text' => 'Bay Area (C)'),
    array('cs' => 'manassas',                  'ddn' => 'manassas',                  'recorders' => '#CISCO: MANA',             'throughput' => 'mana',               'text' => 'Beltway North (C)'),
    array('cs' => 'richmond_stpmill',          'ddn' => 'richmond_stpmill',          'recorders' => '#CISCO: STPM',             'throughput' => 'stpm',               'text' => 'Beltway South (C)'),
    array('cs' => 'sacramento_ccal',           'ddn' => 'sacramento_ccal',           'recorders' => '#CISCO: RNCH',             'throughput' => 'rnch',               'text' => 'Central California (C)'),
    array('cs' => 'mtprospect',                'ddn' => 'mtprospect',                'recorders' => '#ARRIS: MTPR',             'throughput' => 'mtprospect',         'text' => 'Chicago (A)'),
    array('cs' => 'denver',                    'ddn' => 'denver',                    'recorders' => '#CISCO: DNVR',             'throughput' => 'dnvr',               'text' => 'Denver (C)'),
    array('cs' => 'plainfield_freeeast',       'ddn' => 'plainfield_freeeast',       'recorders' => '#CISCO: PLA FE',           'throughput' => 'seca',               'text' => 'Freedom East (C)'),
    array('cs' => 'newcastle_freewest',        'ddn' => 'newcastle_freewest',        'recorders' => '#CISCO: NCS FW',           'throughput' => 'ncst',               'text' => 'Freedom West (C)'),
    array('cs' => 'foxboro_gbr',               'ddn' => 'foxboro_gbr',               'recorders' => '#ARRIS: FOX',              'throughput' => 'foxboro_g',          'text' => 'Greater Boston (A)'),
    array('cs' => 'katy',                      'ddn' => 'katy',                      'recorders' => '#CISCO: KATY',             'throughput' => 'katy',               'text' => 'Houston (C)'),
    array('cs' => 'jacksonville_fl',           'ddn' => 'jacksonville_fl',           'recorders' => '#ARRIS: JACK',             'throughput' => 'jacksonville',       'text' => 'Jacksonville (A)'),
    array('cs' => 'corliss',                   'ddn' => 'corliss',                   'recorders' => '#ARRIS: CORL',             'throughput' => 'pittsburgh',         'text' => 'Keystone (A)'),
    array('cs' => 'memphis_tn',                'ddn' => 'memphis_tn',                'recorders' => '#ARRIS: MPHS',             'throughput' => 'memphis',            'text' => 'Memphis (A)'),
    array('cs' => 'miami_fl',                  'ddn' => 'miami_fl',                  'recorders' => '#ARRIS: MIMI',             'throughput' => 'miami_s',            'text' => 'Miami (A)'),
    array('cs' => 'naples_fl',                 'ddn' => 'naples_fl',                 'recorders' => '#ARRIS: NAPE',             'throughput' => 'nashville',          'text' => 'Naples (A)'),
    array('cs' => 'nashville',                 'ddn' => 'nashville',                 'recorders' => '#ARRIS: NASH',             'throughput' => 'miami_w',            'text' => 'Nashville (A)'),
    array('cs' => 'portland',                  'ddn' => 'portland',                  'recorders' => '#ARRIS: PORT',             'throughput' => 'portland',           'text' => 'Portland (A)'),
    array('cs' => 'salt_lake_city',            'ddn' => 'salt_lake_city',            'recorders' => '#CISCO: STLK',             'throughput' => 'stlk',               'text' => 'Salt Lake (C)'),
    array('cs' => 'seattle',                   'ddn' => 'seattle',                   'recorders' => '#ARRIS: SEAT',             'throughput' => 's116thseattle',      'text' => 'Seattle (A)'),
    array('cs' => 'tallahassee_fl',            'ddn' => 'tallahassee_fl',            'recorders' => '#ARRIS: TALL',             'throughput' => 'tallahassee',        'text' => 'Tallahassee (A)'),
    array('cs' => 'foxboro_wner',              'ddn' => 'foxboro_wner',              'recorders' => '#ARRIS: WNER',             'throughput' => 'foxboro_w',          'text' => 'Western New England (A)')
    );

    // Valid region IDs for this table (pairs of database code, human readable name)
    // Matches with the "region" db column
    // db keys should be given as lowercase
    private $listOfRegionsRio = array(
    array('rio' => 'albq',               'status' => 'Albuquerque',      'capacity' => 'Albuquerque',          'failures' => 'Albuquerque',     'text' => 'Albuquerque'),
    array('rio' => 'corliss',            'status' => 'Keystone',         'capacity' => 'Keystone',             'failures' => 'Keystone',        'text' => 'Corliss'),
    array('rio' => 'denver',             'status' => 'Denver',           'capacity' => 'Denver',               'failures' => 'Denver',          'text' => 'Denver'),
    array('rio' => 'detroit',            'status' => 'Detroit',          'capacity' => 'Detroit',              'failures' => 'Detroit',         'text' => 'Detroit'),
    array('rio' => 'jacksonville_fl',    'status' => 'Jacksonville',     'capacity' => 'Jacksonville',         'failures' => 'Jacksonville',    'text' => 'Jacksonville'),
    array('rio' => 'katy',               'status' => 'Houston',          'capacity' => 'Houston',              'failures' => 'Houston',         'text' => 'Houston'),
    array('rio' => 'nashville',          'status' => 'Nashville',        'capacity' => 'Nashville',            'failures' => 'Nashville',       'text' => 'Nashville'),
    array('rio' => 'memphis_tn',         'status' => 'Memphis',       'capacity' => 'Memphis_TN',           'failures' => 'Memphis_TN',      'text' => 'Memphis_TN'),
    array('rio' => 'portland',           'status' => 'Portland',         'capacity' => 'Portland',             'failures' => 'Portland',        'text' => 'Portland'),
    array('rio' => 'sacramento_ccal',    'status' => 'CCAL',             'capacity' => 'Central_California',   'failures' => 'CentralCal',      'text' => 'Central California'),
    array('rio' => 'salt_lake_city',     'status' => 'Salt_Lake_city',   'capacity' => 'Salt_Lake',            'failures' => 'Mountain',        'text' => 'Salt Lake City'),
    array('rio' => 'tallahassee_fl',     'status' => 'Tallahassee',             'capacity' => 'Tallahassee',          'failures' => 'Gulf',            'text' => 'Tallahassee'),
    array('rio' => 'twincities',         'status' => 'Twin Cities',      'capacity' => 'Twin_Cities',          'failures' => 'TwinCities',      'text' => 'Twin Cities')
    );










    // Build a new list from a source array and field names
    // Using the forceLower toggle, convert each field's value to lowercase
    private function buildList(
    $sourceList = null,
    $searchField = null
    )
    {
        // Initialize the new list
        $newList = array();

        // Iterate through the list and select the fields we want
        foreach ($sourceList as $key => $element)
        {
            // Initialize the new element object
            $newELement = array();
            $newElement['db'] = null;
            $newElement['text'] = null;

            // Pull the first field if it exists
            if (array_key_exists($searchField, $element))
            {
                $newElement['db'] = strtolower($element[$searchField]);
            }

            // Pull the first field if it exists
            if (array_key_exists('text', $element))
            {
                $newElement['text'] = $element['text'];
            }

            // Add the new element to the new list
            $newList[] = $newElement;
        }

        // Sort the list alphabetically by the 'text' field
        usort($newList, array($this, 'sortListByText'));

        // Return the new list [ {db, text} ]
        return $newList;
    }

    // Retrieve the raw list of all regions
    public function listAllLegacy()
    {
        // Iterate through the list and select the fields we want, build a list, and return the built list
        return $this->listOfRegionsLegacy;
    }

    // Retrieve the raw list of all regions
    public function listAllRio()
    {
        // Iterate through the list and select the fields we want, build a list, and return the built list
        return $this->listOfRegionsRio;
    }

    // Retrieve a list in the original format [ {db, text} ]
    public function listCS()
    {
        // Iterate through the list and select the fields we want, build a list, and return the built list
        return $this->buildList($this->listOfRegionsLegacy, 'cs');
    }

    // Retrieve a list in the original format [ { db, text } ]
    public function listDDN()
    {
        // Iterate through the list and select the fields we want, build a list, and return the built list
        return $this->buildList($this->listOfRegionsLegacy, 'ddn');
    }

    // Retrieve a list in the original format [ { db, text } ]
    public function listRecorders()
    {
        // Iterate through the list and select the fields we want, build a list, and return the built list
        return $this->buildList($this->listOfRegionsLegacy, 'recorders');
    }

    // Retrieve a list in the original format [ { db, text } ]
    public function listThroughput()
    {
        // Iterate through the list and select the fields we want, build a list, and return the built list
        return $this->buildList($this->listOfRegionsLegacy, 'throughput');
    }

    // Sort a multidimentional array by the field called "text"; called with usort()
    private function sortListByText($a, $b)
    {
        return $a['text'] - $b['text'];
    }
}

?>