<?php

/**
 * The welcome 404 presenter.
 *
 * @package app
 * @extends Presenter
 */
class Presenter_API_Alive extends Presenter
{


    /**
     * Prepare the view data, keeping this in here helps clean up
     * the controller.
     *
     * @return void
     */
    public function view()
    {
        $this->response = 'alive';
    }


}
