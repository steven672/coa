<?php

    /**
     * @group App
     * @group Models
     */

    class Test_Validator extends TestCase
    {
        // TODO: Consider additional edge cases to test for the validDate function

        // TODO: Add more edge cases to test for the validRegion function
        // Especially for search field name, source list, etc

        // Test data for a list of regions to compare (copied from the Throughput API)
        // These db keys should be given as lowercase
        public $listOfRegions = array(
            array('db' => 'albq',               'text' => 'Albuquerque (C)'),
            array('db' => 'pittsburgh',         'text' => 'Keystone (A)'),
            array('db' => 'foxboro_w',          'text' => 'Western New England (A)')
        );

        // No value is passed to the validDate function
        public function test_validDate_NotPresent()
        {
            $validator = new Model_Validator();
            $this->assertFalse($validator->validDate(),
                "Validator :: validDate :: False when no date parameter provided");
        }

        // Null value passed to the validDate function
        public function test_validDate_PresentAndNull()
        {
            $validator = new Model_Validator();
            $this->assertFalse($validator->validDate(null),
                "Validator :: validDate :: False when null date parameter provided");
        }

        // Value with incorrect format passed to the validDate function
        public function test_validDate_PresentAndBadFormat_YearInt()
        {
            $validator = new Model_Validator();
            $this->assertFalse($validator->validDate(2017),
                "Validator :: validDate :: False when only integer year provided");
        }

        // Value with incorrect format passed to the validDate function
        public function test_validDate_PresentAndBadFormat_Negative()
        {
            $validator = new Model_Validator();
            $this->assertFalse($validator->validDate(-100),
                "Validator :: validDate :: False when negative integer provided");
        }

        // Value with incorrect format passed to the validDate function
        public function test_validDate_PresentAndBadFormat_Decimal()
        {
            $validator = new Model_Validator();
            $this->assertFalse($validator->validDate(1.1),
                "Validator :: validDate :: False when decimal provided");
        }

        // Value with incorrect format passed to the validDate function
        public function test_validDate_PresentAndBadFormat_SpecialCharacters()
        {
            $validator = new Model_Validator();
            $this->assertFalse($validator->validDate("!@#$%^&*()_+~{}[]\\|/?"),
                "Validator :: validDate :: False when special characters provided");
        }

        // Value with incorrect format passed to the validDate function
        public function test_validDate_PresentAndBadFormat_YYYYMMDD()
        {
            $validator = new Model_Validator();
            $this->assertFalse($validator->validDate(20170101),
                "Validator :: validDate :: False when no hyphens in date");
        }

        // Value with incorrect format passed to the validDate function
        public function test_validDate_PresentAndBadFormat_MM_DD_YYYY()
        {
            $validator = new Model_Validator();
            $this->assertFalse($validator->validDate("03-30-2017"),
                "Validator :: validDate :: False when MM-DD-YYYY date format provided");
        }

        // Value with incorrect format passed to the validDate function
        public function test_validDate_PresentGoodFormatBadDate_Close()
        {
            $validator = new Model_Validator();
            $this->assertFalse($validator->validDate("2016-02-31"),
                "Validator :: validDate :: False when invalid date provided 2016-02-31");
        }

        // Value with incorrect format passed to the validDate function
        public function test_validDate_PresentGoodFormatBadDate_NotClose()
        {
            $validator = new Model_Validator();
            $this->assertFalse($validator->validDate("9999-99-99"),
                "Validator :: validDate :: False when invalid date provided in correct format 9999-99-99");
        }

        // Value with correct format passed to the validDate function
        public function test_validDate_PresentAndValid()
        {
            $validator = new Model_Validator();
            $this->assertTrue($validator->validDate("2016-01-02"),
                "Validator :: validDate :: True when correctly formatted valid date provided");
        }

        // No value is passed to the validRegion function
        public function test_validRegion_NotPresent()
        {
            $validator = new Model_Validator();
            $this->assertFalse($validator->validRegion(),
                "Validator :: validRegion :: False when no region parameter provided");
        }

        // Null value passed to the validRegion function
        public function test_validRegion_PresentAndNull()
        {
            $validator = new Model_Validator();
            $this->assertFalse($validator->validRegion(null, $this->listOfRegions, 'db'),
                "Validator :: validRegion :: False when null region parameter provided");
        }

        // Value passed to the validRegion function, where the value is present in the DB but is not
        // This is an edge case (first element)
        public function test_validRegion_PresentAndValid_FirstElement()
        {
            $validator = new Model_Validator();
            $this->assertTrue($validator->validRegion('albq', $this->listOfRegions, 'db'),
                "Validator :: validRegion :: True when valid region parameter provided which is the first in the list");
        }

        // Value passed to the validRegion function, where the value is present in the DB but and is a valid region per the list of regions
        // This is typical case (first element)
        public function test_validRegion_PresentAndValid_MiddleElement()
        {
            $validator = new Model_Validator();
            $this->assertTrue($validator->validRegion('Pittsburgh', $this->listOfRegions, 'db'),
                "Validator :: validRegion :: True when valid region parameter provided which is in the middle of the list");
        }

        // Value passed to the validRegion function, where the value is present in the DB but and is a valid region per the list of regions
        // This is an edge case (last element)
        public function test_validRegion_PresentAndValid_LastElement()
        {
            $validator = new Model_Validator();
            $this->assertTrue($validator->validRegion('Foxboro_W', $this->listOfRegions, 'db'),
                "Validator :: validRegion :: True when valid region parameter provided which is at the end of the list");
        }

        // Value passed to the validRegion function, where the value is a wildcard
        public function test_validRegion_PresentAndWildcard()
        {
            $validator = new Model_Validator();
            $this->assertTrue($validator->validRegion('%', $this->listOfRegions, 'db'),
                "Validator :: validRegion :: True when a wildcard is given as the region name");
        }

        // Value passed to the validRegion function, where the value is present in the DB but and is a valid region per the list of regions
        public function test_validRegion_PresentButOutOfBounds()
        {
            $validator = new Model_Validator();
            $this->assertFalse($validator->validRegion('Billerica_W', $this->listOfRegions, 'db'),
                "Validator :: validRegion :: False when a region appears in the database but is not in the valid region list");
        }

    }

?>