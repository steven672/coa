<?php

    /**
     * @group App
     * @group aar
     * @group Model
     * @group Metric
     * @group legacy
     */

    class Test_Metric_Legacy extends Test_Metric_Base
    {
        protected function getClassName()
        {
            return 'Metric_Legacy';
        }

        public function test_trending()
        {
             $metric = $this->provideMetric();
             $data = $metric->trending('cs', '2017-02-15', '2017-02-17', 'Corliss');

             $this->assertArrayHasKey('total_nodes',           $data['Corliss']['2017-02-15'][0]);
             $this->assertArrayHasKey('cs',              $data['Corliss']['2017-02-15'][0]);
        }

    }
