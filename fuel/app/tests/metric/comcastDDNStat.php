<?php

    /**
     * @group App
     * @group cdvr
     * @group Model
     * @group Metric
     * @group comcastDDNStat
     */

    class Test_Metric_ComcastDDNStat extends Test_Metric_Base
    {
        protected function getClassName()
        {
            return 'Metric_ComcastDDNStat';
        }

        public function test_cstrend()
        {
            $metric     = $this->provideMetric();
            $raw        = $metric->cstrend('2015-11-30', '2015-12-01', '%');

           #Test keys for site, max min is alpha order
            $this->assertMinValue(array_keys($raw), 'Foxboro_GBR');
            $this->assertMaxValue(array_keys($raw), 'Vinings');

            #test keys within site, Katy for example
            $data1       =$raw['Katy'];
           #Test keys for site, max min is time order
            $this->assertMinValue(array_keys($data1), '2015-11-30');
            $this->assertMaxValue(array_keys($data1), '2015-12-01');

            #test for actual valeu under date
            $data      =$data1['2015-11-30'];
            $this->assertArrayHasKey('total_nodes',                         $data[0]);
            $this->assertArrayHasKey('totalok_nodes',                       $data[0]);
            $this->assertArrayHasKey('totalnotok_nodes',                    $data[0]);
            $this->assertArrayHasKey('total_usable_capacity',               $data[0]);
            $this->assertArrayHasKey('total_used_capacity',                 $data[0]);
            $this->assertArrayHasKey('average_usage_per_archive_server',    $data[0]);
            $this->assertArrayHasKey('total_usage_per_cluster',             $data[0]);
            $this->assertArrayHasKey('health_state',                        $data[0]);
            $this->assertArrayHasKey('gslb_entry',                          $data[0]);
            $this->assertArrayHasKey('cs',                                  $data[0]);

            // Is every cs value less than or equal to 100%
            foreach ($data as $key => $value)
            {
                $this->assertLessThanOrEqual(1, $value['cs']);
            }

           // Is every cs value more than or equal to 100%
            foreach ($data as $key => $value)
            {
                $this->assertGreaterThanOrEqual(0, $value['cs']);
            }
        }


        public function test_health()
        {
            $metric     = $this->provideMetric();
            $raw        = $metric->health('2017-08-08', '%');

            foreach ($raw as $key => $value)
            {
                $this->assertArrayHasKey('region',        $value);
                $this->assertArrayHasKey('health',        $value);

            }

        }

        public function test_ddntrend()
        {
            $metric     = $this->provideMetric();
            $raw        = $metric->ddntrend('2015-11-30', '2015-12-01', '%');

           #Test keys for site, max min is alpha order
            $this->assertMinValue(array_keys($raw), 'Albuquerque');
            $this->assertMaxValue(array_keys($raw), 'Vinings');

            #test keys within site, Katy for example
            $data1       =$raw['Katy'];
           #Test keys for site, max min is time order
            $this->assertMinValue(array_keys($data1), '2015-11-30');
            $this->assertMaxValue(array_keys($data1), '2015-12-01');

            #test for actual valeu under date
            $data      =$data1['2015-11-30'];
            $this->assertArrayHasKey('total_nodes',                         $data[0]);
            $this->assertArrayHasKey('active_nodes',                        $data[0]);
            $this->assertArrayHasKey('total_inactive',                      $data[0]);
            $this->assertArrayHasKey('total_usable_capacity',               $data[0]);
            $this->assertArrayHasKey('total_used_capacity',                 $data[0]);
            $this->assertArrayHasKey('average_usage_per_archive_server',    $data[0]);
            $this->assertArrayHasKey('total_usage_per_cluster',             $data[0]);
            $this->assertArrayHasKey('health_state',                        $data[0]);
            $this->assertArrayHasKey('gslb_entry',                          $data[0]);
            $this->assertArrayHasKey('ddn',                                 $data[0]);


            // Is every ddn value less than or equal to 100%
            foreach ($data as $key => $value)
            {
                $this->assertLessThanOrEqual(1, $value['ddn']);
            }

           // Is every ddn value more than or equal to 100%
            foreach ($data as $key => $value)
            {
                $this->assertGreaterThanOrEqual(0, $value['ddn']);
            }
        }   


        public function test_getsites()
        {
            $metric     = $this->provideMetric();
            $raw        = $metric->getsites('2017-08-08', '%');


            foreach ($raw as $key => $value)
            {

                // Are all the fields sent to the client?
                $this->assertArrayHasKey('site',                              $value);
                $this->assertArrayHasKey('total_nodes',                       $value);
                $this->assertArrayHasKey('totalok_nodes',                     $value);
                $this->assertArrayHasKey('totalnotok_nodes',                  $value);
                $this->assertArrayHasKey('total_usable_capacity',             $value);
                $this->assertArrayHasKey('total_used_capacity',               $value);
                $this->assertArrayHasKey('active_vault',                      $value);
                $this->assertArrayHasKey('archive_vault',                     $value);
                $this->assertArrayHasKey('recon_vault',                       $value);
                $this->assertArrayHasKey('average_usage_per_archive_server',  $value);
                $this->assertArrayHasKey('total_usage_per_cluster',           $value);
                $this->assertArrayHasKey('health_state',                      $value);
                $this->assertArrayHasKey('date',                              $value);
                $this->assertArrayHasKey('logical_active_totalspace',         $value);
                $this->assertArrayHasKey('logical_active_usedspace',          $value);
                $this->assertArrayHasKey('logical_active_freespace',          $value);
                $this->assertArrayHasKey('logical_archive_totalspace',        $value);
                $this->assertArrayHasKey('logical_archive_usedspace',         $value);
                $this->assertArrayHasKey('logical_archive_freespace',         $value);
                $this->assertArrayHasKey('logical_recon_totalspace',          $value);
                $this->assertArrayHasKey('logical_recon_usedspace',           $value);
                $this->assertArrayHasKey('logical_recon_freespace',           $value);
                $this->assertArrayHasKey('total_used_capacity_ratio',         $value);


                // Do all the fields contain the correctly formatted data?
                $this->assertStringMatchesFormat('%d',        $value['total_nodes']);  // An unsigned integer value, for example 123456
                $this->assertStringMatchesFormat('%d',        $value['totalok_nodes']);
                $this->assertStringMatchesFormat('%d',        $value['totalnotok_nodes']);
                $this->assertStringMatchesFormat('%f',        $value['total_usable_capacity']);  // A floating point number, for example: 3.142
                $this->assertStringMatchesFormat('%f',        $value['total_used_capacity']);
                $this->assertStringMatchesFormat('%f',        $value['active_vault']);
                $this->assertStringMatchesFormat('%f',        $value['archive_vault']);
                $this->assertStringMatchesFormat('%f',        $value['recon_vault']);
                $this->assertStringMatchesFormat('%f',        $value['average_usage_per_archive_server']);
                $this->assertStringMatchesFormat('%f',        $value['total_usage_per_cluster']);
                $this->assertStringMatchesFormat('%f',        $value['logical_active_totalspace']);
                $this->assertStringMatchesFormat('%f',        $value['logical_active_usedspace']);
                $this->assertStringMatchesFormat('%f',        $value['logical_active_freespace']);
                $this->assertStringMatchesFormat('%f',        $value['logical_archive_totalspace']);
                $this->assertStringMatchesFormat('%f',        $value['logical_archive_usedspace']);
                $this->assertStringMatchesFormat('%f',        $value['logical_archive_freespace']);
                $this->assertStringMatchesFormat('%f',        $value['logical_recon_totalspace']);
                $this->assertStringMatchesFormat('%f',        $value['logical_recon_usedspace']);
                $this->assertStringMatchesFormat('%f',        $value['logical_recon_freespace']);

                // Is total_used_capacity_ratio >= 0 and <= to 1?
                $this->assertLessThanOrEqual(1, $value['total_used_capacity_ratio']);
                $this->assertGreaterThanOrEqual(0, $value['total_used_capacity_ratio']);

            }

        }

    }

