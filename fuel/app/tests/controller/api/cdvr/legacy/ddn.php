<?php
    /**
     * @group App
     * @group legacyddn
     * @group Controller
     * @group AppController
     * #group AppControllerddn
     */

    class Test_Controller_API_cDVR_Legacy_DDN extends Test_Controller_API
    {
        protected function getControllerClass()
        {
            return 'Controller_API_cDVR_Legacy_DDN';
        }

        public function test_get_sites()
        {
            $controller = $this->provideController();
            $response   = $controller->get_sites();
            $data       = $controller->getResponseData();

            // Test array has keys
            $this->assertResponseHasKeys($controller, array('data', 'dateStart', 'dateEnd', 'region'));
            // Test default, wildcard check
            $this->assertEquals($data['region'], '%');
            // Test bound, start date and end date range
            $this->assertLessThanOrEqual($data['dateStart'], $data['dateEnd']);
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

            // Test array has keys
            $this->assertResponseHasKeys($controller, array('data', 'dateStart', 'dateEnd', 'region'));
            // Test default, wildcard check
            $this->assertEquals($data['regions'], '%');

        }

    }
