<?php
    /**
     * @group App
     * @group t6
     * @group Controller
     * @group AppController
     * @group legacy
     * @group AppControllerrecorder
     */

    class Test_Controller_API_cDVR_Legacy extends Test_Controller_API
    {
        protected function getControllerClass()
        {
            return 'Controller_API_cDVR_Legacy';
        }

        public function test_get_trending()
        {
            $controller = $this->provideController();
            $response = $controller->get_trending();
            $data = $controller->getResponseData();

            // Test array has keys
            $this->assertResponseHasKeys($controller, array('data','component', 'dateStart', 'dateEnd', 'regions'));
              // Test default, wildcard check
            $this->assertEquals($data['component'], '%');
              // Test default, wildcard check
            $this->assertEquals($data['region'], '%');
        }

        public function test_get_health()
        {
            $controller = $this->provideController();
            $response = $controller->get_health();
            $data = $controller->getResponseData();

            // Test array has keys
            $this->assertResponseHasKeys($controller, array('region', 'data', 'date'));
            // Test nested data structure
            $this->assertArrayHasKey('regions',      $data['data']);
            $this->assertArrayHasKey('data',      $data['data']);
            $this->assertArrayHasKey('pieChartOneDigit',      $data['data']);
            // Test default, wildcard check
            $this->assertEquals($data['region'], '%');

        }

        public function test_get_minmax()
        {
            $controller = $this->provideController();
            $response   = $controller->get_minmax();
            $data       = $controller->getResponseData();

            // Test array has keys
            $this->assertResponseHasKeys($controller, array('data', 'dateStart', 'dateEnd', 'region'));
            // Test default, wildcard check
            $this->assertEquals($data['region'], '%');
        }

        public function test_get_priority()
        {
            $controller = $this->provideController();
            $response   = $controller->get_priority();
            $data       = $controller->getResponseData();

            // Test array has keys
            $this->assertResponseHasKeys($controller, array('data', 'dateStart', 'dateEnd', 'region'));
            // Test default, wildcard check
            $this->assertEquals($data['region'], '%');

        }

    }
