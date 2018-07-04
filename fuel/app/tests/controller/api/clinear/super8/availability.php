<?php
    /**
     * @group App
     * @group clinear
     * @group Controller
     * @group AppController
     * @group AppControllersuper8
     */

class Test_Controller_API_cLinear_Super8_Availability extends Test_Controller_API
{
        protected function getControllerClass()
        {
            return 'Controller_API_cLinear_Super8_Availability';
        }

        public function test_get_comcast()
        {
            $controller = $this->provideController();
            $response   = $controller->get_comcast();
            $data       = $controller->getResponseData();
            // Test array has keys
            $this->assertResponseHasKeys($controller, array('data', 'data', 'dataFacility','dataCregion', 'histogramData1'));
        }
}
