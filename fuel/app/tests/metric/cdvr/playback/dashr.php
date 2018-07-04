<?php

    /**
     * @group App
     * @group aar
     * @group Model
     * @group Metric
     */

    class Test_Metric_cDVR_Playback_Dashr extends Test_Metric_Base
    {
        protected function getClassName()
        {
            return 'Metric_cDVR_Playback_Dashr';
        }

        public function test_worstStreams()
        {
            $metric = $this->provideMetric();
            $worst = $metric->worstStreams('2017-06-06', 10);
            $this->assertCount(10, $worst);
            $this->assertArrayHasKey('recorderid', $worst[0]);
            $this->assertArrayHasKey('cregion', $worst[0]);
            $this->assertArrayHasKey('error', $worst[0]);
            $this->assertArrayHasKey('type', $worst[0]);
            $this->assertTrue($worst[0]['error'] > $worst[9]['error']);
        }

    }
