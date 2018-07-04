<?php
    /**
     * @group App
     * @group clinear
     * @group Controller
     * @group AppController
     * @group appControllersuper8Hot
     */

class Test_Controller_API_cLinear_Super8_Hot extends Test_Controller_API
{
        protected function getControllerClass()
        {
            return 'Controller_API_cLinear_Super8_Hot';
        }

        public function test_get_comcast()
        {
            $controller = $this->provideController();
            $response   = $controller->get_comcast();
            $data       = $controller->getResponseData();

            // Test array has keys
            $this->assertResponseHasKeys($controller, array('data'));
        }
}
