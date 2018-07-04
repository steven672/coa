<?php
    /**
     * @group App
     * @group aar
     * @group Controller
     * @group AppController
     * #group AppControllerdashr
     */

    class Test_Controller_API_cDVR_Playback_dashr extends Test_Controller_API
    {
        protected function getControllerClass()
        {
            return 'Controller_API_cDVR_Playback_dashr';
        }

        public function test_get_worst10()
        {
            $controller = $this->provideController();
            $response = $controller->get_worst10();
            $data = $controller->getResponseData();

            // Test array has keys
            $this->assertResponseHasKeys($controller, array('count', 'data', 'date'));
            // Test default
            $this->assertEquals($data['count'], 10);
            // Test bound
            $this->assertLessThanOrEqual($data['count'], count($data['data']));
        }


    }
