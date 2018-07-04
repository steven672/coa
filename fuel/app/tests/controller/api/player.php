<?php
    /**
     * @group App
     * @group aar
     * @group Controller
     * @group AppController
     */

    class Test_Controller_API_Player extends Test_Controller_API
    {
        protected function getControllerClass()
        {
            return 'Controller_API_Player';
        }

        public function test_get_overallavailability()
        {
            $controller = $this->provideController();
            $response = $controller->get_overallavailability();
            $data = $controller->getResponseData();

            // Test array has keys
            $this->assertResponseHasKeys($controller, array('data', 'start', 'end'));
        }

        public function test_get_worststreams()
        {
            $controller = $this->provideController();
            $response = $controller->get_worststreams();
            $data = $controller->getResponseData();

            // Test array has keys
            $this->assertResponseHasKeys($controller, array('count', 'data', 'date'));
            // Test default
            $this->assertEquals($data['count'], 10);
            // Test bound
            $this->assertLessThanOrEqual($data['count'], count($data['data']));
        }

        public function test_get_trendregion()
        {
            $controller = $this->provideController();
            $response = $controller->get_trendregion();
            $data = $controller->getResponseData();

            // Test array has keys
            $this->assertResponseHasKeys($controller, array('data', 'start', 'end'));
        }

    }
