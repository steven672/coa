<?php

    /**
     * @group App
     * @group t5
     * @group Model
     * @group Metric
     */

    class Test_Metric_cDVR_Legacy extends Test_Metric_Base
    {
        protected function getClassName()
        {
            return 'Metric_cDVR_Legacy';
        }


        public function test_getHealth()
        {
            $metric     = $this->provideMetric();
            $raw        = $metric->getHealth('2017-06-06', '%');
            $data       = $raw['data'];
            $regions    = $raw['regions'];

            $this->assertArrayHasKey('region',                                $data[0]);
            $this->assertArrayHasKey('health',                                $data[0]);


            // check list region accuracy
            $this->assertArrayHasKey('cs',              $regions[0]);
            $this->assertArrayHasKey('ddn',             $regions[0]);
            $this->assertArrayHasKey('recorders',       $regions[0]);
            $this->assertArrayHasKey('throughput',      $regions[0]);
            $this->assertArrayHasKey('text',            $regions[0]);


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

            $this->assertArrayHasKey('date',                         $data[0]);
            $this->assertArrayHasKey('site',                         $data[0]);
            $this->assertArrayHasKey('rec_count',                    $data[0]);
            $this->assertArrayHasKey('sum_total_space',              $data[0]);
            $this->assertArrayHasKey('sum_total_used',               $data[0]);
            $this->assertArrayHasKey('sum_total_avail',              $data[0]);
            $this->assertArrayHasKey('sum_total_percent',            $data[0]);


            // check list region accuracy
            $this->assertArrayHasKey('cs',              $regions[0]);
            $this->assertArrayHasKey('ddn',             $regions[0]);
            $this->assertArrayHasKey('recorders',       $regions[0]);
            $this->assertArrayHasKey('throughput',      $regions[0]);
            $this->assertArrayHasKey('text',            $regions[0]);


        }

        public function test_getPriority()
        {
            $metric                 = $this->provideMetric();
            $raw                    = $metric->getPriority('%','2017-06-06','2017-06-08');
            $health                 = $raw['dataHealth'];
            $priorityMarket         = $raw['priorityMarket'];
            $priorityMarketRegion   = $raw['priorityMarketRegion'];
            $dataThroughput         = $raw['dataThroughput'];
            $regions                = $raw['regions'];
            $dataDDN                = $raw['dataDDN'];
            $dataCS                 = $raw['dataCS'];
            $dataRecorders          = $raw['dataRecorders'];
            $dataTrending           = $raw['dataTrending'];


            $this->assertCount(9, $raw);

            $this->assertArrayHasKey('region',                         $health[0]);
            $this->assertArrayHasKey('health',                         $health[0]);
            $this->assertArrayHasKey('region',                         $priorityMarket);
            $this->assertArrayHasKey('health',                         $priorityMarket);

            // guarntee the fields num matched.
            $this->assertCount(12, $dataCS);
            $this->assertCount(12, $dataDDN);
            $this->assertCount(8, $dataRecorders);


            // check list region accuracy
            $this->assertArrayHasKey('cs',              $regions[0]);
            $this->assertArrayHasKey('ddn',             $regions[0]);
            $this->assertArrayHasKey('recorders',       $regions[0]);
            $this->assertArrayHasKey('throughput',      $regions[0]);
            $this->assertArrayHasKey('text',            $regions[0]);

        }

    }
