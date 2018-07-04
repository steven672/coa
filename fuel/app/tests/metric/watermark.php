<?php

    /**
     * @group App
     * @group Watermark
     * @group Model
     * @group Metric
     */

    class Test_Metric_Watermark extends Test_Metric_Base
    {
        protected function getClassName()
        {
            return 'Metric_Watermark';
        }


        public function test_cox()
        {
            $metric     = $this->provideMetric();
            $raw        = $metric->cox('%','2017-06-04', '2017-06-05');
            $data       = $raw['data'];
            $regions    = $raw['regions'];

            $this->assertCount(6, $raw);
            $this->assertMinValue($data, 'date', '2017-06-04');
            $this->assertMaxValue($data, 'date', '2017-06-05');

            $this->assertArrayHasKey('host',                                  $data[0]);
            $this->assertArrayHasKey('down',                                  $data[0]);
            $this->assertArrayHasKey('code',                                  $data[0]);
            $this->assertArrayHasKey('avail_p',                               $data[0]);

        }

    }

