<?php

    /**
     * @group App
     * @group failures
     * @group Rio
     * @group Model
     * @group Metric
     */

    class Test_Metric_cDVR_Performance_Rio_Failures extends Test_Metric_Base
    {
        protected function getClassName()
        {
            return 'Metric_cDVR_Performance_Rio_Failures';
        }

        // cs
        public function test_getWorst5StreamsWith5Market()
        {
            $metric = $this->provideMetric();
            $data = $metric->getWorst5StreamsWith5Market('2017-06-26', '2017-06-26', '%');

            $this->assertMinValue($data, 'date_created', '2017-06-26');
            $this->assertMaxValue($data, 'date_created', '2017-06-26');
            $this->assertCount(9, $data[0]);
            $this->assertArrayHasKey('date_created',        $data[0]);
            $this->assertArrayHasKey('cRegion',             $data[0]);
            $this->assertArrayHasKey('StreamId',            $data[0]);
            $this->assertArrayHasKey('Total',               $data[0]);
            $this->assertArrayHasKey('Failed',              $data[0]);
            $this->assertArrayHasKey('Incomplete',          $data[0]);
            $this->assertArrayHasKey('Success',             $data[0]);
            $this->assertArrayHasKey('FailureRate',         $data[0]);
            $this->assertArrayHasKey('SuccessRate',         $data[0]);

        }

        // cs
        public function test_getMarkets()
        {
            $metric = $this->provideMetric();
            $markets = $metric->getMarkets('2017-08-01', '2017-08-02');
            $data = $markets['data'];
            $this->assertMinValue($data['data'], 'date_created', '2017-08-02');
            $this->assertMaxValue($data['data'], 'date_created', '2017-08-03');
            $this->assertArrayHasKey('date_created',            $data[0]);
            $this->assertArrayHasKey('market',                  $data[0]);
            $this->assertArrayHasKey('recording_total',         $data[0]);
            $this->assertArrayHasKey('recording_failed',        $data[0]);
            $this->assertArrayHasKey('recording_Incomplete',    $data[0]);
            $this->assertArrayHasKey('recording_success',       $data[0]);
            $this->assertArrayHasKey('recording_failureRate',   $data[0]);
            $this->assertArrayHasKey('recording_incompleteRate',$data[0]);
            $this->assertArrayHasKey('recording_successRate',   $data[0]);
            $this->assertArrayHasKey('totalRecordingsSummed',   $markets);
            $this->assertArrayHasKey('failuresSummed',          $markets);
            $this->assertArrayHasKey('successRate',             $markets);
            $this->assertArrayHasKey('failureRate',             $markets);
        }

    }
