<?php

    /**
     * @group App
     * @group t2
     * @group Rio
     * @group Model
     * @group Metric
     */

    class Test_Metric_cDVR_Legacy_DDN extends Test_Metric_Base
    {
        protected function getClassName()
        {
            return 'Metric_cDVR_Legacy_DDN';
        }

        // ddn
        public function test_getDdnRegionStartEndRange()
        {
            $metric = $this->provideMetric();
            $raw = $metric->getDdnRegionStartEndRange('Manassas','2017-06-01', '2017-06-09');
            $data = $raw['data'];
            $regions = $raw['regions'];

            $this->assertMinValue($data, 'date', '2017-06-01');
            $this->assertMaxValue($data, 'date', '2017-06-09');
            $this->assertCount(9, $data);
            $this->assertArrayHasKey('site',                                $data[0]);
            $this->assertArrayHasKey('total_nodes',                         $data[0]);
            $this->assertArrayHasKey('active_nodes',                        $data[0]);
            $this->assertArrayHasKey('total_inactive',                      $data[0]);
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

            $this->assertTrue($data[0]['date'] < $data[8]['date']);
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
            $this->assertArrayHasKey('active_nodes',                        $data[0]);
            $this->assertArrayHasKey('total_inactive',                      $data[0]);
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
