<?php

    /**
     * @group App
     * @group cLinear
     * @group Model
     * @group Metric
     * @group ComcastViperWatermarkNew
     */

    class Test_Metric_ComcastViperWatermarkNew extends Test_Metric_Base
    {
        protected function getClassName()
        {
            return 'Metric_ComcastViperWatermarkNew';
        }


        public function test_restartsCox()
        {
            $metric     = $this->provideMetric();
            $raw        = $metric->restartsCox('%', '2017-02-08', '2017-02-09');

            $data = $raw['data'];

            foreach ($data as $regionKey => $index)
            {
                foreach ($index as $key => $value)
                {
                $this->assertArrayHasKey('date',             $value);
                $this->assertArrayHasKey('errorMinutes',     $value);
                $this->assertArrayHasKey('count',            $value);
                $this->assertStringMatchesFormat('%d',       $value['errorMinutes']);
                $this->assertStringMatchesFormat('%d',       $value['count']);
                }
            }

        }


        public function test_restartsMinutesCox()
        {
            $metric     = $this->provideMetric();
            $raw        = $metric->restartsMinutesCox('%', '2017-02-08', '2017-02-12');


                foreach ($raw as $dateKey => $index)
                {
                    foreach ($index as $key => $value)
                        {
                            print_r($value);
                            $this->assertArrayHasKey('market',           $value);
                            $this->assertArrayHasKey('restartCount',     $value);
                            $this->assertArrayHasKey('errorMinutes',     $value);
                            $this->assertStringMatchesFormat('%d',       $value['errorMinutes']);
                            $this->assertStringMatchesFormat('%d',       $value['restartCount']);
                        }
                }

        }


        public function test_coxWorst10Restarts()
        {
            $metric     = $this->provideMetric();
            $raw        = $metric->coxWorst10Restarts('10', '2017-08-08', '2017-08-12');


                foreach ($raw as $dateKey => $index)
                {
                    foreach ($index as $key => $value)
                    {
                        print_r($value);
                        $this->assertArrayHasKey('channel',           $value);
                        $this->assertArrayHasKey('host',              $value);
                        $this->assertArrayHasKey('region',            $value);
                        $this->assertArrayHasKey('restart_count',     $value);
                        $this->assertArrayHasKey('version',           $value);
                        $this->assertStringMatchesFormat('%d',        $value['restart_count']);

                    }
                }

        }



    }

