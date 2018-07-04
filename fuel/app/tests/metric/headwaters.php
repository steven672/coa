<?php

    /**
     * @group App
     * @group aar
     * @group Model
     * @group Metric
     */

    class Test_Metric_Headwaters extends Test_Metric_Base
    {
        protected function getClassName()
        {
            return 'Metric_Headwaters';
        }

        public function test_worstStreams()
        {
            $metric = $this->provideMetric();
            $worst = $metric->worstStreams('2017-05-17', 10);
            $this->assertCount(10, $worst);
            $this->assertArrayHasKey('success_rate', $worst[0]);
            $this->assertArrayHasKey('failed', $worst[0]);
            $this->assertTrue($worst[0]['success_rate'] < $worst[9]['success_rate'] || $worst[0]['failed'] > $worst[9]['failed']);
        }

        public function test_trendRegion()
        {
            $metric = $this->provideMetric();
            $worst = $metric->trendRegion('2017-05-17', '2017-05-18');
            $this->assertMaxValue($worst, 'date', '2017-05-18');
            $this->assertMinValue($worst, 'date', '2017-05-17');
            $this->assertMinValue($worst, 'failed', 0);
            $this->assertMaxValue($worst, 'success_rate', 1);
        }

        public function test_overallAvailability()
        {
            $metric = $this->provideMetric();
            $availability = $metric->overallAvailability('2017-05-17', '2017-05-18');
            $dates = array_keys($availability);
            $this->assertMaxValue($dates, '2017-05-18');
            $this->assertMinValue($dates, '2017-05-17');
        }
    }
