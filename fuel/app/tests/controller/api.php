<?php
    /**
     * @group App
     * @group aar
     * @group Controller
     * @group AppController
     */

    class Test_Controller_API extends TestCase
    {
        protected function getControllerClass()
        {
            return 'Controller_API';
        }

        protected function mockRequest($uri = '', $method = 'GET')
        {
            return Request::forge($uri, false, $method);
        }

        protected function provideController($uri = '', $method = '')
        {
            $request = $this->mockRequest($uri, $method);
            $class = $this->getControllerClass();
            $controller = new $class($request);
            $controller->before();
            return $controller;
        }

        protected function getResponse($controller)
        {
            return $controller->getResponseData();
        }

        protected function assertResponseHasKeys($controller, $keys)
        {
            $response = $controller->getResponseData();
            foreach ($keys as $key) {
                $this->assertArrayHasKey($key, $response);
            }
        }

        public function test_action_alive()
        {
            $controller = $this->provideController();
            $response = $controller->action_alive();
            $data = $controller->getResponseData();
            $this->assertEquals($data, 'alive');
            $this->assertEquals($data, $response->body->get('response'));
        }

        public function test_action_404()
        {
            $controller = $this->provideController();
            $response = $controller->action_404();
            $data = $controller->getResponseData();
            $this->assertNull($data);
            $this->assertEquals($response->status, 404);
        }
    }
