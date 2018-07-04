<?php

    /**
     * @group App
     * @group t5
     * @group Rio
     * @group Model
     * @group Metric
     */

    class Test_Metric_cDVR_Legacy_Recorders extends Test_Metric_Base
    {
        protected function getClassName()
        {
            return 'Metric_cDVR_Legacy_Recorders';
        }


        public function test_getMinMax()
        {
            $metric     = $this->provideMetric();
            $raw        = $metric->getMinMax('%','2017-06-04', '2017-06-05');
            $data       = $raw['data'];
            $regions    = $raw['regions'];

            $this->assertCount(6, $raw);
            $this->assertMinValue($data, 'date', '2017-06-04');
            $this->assertMaxValue($data, 'date', '2017-06-05');

            $this->assertArrayHasKey('date',                                $data[0]);
            $this->assertArrayHasKey('region',                         $data[0]);
            $this->assertArrayHasKey('peak_throughput',                       $data[0]);
            $this->assertArrayHasKey('cRegion',                    $data[0]);


            // check list region accuracy
            $this->assertArrayHasKey('cs',              $regions[0]);
            $this->assertArrayHasKey('ddn',             $regions[0]);
            $this->assertArrayHasKey('recorders',       $regions[0]);
            $this->assertArrayHasKey('throughput',      $regions[0]);
            $this->assertArrayHasKey('text',            $regions[0]);

        }

    }
