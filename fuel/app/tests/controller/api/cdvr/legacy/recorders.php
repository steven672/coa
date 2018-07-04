<?php
    /**
     * @group App
     * @group legacyrecorder
     * @group Controller
     * @group AppController
     * @group AppControllerrecorders
     */

    class Test_Controller_API_cDVR_Legacy_Recorders extends Test_Controller_API
    {
        protected function getControllerClass()
        {
            return 'Controller_API_cDVR_Legacy_Recorders';
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

         public function test_get_trend()
        {
            $controller = $this->provideController();
            $response   = $controller->get_trend();
            $data       = $controller->getResponseData();
print_r(array_keys($data['data']));
            // Test array has keys
            $this->assertResponseHasKeys($controller, array('data', 'dateStart', 'dateEnd', 'region'));
            // Test default, wildcard check
            $this->assertEquals($data['regions'], '%');

        }

    }
