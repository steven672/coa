<?php
    /**
     * @group App
     * @group aar
     * @group Controller
     * @group AppController
       @group recorder
     * @group AppControllerrecorder
     */

    class Test_Controller_API_cDVR_Legacy_Recorder extends Test_Controller_API
    {
        protected function getControllerClass()
        {
            return 'Controller_API_cDVR_Legacy_Recorder';
        }

        public function test_get_sites()
        {
            $controller = $this->provideController();
            $response = $controller->get_sites();
            $data = $controller->getResponseData();

            // Test array has keys
            $this->assertResponseHasKeys($controller, array('data', 'regions'));
        }

         public function test_get_throughput()
        {
            $controller = $this->provideController();
            $response = $controller->get_throughput();
            $data = $controller->getResponseData();

            // Test array has keys
            $this->assertResponseHasKeys($controller, array('data', 'date', 'region', 'regions'));

            // Test default, wildcard check
            $this->assertEquals($data['region'], '%');

        }

    }
