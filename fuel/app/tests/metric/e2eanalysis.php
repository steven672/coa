<?php

    /**
     * @group App
     * @group cLinear
     * @group Model
     * @group Metric
     * @group e2eanalysis
     */

    class Test_Metric_e2eanalysis extends Test_Metric_Base
    {
        protected function getClassName()
        {
            return 'Metric_e2eanalysis';
        }


        public function test_comcast()
        {
            $metric     = $this->provideMetric();
            $raw        = $metric->comcast('2017-08-19', '2017-08-20');


            foreach ($raw as $key => $value)
            {
                $this->assertLessThanOrEqual(100, $value['pillar0_5']);
                $this->assertGreaterThanOrEqual(0, $value['pillar0_5']);

                $this->assertLessThanOrEqual(100, $value['pillarlowest5avg']);
                $this->assertGreaterThanOrEqual(0, $value['pillarlowest5avg']);

                $this->assertLessThanOrEqual(100, $value['varnish0_5']);
                $this->assertGreaterThanOrEqual(0, $value['varnish0_5']);

                $this->assertLessThanOrEqual(100, $value['varnishlowest5avg']);
                $this->assertGreaterThanOrEqual(0, $value['varnishlowest5avg']);

                $this->assertLessThanOrEqual(100, $value['super8_0_5']);
                $this->assertGreaterThanOrEqual(0, $value['super8_0_5']);

                $this->assertLessThanOrEqual(100, $value['super8lowest5avg']);
                $this->assertGreaterThanOrEqual(0, $value['super8lowest5avg']);

                $this->assertArrayHasKey('date_created',                $value);
                $this->assertArrayHasKey('pillar0_5',                   $value);
                $this->assertArrayHasKey('pillarlowest5avg',            $value);
                $this->assertArrayHasKey('varnish0_5',                  $value);
                $this->assertArrayHasKey('varnishlowest5avg',           $value);
                $this->assertArrayHasKey('super8_0_5',                  $value);
                $this->assertArrayHasKey('super8lowest5avg',            $value);
            }


        }

    }

