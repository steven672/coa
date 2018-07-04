<?php

    /**
     * @group App
     * @group cLinear
     * @group Model
     * @group Metric
     * @group comcastViperWatermarkNew
     */

    class Test_Metric_ComcastViperWatermarkNew extends Test_Metric_Base
    {
        protected function getClassName()
        {
            return 'Metric_ComcastViperWatermarkNew';
        }

        public function test_coxsuper8availability()
        {
            $metric     = $this->provideMetric();
            $raw        = $metric->coxsuper8availability('2017-08-10', '2017-08-11');

            $this->assertMinValue(array_keys($raw), '2017-08-10');
            $this->assertMaxValue(array_keys($raw), '2017-08-11');

            $data       = $raw['2017-08-10'];

            $this->assertArrayHasKey('region',                                    $data[0]);
            $this->assertArrayHasKey('Down',                                      $data[0]);
            $this->assertArrayHasKey('avg_errorfree_rate',                        $data[0]);

                        // Is every avg_errorfree_rate value less than or equal to 100%
            foreach ($data as $key => $value)
            {
                $this->assertLessThanOrEqual(100, $value['avg_errorfree_rate']);
            }

           // Is every avg_errorfree_rate value more than or equal to 100%
            foreach ($data as $key => $value)
            {
                $this->assertGreaterThanOrEqual(0, $value['avg_errorfree_rate']);
            }
        }


        public function test_coxsuper8worst10()
        {
            #tst for overall raw data key
            $metric     = $this->provideMetric();
            $raw        = $metric->coxsuper8worst10('10','2017-08-10', '2017-08-11');
            $this->assertArrayHasKey('2017-08-10',                               $raw);
            #test for specific date and count key

            $data      =$raw['2017-08-10'];
            $this->assertCount(10, $data);

            #test for specific field
            $this->assertArrayHasKey('region',                                   $data[0]);
            $this->assertArrayHasKey('channel',                                  $data[0]);
            $this->assertArrayHasKey('Down',                                     $data[0]);
            $this->assertArrayHasKey('Code',                                     $data[0]);
            $this->assertArrayHasKey('avg_errorfree_rate',                       $data[0]);

                        // Is every cs value less than or equal to 100%
            foreach ($data as $key => $value)
            {
                $this->assertLessThanOrEqual(100, $value['avg_errorfree_rate']);
            }

           // Is every cs value more than or equal to 100%
            foreach ($data as $key => $value)
            {
                $this->assertGreaterThanOrEqual(0, $value['avg_errorfree_rate']);
            }
        }

        public function test_coxpillarworst10()
        {
            #tst for overall raw data key
            $metric     = $this->provideMetric();
            $raw        = $metric->coxpillarworst10('10','2017-08-10', '2017-08-11');
            $this->assertArrayHasKey('responseCoxWorst10Pillar',                $raw);

            #test for specific date and count key
            $data      =$raw['responseCoxWorst10Pillar'];
            $this->assertArrayHasKey('2017-08-10',                               $data);

            $data1      =$data['2017-08-10'];
            $this->assertCount(10,                                               $data1);

            #test for specific field
            $this->assertArrayHasKey('region',                                    $data1[0]);
            $this->assertArrayHasKey('channel',                                   $data1[0]);
            $this->assertArrayHasKey('ErrorMinutes',                              $data1[0]);
            $this->assertArrayHasKey('TotalMinutes',                              $data1[0]);
            $this->assertArrayHasKey('AvgErrorFreeTime_Percentage',               $data1[0]);

                                    // Is every cs value less than or equal to 100%
            foreach ($data1 as $key => $value)
            {
                $this->assertLessThanOrEqual(100, $value['AvgErrorFreeTime_Percentage']);
            }

           // Is every cs value more than or equal to 100%
            foreach ($data1 as $key => $value)
            {
                $this->assertGreaterThanOrEqual(0, $value['AvgErrorFreeTime_Percentage']);
            }
        }

    }

