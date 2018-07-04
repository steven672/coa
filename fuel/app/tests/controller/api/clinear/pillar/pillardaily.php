<?php
    /**
     * @group App
     * @group aar
     * @group Controller
     * @group AppController
     * #group AppControllerdashr
     */

    class Test_Controller_API_cLinear_Pillar_Pillardaily extends Test_Controller_API
    {
        protected function getControllerClass()
        {
            return 'Controller_API_cLinear_Pillar_Pillardail';
        }

        public function test_get_panicscaus()
        {
            $controller = $this->provideController();
            $response = $controller->get_worst10();
            $data = $controller->getResponseData();

            // Test array has keys
            $this->assertResponseHasKeys($controller, array('data', 'start', 'end'));
        }


    }
