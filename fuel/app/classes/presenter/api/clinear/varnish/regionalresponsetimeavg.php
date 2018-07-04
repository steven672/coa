<?php

/**
 * The cLinear Varnish Hot API presenter.
 *
 * @package app
 * @extends Presenter_API
 */

// The Presenter_API class includes Model\Validator already
// use \Model\Validator;
class Presenter_API_cLinear_Varnish_Regionalresponsetimeavg extends Presenter_API_cLinear_Template
{

    /**
     * Prepare the view data, keeping this in here helps clean up
     * the controller.
     *
     * @return void
     */
    public function view()
    {
        /*
            * Ingest the date and number variables
            * The URL formats for these variables are specified in the /app/config/routes.php file
            * Valid URL calls=>
            *   /api/clinear/varnish/regionalresponsetimeavg         Average respose time for all regions on all dates
            *   /api/clinear/varnish/regionalresponsetimeavg/WNER/2017-05-16         Average respose time for WNER region on May 16, 2017
            *   /api/clinear/varnish/regionalresponsetimeavg/all/2017-05-16         Average respose time for all regions on May 16, 2017
         */

        // Ingest normalized application parameters from the URL
        $region = $this->ingestParameter('region');
        $dateStart = $this->ingestParameter('start');
        $dateEnd   = $this->ingestParameter('end');


        $dbConnection = 'viper_clinear_new';


        // Query to run if datestart parameter us given
        if ($dateStart !== '%' && $dateEnd == '%' && $region == '%')
        {
        $queryBuilderObject = DB::query("SELECT sub.date_created, sub.cFacility, sub.cRegion, sub.loggedTime, sub.CountTimes, sub.TotalTime, sub.TotalTime/sub.CountTimes AS new
            FROM (
                SELECT date_created, cFacility, cRegion, loggedTime, SUM(CountTimes) AS CountTimes, SUM(TotalTime) AS TotalTime
                FROM comcast_viper_clinear_new.VarnishResponseTimeRegionLevel
                GROUP BY date_created, cFacility, cRegion, loggedTime
                ) sub
                WHERE date_created = '$dateStart';");

        }

        // Query to run if dateStart and region parameters are supplied
        if ($dateStart !== '%' && $dateEnd == '%' && $region !== '%')
        {
        $queryBuilderObject = DB::query("SELECT sub.date_created, sub.cFacility, sub.cRegion, sub.loggedTime, sub.CountTimes, sub.TotalTime, sub.TotalTime/sub.CountTimes AS new
            FROM (
                SELECT date_created, cFacility, cRegion, loggedTime, SUM(CountTimes) AS CountTimes, SUM(TotalTime) AS TotalTime
                FROM comcast_viper_clinear_new.VarnishResponseTimeRegionLevel
                GROUP BY date_created, cFacility, cRegion, loggedTime
                ) sub
                WHERE date_created = '$dateStart' AND cRegion = '$region';");

        }

        // Query to run if no parameters are given
        if ($dateStart == '%' && $dateEnd == '%' && $region == '%')
        {
        $queryBuilderObject = DB::query("SELECT sub.date_created, sub.cFacility, sub.cRegion, sub.loggedTime, sub.CountTimes, sub.TotalTime, sub.TotalTime/sub.CountTimes AS new
            FROM (
                SELECT date_created, cFacility, cRegion, loggedTime, SUM(CountTimes) AS CountTimes, SUM(TotalTime) AS TotalTime
                FROM comcast_viper_clinear_new.VarnishResponseTimeRegionLevel
                GROUP BY date_created, cFacility, cRegion, loggedTime
                ) sub;");
        }

        $this->response = array();

        $this->response['data'] = $this->queryRunUsingConnection($queryBuilderObject, $dbConnection);

        $data = $this->response['data'];


    }

}
