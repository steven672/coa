<?php

    /**
     * @group App
     * @group cLinear
     * @group Model
     * @group super8Daily
     */

    class Test_Metric_super8Daily extends Test_Metric_Base
    {
        protected function getClassName()
        {
            return 'Metric_super8Daily';
        }

        public function test_super8top()
        {
            $metric     = $this->provideMetric();
            $raw        = $metric->super8top('10','2017-08-10', '2017-08-11');
            $this->assertArrayHasKey('2017-08-10',                              $raw);

            $data=$raw['2017-08-10'];
            $this->assertCount(10, $data);

            $this->assertArrayHasKey('cRegion',                                  $data[0]);
            $this->assertArrayHasKey('Delivery_Lane',                            $data[0]);
            $this->assertArrayHasKey('Error_Code',                               $data[0]);
            $this->assertArrayHasKey('count',                                    $data[0]);
            $this->assertArrayHasKey('percent',                                  $data[0]);
        }

    }

