<?php
    /**
     * @group App
     * @group failures
     * @group Controller
     * @group AppController
     * #group AppControllercs
     */

    class Test_Controller_API_cDVR_Performance_Rio_Failures extends Test_Controller_API
    {
        protected function getControllerClass()
        {
            return 'Controller_API_cDVR_Performance_Rio_Failures';
        }


        public function test_get_worst5streamswith5market()
        {
            $controller = $this->provideController();
            $response   = $controller->get_worst5streamswith5market();
            $data       = $controller->getResponseData();

            // Test array has keys
            $this->assertResponseHasKeys($controller, array('data', 'dateStart', 'dateEnd', 'region'));
            // Test default, wildcard check
            $this->assertEquals($data['region'], '%');

        }

    }
