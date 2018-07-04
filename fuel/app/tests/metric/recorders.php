<?php

    /**
     * @group App
     * @group aar
     * @group Model
     * @group Metric
     * @group recorder
     * @group AppControllerrecorder
     */

    class Test_Metric_Recorders extends Test_Metric_Base
    {
        protected function getClassName()
        {
            return 'Metric_Recorder';
        }

        public function test_sites()
        {
             $metric = $this->provideMetric();
             $data = $metric->sites('2017-02-03');

             $this->assertArrayHasKey('date',                                $data[0]);
             $this->assertArrayHasKey('site',                                $data[0]);
             $this->assertArrayHasKey('rec_count',                           $data[0]);
             $this->assertArrayHasKey('sum_total_space',                     $data[0]);
             $this->assertArrayHasKey('sum_total_used',                      $data[0]);;
             $this->assertArrayHasKey('sum_total_percent',                   $data[0]);
             $this->assertArrayHasKey('sum_total_percent_ratio',             $data[0]);

        }

        public function test_throughput()
        {
             $metric = $this->provideMetric();
             $data = $metric->throughput('2017-02-03', 'seca');

             $this->assertArrayHasKey('date',                                $data[0]);
             $this->assertArrayHasKey('region',                              $data[0]);
             $this->assertArrayHasKey('peak_throughput',                     $data[0]);
             $this->assertArrayHasKey('cRegion',                             $data[0]);

        }

    }
