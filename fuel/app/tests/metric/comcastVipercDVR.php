<?php

    /**
     * @group App
     * @group cLinear
     * @group Model
     * @group Metric
     * @group ComcastVipercDVR
     */

    class Test_Metric_ComcastVipercDVR extends Test_Metric_Base
    {
        protected function getClassName()
        {
            return 'Metric_ComcastVipercDVR';
        }


        public function test_availabilitySuper8()
        {
            $metric     = $this->provideMetric();
            $raw        = $metric->availabilitySuper8('2017-06-04', '2017-06-05');

            $data = $raw['2017-06-04'];

            $this->assertMinValue(array_keys($raw), '2017-06-04');
            $this->assertMaxValue(array_keys($raw), '2017-06-05');

            $this->assertArrayHasKey('facility',                     $data[0]);
            $this->assertArrayHasKey('cregion',                      $data[0]);
            $this->assertArrayHasKey('error',                        $data[0]);
            $this->assertArrayHasKey('type',                         $data[0]);
            $this->assertArrayHasKey('stream_avail_per',             $data[0]);

            // Is every stream_avail_per value less than or equal to 100?
            // Is every stream_avail_per value greater than or equal to 0?
            // Is every error value an unsigned integer value, for example 123456.?
            foreach ($data as $key => $value)
            {
                $this->assertLessThanOrEqual(100, $value['stream_avail_per']);
                $this->assertGreaterThanOrEqual(0, $value['stream_avail_per']);
                $this->assertStringMatchesFormat('%d', $value['error']);
            }

        }


        public function test_availabilityDashr()
        {
            $metric     = $this->provideMetric();
            $raw        = $metric->availabilityDashr('2017-08-01', '2017-08-02');

            $data = $raw['2017-08-01'];

            $this->assertMinValue(array_keys($raw), '2017-08-01');
            $this->assertMaxValue(array_keys($raw), '2017-08-02');

            $this->assertArrayHasKey('cregion',                     $data[0]);
            $this->assertArrayHasKey('error',                       $data[0]);
            $this->assertArrayHasKey('type',                        $data[0]);
            $this->assertArrayHasKey('errorfree_percentage',        $data[0]);

            // Is every errorfree_percentage value less than or equal to 100?
            // Is every errorfree_percentage value greater than or equal to 100?
            // Is every 'error' value an unsigned integer value, for example 123456.
            foreach ($data as $key => $value)
            {
                $this->assertLessThanOrEqual(100, $value['errorfree_percentage']);
                $this->assertGreaterThanOrEqual(0, $value['errorfree_percentage']);
                $this->assertStringMatchesFormat('%d', $value['error']);
            }

        }

    }

