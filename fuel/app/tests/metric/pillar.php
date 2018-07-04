<?php

    /**
     * @group App
     * @group aar
     * @group Model
     * @group Metric
     */

    class Test_Metric_Pillar extends Test_Metric_Base
    {
        protected function getClassName()
        {
            return 'Metric_Dashr';
        }

        public function test_panicscause()
        {
            $metric = $this->provideMetric();
            $availability = $metric->overallAvailability('2017-02-14', '2017-02-15');
            $dates = array_keys($panics);
            $this->assertMaxValue($dates, '2017-02-15');
            $this->assertMinValue($dates, '2017-02-14');
        }

    }
