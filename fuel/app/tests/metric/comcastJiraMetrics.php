<?php

    /**
     * @group App
     * @group cLinear
     * @group Model
     * @group Metric
     * @group ComcastJiraMetrics
     */

    class Test_Metric_ComcastJiraMetrics extends Test_Metric_Base
    {
        protected function getClassName()
        {
            return 'Metric_ComcastJiraMetrics';
        }


        public function test_comcastComponents()
        {
            $metric     = $this->provideMetric();
            $raw        = $metric->comcastComponents('%', '2017-02-08', '2017-02-09');

            $dataDays = $raw['Days7']['2017-02-09'];
            $dataHours = $raw['Hours24']['2017-02-09'];

            $this->assertMinValue(array_keys($raw['Hours24']), '2017-02-08');
            $this->assertMaxValue(array_keys($raw['Hours24']), '2017-02-09');

            // Is every 'total' value an unsigned integer value, for example 123456.
            // Do all records have the correct keys?
            foreach ($dataDays as $key => $value)
            {
                $this->assertStringMatchesFormat('%d',       $value['total']);
                $this->assertArrayHasKey('s1_mttr',                   $value);
                $this->assertArrayHasKey('s2_mttr',                   $value);
                $this->assertArrayHasKey('s3_mttr',                   $value);
                $this->assertArrayHasKey('s4_mttr',                   $value);
                $this->assertArrayHasKey('component',                 $value);
                $this->assertArrayHasKey('total',                     $value);
                $this->assertArrayHasKey('vendor',                    $value);
            }

            // Is every 'total' value an unsigned integer value, for example 123456.
            // Do all records have the correct keys?
            foreach ($dataHours as $key => $value)
            {
                $this->assertStringMatchesFormat('%d',       $value['total']);
                $this->assertArrayHasKey('s1_mttr',                   $value);
                $this->assertArrayHasKey('s2_mttr',                   $value);
                $this->assertArrayHasKey('s3_mttr',                   $value);
                $this->assertArrayHasKey('s4_mttr',                   $value);
                $this->assertArrayHasKey('component',                 $value);
                $this->assertArrayHasKey('total',                     $value);
                $this->assertArrayHasKey('vendor',                    $value);
            }

        }


    }

