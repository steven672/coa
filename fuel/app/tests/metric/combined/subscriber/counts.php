<?php

    /**
     * @group App
     * @group t8
     * @group Rio
     * @group Model
     * @group Metric
     */

    class Test_Metric_Combined_Subscriber_Counts extends Test_Metric_Base
    {
        protected function getClassName()
        {
            return 'Metric_Combined_Subscriber_Counts';
        }

        // cs
        public function test_getRegionalSubscriberCounts()
        {
            $metric = $this->provideMetric();
            $raw = $metric->getRegionalSubscriberCounts('clinear_flag','2017-06-29', '2017-06-30');
            $data = $raw;


            $this->assertMinValue($data, 'date_created', '2017-06-29');
            $this->assertMaxValue($data, 'date_created', '2017-06-30');
            $this->assertArrayHasKey('date_created',        $data[0]);
            $this->assertArrayHasKey('division_name',       $data[0]);
            $this->assertArrayHasKey('region_name',         $data[0]);
            $this->assertArrayHasKey('cdvr_flag',           $data[0]);
            $this->assertArrayHasKey('mdvr_flag',           $data[0]);
            $this->assertArrayHasKey('clinear_flag',        $data[0]);
            $this->assertArrayHasKey('count',               $data[0]);
            assert($data[0]['clinear_flag'] ==1);

        }



    }
