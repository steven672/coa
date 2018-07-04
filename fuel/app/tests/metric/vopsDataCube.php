<?php

    /**
     * @group App
     * @group cdvr
     * @group Model
     * @group Metric
     * @group vopsDataCube
     */

    class Test_Metric_VopsDataCube extends Test_Metric_Base
    {
        protected function getClassName()
        {
            return 'Metric_VopsDataCube';
        }

        public function test_playerregionerror()
        {
            $metric     = $this->provideMetric();
            $raw        = $metric->playerregionerror('10','2017-06-04', '2017-06-05');

            $raw1       = $raw['responsePlayerX2Hot'];
            $this->assertMinValue(array_keys($raw1), '2017-06-04');
            $this->assertMaxValue(array_keys($raw1), '2017-06-04');

            $data       = $raw1['2017-06-04'];
            $this->assertCount(10, $data);

            $this->assertArrayHasKey('REGION',                                     $data[0]);
            $this->assertArrayHasKey('SUCCEEDED',                                  $data[0]);
            $this->assertArrayHasKey('FAILED',                                     $data[0]);
            $this->assertArrayHasKey('SUCCEEDED_DEVICES',                          $data[0]);
            $this->assertArrayHasKey('FAILED_DEVICES',                             $data[0]);

            // Is every number value greater than or equal to 0
            foreach ($data as $key => $value)
            {
                $this->assertGreaterThanOrEqual(0, $value['SUCCEEDED']);
            }
            // Is every number value greater than or equal to 0
            foreach ($data as $key => $value)
            {
                $this->assertGreaterThanOrEqual(0, $value['FAILED']);
            }

        }

    }

