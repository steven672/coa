<?php

    /**
     * @group App
     * @group t4
     * @group Rio
     * @group Model
     * @group Metric
     */

    class Test_Metric_cDVR_Legacy_CS extends Test_Metric_Base
    {
        protected function getClassName()
        {
            return 'Metric_cDVR_Legacy_CS';
        }

        // cs
        public function test_getCleversafeRegionStartEndRange()
        {
            $metric = $this->provideMetric();
            $raw = $metric->getCleversafeRegionStartEndRange('Vinings','2017-06-01', '2017-06-08');
            $data = $raw['data'];
            $regions = $raw['regions'];

            $this->assertMinValue($data, 'date', '2017-06-01');
            $this->assertMaxValue($data, 'date', '2017-06-08');
            $this->assertCount(8, $data);
            $this->assertArrayHasKey('site',                                $data[0]);
            $this->assertArrayHasKey('total_nodes',                         $data[0]);
            $this->assertArrayHasKey('totalok_nodes',                       $data[0]);
            $this->assertArrayHasKey('totalnotok_nodes',                    $data[0]);
            $this->assertArrayHasKey('total_usable_capacity',               $data[0]);
            $this->assertArrayHasKey('total_used_capacity',                 $data[0]);
            $this->assertArrayHasKey('average_usage_per_archive_server',    $data[0]);
            $this->assertArrayHasKey('total_usage_per_cluster',             $data[0]);
            $this->assertArrayHasKey('health_state',                        $data[0]);
            $this->assertArrayHasKey('gslb_entry',                          $data[0]);
            $this->assertArrayHasKey('date',                                $data[0]);
            $this->assertArrayHasKey('total_used_capacity_ratio',           $data[0]);

            // check list region accuracy
            $this->assertArrayHasKey('cs',              $regions[0]);
            $this->assertArrayHasKey('ddn',             $regions[0]);
            $this->assertArrayHasKey('recorders',       $regions[0]);
            $this->assertArrayHasKey('throughput',      $regions[0]);
            $this->assertArrayHasKey('text',            $regions[0]);

            $this->assertTrue($data[0]['date'] < $data[7]['date']);
        }

        public function test_getMinMax()
        {
            $metric     = $this->provideMetric();
            $raw        = $metric->getMinMax('%','2017-06-04', '2017-06-05');
            $data       = $raw['data'];
            $regions    = $raw['regions'];

            $this->assertCount(6, $raw);
            $this->assertMinValue($data, 'date', '2017-06-04');
            $this->assertMaxValue($data, 'date', '2017-06-05');

            $this->assertArrayHasKey('site',                                $data[0]);
            $this->assertArrayHasKey('total_nodes',                         $data[0]);
            $this->assertArrayHasKey('totalok_nodes',                        $data[0]);
            $this->assertArrayHasKey('totalnotok_nodes',                      $data[0]);
            $this->assertArrayHasKey('total_usable_capacity',               $data[0]);
            $this->assertArrayHasKey('total_used_capacity',                 $data[0]);
            $this->assertArrayHasKey('average_usage_per_archive_server',    $data[0]);
            $this->assertArrayHasKey('total_usage_per_cluster',             $data[0]);
            $this->assertArrayHasKey('health_state',                        $data[0]);
            $this->assertArrayHasKey('gslb_entry',                          $data[0]);
            $this->assertArrayHasKey('date',                                $data[0]);
            $this->assertArrayHasKey('total_used_capacity_ratio',           $data[0]);

            // check list region accuracy
            $this->assertArrayHasKey('cs',              $regions[0]);
            $this->assertArrayHasKey('ddn',             $regions[0]);
            $this->assertArrayHasKey('recorders',       $regions[0]);
            $this->assertArrayHasKey('throughput',      $regions[0]);
            $this->assertArrayHasKey('text',            $regions[0]);


        }

    }
