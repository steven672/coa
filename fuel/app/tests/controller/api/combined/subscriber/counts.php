<?php
    /**
     * @group App
     * @group subscriber1
     * @group Controller
     * @group AppController
     * #group AppControllercs
     */

    class Test_Controller_API_Combined_Subscriber_Counts extends Test_Controller_API
    {
        protected function getControllerClass()
        {
            return 'Controller_API_Combined_Subscriber_Counts';
        }

        public function test_get_region()
        {
            $controller = $this->provideController();
            $response   = $controller->get_region();
            $data       = $controller->getResponseData();

            // Test array has keys
            $this->assertResponseHasKeys($controller, array('data', 'dateStart', 'dateEnd', 'region'));
            // Test default, wildcard check
            $this->assertEquals($data['region'], '%');
            // Test bound, start date and end date range
            $this->assertLessThanOrEqual($data['dateStart'], $data['dateEnd']);
        }


    }
