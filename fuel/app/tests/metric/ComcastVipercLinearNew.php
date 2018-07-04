<?php

    /**
     * @group App
     * @group cLinear
     * @group Model
     * @group Metric
     * @group comcastVipercLinearNew
     */

    class Test_Metric_ComcastVipercLinearNew extends Test_Metric_Base
    {
        protected function getClassName()
        {
            return 'Metric_ComcastVipercLinearNew';
        }


        // public function test_comcast()
        // {
        //     $metric     = $this->provideMetric();
        //     $raw        = $metric->comcast('%','2017-06-04', '2017-06-05');
        //     $data       = $raw['data'];
        //     $regions    = $raw['regions'];

        //     $this->assertCount(6, $raw);
        //     $this->assertMinValue($data, 'date', '2017-06-04');
        //     $this->assertMaxValue($data, 'date', '2017-06-05');

        //     $this->assertArrayHasKey('cfacility',                                $data[0]);
        //     $this->assertArrayHasKey('cregion',                                  $data[0]);
        //     $this->assertArrayHasKey('channel',                                  $data[0]);
        //     $this->assertArrayHasKey('minutes_with_error',                       $data[0]);
        //     $this->assertArrayHasKey('total_minutes',                            $data[0]);
        //     $this->assertArrayHasKey('average_errorfree_minute_percentage',      $data[0]);

        // }


        public function test_comcastAvailabilityAverage()
        {
            $metric     = $this->provideMetric();
            $raw        = $metric->comcastAvailabilityAverage('2017-01-01', '2017-01-02');

            $data = $raw['2017-01-01'];

            $this->assertMinValue(array_keys($raw), '2017-01-01');
            $this->assertMaxValue(array_keys($raw), '2017-01-02');

            $this->assertArrayHasKey('facility',          $data[0]);
            $this->assertArrayHasKey('region',            $data[0]);
            $this->assertArrayHasKey('avg',               $data[0]);
            $this->assertArrayHasKey('med',               $data[0]);
            $this->assertArrayHasKey('min',               $data[0]);
            $this->assertArrayHasKey('errors',            $data[0]);
            $this->assertArrayHasKey('average',           $data[0]);
            $this->assertArrayHasKey('avail',             $data[0]);

            // Is every avg value < or = to 100 and > or = 100?
            // Is every med value < or = to 100 and > or = 100?
            // Is every min value < or = to 100 and > or = 100?
            // Is every average value < or = to 100 and > or = 100?
            // Is every avail value < or = to 100 and > or = 100?
            // Is every 'errors' value an unsigned integer value, for example 123456.
            foreach ($data as $key => $value)
            {
                $this->assertLessThanOrEqual(100, $value['avg']);
                $this->assertGreaterThanOrEqual(0, $value['avg']);

                $this->assertLessThanOrEqual(100, $value['med']);
                $this->assertGreaterThanOrEqual(0, $value['med']);

                $this->assertLessThanOrEqual(100, $value['min']);
                $this->assertGreaterThanOrEqual(0, $value['min']);

                $this->assertLessThanOrEqual(100, $value['average']);
                $this->assertGreaterThanOrEqual(0, $value['average']);

                $this->assertLessThanOrEqual(100, $value['avail']);
                $this->assertGreaterThanOrEqual(0, $value['avail']);

                $this->assertStringMatchesFormat('%d', $value['errors']);
            }

            // Is every average_errorfree_minute_percentage value less than or equal to 100%
            foreach ($data as $key => $value)
            {
                $this->assertLessThanOrEqual(100, $value['average_errorfree_minute_percentage']);
            }

           // Is every average_errorfree_minute_percentage value more than or equal to 100%
            foreach ($data as $key => $value)
            {
                $this->assertGreaterThanOrEqual(0, $value['average_errorfree_minute_percentage']);
            }

        }

        public function test_super8availability()
        {
            $metric     = $this->provideMetric();
            $raw        = $metric->super8availability('2017-08-15', '2017-08-16');
            $this->assertArrayHasKey('data',                                $raw);
            $this->assertArrayHasKey('dataFacility',                        $raw);
            $this->assertArrayHasKey('dataCregion',                         $raw);
            $this->assertArrayHasKey('histogramData1',                      $raw);


            $raw1       =$raw['data'];
            $this->assertMinValue(array_keys($raw1), '2017-08-15');
            $this->assertMaxValue(array_keys($raw1), '2017-08-16');

            $data       = $raw1['2017-08-15'];

            $this->assertArrayHasKey('cregion',                                  $data[0]);
            $this->assertArrayHasKey('error_count',                              $data[0]);
            $this->assertArrayHasKey('error_free_rate',                          $data[0]);

                        // Is every error_free_rate value less than or equal to 100%
            foreach ($data as $key => $value)
            {
                $this->assertLessThanOrEqual(100, $value['error_free_rate']);
            }

           // Is every error_free_rate value more than or equal to 100%
            foreach ($data as $key => $value)
            {
                $this->assertGreaterThanOrEqual(0, $value['error_free_rate']);
            }

        }


        public function test_super8worst10()
        {
            #tst for overall raw data key
            $metric     = $this->provideMetric();
            $raw        = $metric->super8worst10('10','2017-06-04', '2017-06-05');
            $this->assertArrayHasKey('NATWorst10',                               $raw);
            $this->assertArrayHasKey('RegWorst10',                               $raw);
            $this->assertArrayHasKey('RegWorst5',                                $raw);

            #test for specific date and count key
            $data       = $raw['NATWorst10'];
            $data1      =$data['2017-06-04'];

            $this->assertArrayHasKey('2017-06-04',                               $data);
            $this->assertCount(10, $data1);

            #test for specific field
            $this->assertArrayHasKey('stream',                                   $data1[0]);
            $this->assertArrayHasKey('cfacility',                                $data1[0]);
            $this->assertArrayHasKey('cregion',                                  $data1[0]);
            $this->assertArrayHasKey('error_count',                              $data1[0]);
            $this->assertArrayHasKey('error_free_rate',                          $data1[0]);

                        // Is every cs value less than or equal to 100%
            foreach ($data1 as $key => $value)
            {
                $this->assertLessThanOrEqual(100, $value['error_free_rate']);
            }

           // Is every cs value more than or equal to 100%
            foreach ($data1 as $key => $value)
            {
                $this->assertGreaterThanOrEqual(0, $value['error_free_rate']);
            }
        }

         public function test_super8trend()
        {
            $metric     = $this->provideMetric();
            $raw        = $metric->super8trend('2017-08-15', '2017-08-16','%','%');

            #test for facility region
            $this->assertArrayHasKey('Woburn',                                $raw);
            $this->assertArrayHasKey('Vinings',                               $raw);

            $rawFacility =$raw['Woburn'];
            $this->assertArrayHasKey('GBR',                                   $rawFacility);

            $rawRegion=$rawFacility['GBR'];
            $this->assertMinValue(array_keys($rawRegion), '2017-08-15');
            $this->assertMaxValue(array_keys($rawRegion), '2017-08-16');

            $rawDate=$rawRegion['2017-08-15'];
            $this->assertArrayHasKey('error_count',                              $rawDate[0]);
            $this->assertArrayHasKey('error_free_rate',                          $rawDate[0]);

                        // Is every cs value less than or equal to 100%
            foreach ($rawDate as $key => $value)
            {
                $this->assertLessThanOrEqual(100, $value['error_free_rate']);
            }

           // Is every cs value more than or equal to 100%
            foreach ($rawDate as $key => $value)
            {
                $this->assertGreaterThanOrEqual(0, $value['error_free_rate']);
            }
        }

        public function test_pillarrestart()
        {
            #tst for overall raw data key
            $metric     = $this->provideMetric();
            $data        = $metric->pillarrestart('10','2017-08-15', '2017-08-16');

            #test for specific date and count key
            $data1      =$data['2017-08-15'];

            $this->assertArrayHasKey('2017-08-15',                               $data);
            $this->assertCount(8,                                                $data1);

            #test for specific field
            $this->assertArrayHasKey('facility',                                 $data1[0]);
            $this->assertArrayHasKey('region',                                   $data1[0]);
            $this->assertArrayHasKey('restartCount',                             $data1[0]);
            $this->assertArrayHasKey('errorMinutes',                             $data1[0]);
            $this->assertArrayHasKey('errorMinutesAllStream',                    $data1[0]);
        }


        public function test_varnishcache()
        {
            #tst for overall raw data key
            $metric     = $this->provideMetric();
            $data       = $metric->varnishcache('2017-08-15', '2017-08-16');

            #test for specific date and count key
            $data1      =$data['2017-08-15'];

            $this->assertArrayHasKey('2017-08-15',                               $data);

            #test for specific field
            $this->assertArrayHasKey('cFacility',                                 $data1[0]);
            $this->assertArrayHasKey('cRegion',                                   $data1[0]);
            $this->assertArrayHasKey('loggedTime',                                $data1[0]);
            $this->assertArrayHasKey('total',                                     $data1[0]);
            $this->assertArrayHasKey('success',                                   $data1[0]);
            $this->assertArrayHasKey('efficiency',                                $data1[0]);
            $this->assertArrayHasKey('fail',                                      $data1[0]);
        }

        public function test_transcoderalarmworst10()
        {
            #tst for overall raw data key
            $metric     = $this->provideMetric();
            $raw        = $metric->transcoderalarmworst10('10','2017-06-04', '2017-06-05');
            $this->assertArrayHasKey('responseTranscoderHotAlarms10',             $raw);

            // test for specific date and count key
            $data       =$raw['responseTranscoderHotAlarms10'];
            $this->assertArrayHasKey('responseTranscoderHotAlarms10',             $raw);

            // test for specific date and count key
            $data1      =$data['2017-06-04'];

            $this->assertArrayHasKey('2017-06-04',                                $data);

            $this->assertCount(10,                                                $data1);
            $this->assertArrayHasKey('region',                                    $data1[0]);
            $this->assertArrayHasKey('transcoderName',                            $data1[0]);
            $this->assertArrayHasKey('transcoderIP',                              $data1[0]);
            $this->assertArrayHasKey('alarmNum_sev_012',                          $data1[0]);
            $this->assertArrayHasKey('sev0',                                      $data1[0]);
            $this->assertArrayHasKey('sev1',                                      $data1[0]);
            $this->assertArrayHasKey('sev2',                                      $data1[0]);
            $this->assertArrayHasKey('sev3',                                      $data1[0]);
            $this->assertArrayHasKey('sev4',                                      $data1[0]);

        }


        public function test_coxAvailabilityAverage()
        {
            $metric     = $this->provideMetric();
            $raw        = $metric->coxAvailabilityAverage('2017-08-17', '2017-08-18');

            $data = $raw['2017-08-17'];

            $this->assertMinValue(array_keys($raw), '2017-08-17');
            $this->assertMaxValue(array_keys($raw), '2017-08-18');

            $this->assertArrayHasKey('region',          $data[0]);
            $this->assertArrayHasKey('Avg',            $data[0]);
            $this->assertArrayHasKey('Med',               $data[0]);
            $this->assertArrayHasKey('Min',               $data[0]);
            $this->assertArrayHasKey('Down',               $data[0]);
            $this->assertArrayHasKey('average',            $data[0]);

            // Is every Avg value < or = to 100 and > or = 100?
            // Is every Med value < or = to 100 and > or = 100?
            // Is every Min value < or = to 100 and > or = 100?
            // Is every average value < or = to 100 and > or = 100?
            // Is every 'Down' value an unsigned integer value, for example 123456.
            foreach ($data as $key => $value)
            {
                $this->assertLessThanOrEqual(100, $value['Avg']);
                $this->assertGreaterThanOrEqual(0, $value['Avg']);

                $this->assertLessThanOrEqual(100, $value['Med']);
                $this->assertGreaterThanOrEqual(0, $value['Med']);

                $this->assertLessThanOrEqual(100, $value['Min']);
                $this->assertGreaterThanOrEqual(0, $value['Min']);

                $this->assertLessThanOrEqual(100, $value['average']);
                $this->assertGreaterThanOrEqual(0, $value['average']);

                $this->assertStringMatchesFormat('%d', $value['Down']);
            }

        }


    }

