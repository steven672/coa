<?php

    /**
     * @group App
     * @group cDVR
     * @group Model
     * @group Metric
     * @group comcastRecorderStat
     */

    class Test_Metric_ComcastRecorderStat extends Test_Metric_Base
    {
        protected function getClassName()
        {
            return 'Metric_ComcastRecorderStat';
        }

        public function test_recordertrend()
        {
            $metric     = $this->provideMetric();
            $raw        = $metric->recordertrend('2015-11-30', '2015-12-01', '%');

           #Test keys for site, max min is alpha order
            $this->assertMinValue(array_keys($raw), '#ARRIS: CORL');
            $this->assertMaxValue(array_keys($raw), '#CISCO: STPM');

            #test keys within site, Katy for example
            $data1       =$raw['#ARRIS: CORL'];
           #Test keys for site, max min is time order
            $this->assertMinValue(array_keys($data1), '2015-11-30');
            $this->assertMaxValue(array_keys($data1), '2015-12-01');

            #test for actual valeu under date
            $data      =$data1['2015-11-30'];
            $this->assertArrayHasKey('rec_count',                         $data[0]);
            $this->assertArrayHasKey('sum_total_space',                   $data[0]);
            $this->assertArrayHasKey('sum_total_used',                    $data[0]);
            $this->assertArrayHasKey('sum_total_avail',                   $data[0]);
            $this->assertArrayHasKey('sum_total_percent',                 $data[0]);
            $this->assertArrayHasKey('recorders',                         $data[0]);

            // Is every recorder value less than or equal to 100%
            foreach ($data as $key => $value)
            {
                $this->assertLessThanOrEqual(1, $value['recorders']);
            }

           // Is every recorder value more than or equal to 100%
            foreach ($data as $key => $value)
            {
                $this->assertGreaterThanOrEqual(0, $value['recorders']);
            }
        }

    }

