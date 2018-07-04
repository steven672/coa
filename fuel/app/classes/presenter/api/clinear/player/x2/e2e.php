<?php

/**
 * The cLinear Combined Average Availability API presenter.
 *
 * @package app
 * @extends Presenter_API
 */

// The Presenter_API class includes Model\Validator already
// use \Model\Validator;
class Presenter_API_cLinear_player_x2_e2e extends Presenter_API_cLinear_Template
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
            * Ingest the date and region variables
            * The URL formats for these variables are specified in the /app/config/routes.php file
            * For this API endpoint, both date and region are optional variables
            * Valid URL calls:
            *   /api/clinear/combined/availability/average/2017-01-01/2017-01-10         From January 1, 2017 to January 10, 2017 in all duplicate tickets (YYYY-MM-DD)
         */

        // Ingest normalized application parameters from the URL
        $dateStart = $this->ingestParameter('start');
        $dateEnd   = $this->ingestParameter('end');

        // Query the database using the info needed for this API
        $responseAverageAvailibility = $this->selectDataFore2e(
            'e2eanalysis',                // DB Connection Label (from app config)
            $dateStart,                         // The actual start date ingested above
            $dateEnd                            // The actual end date ingested above
        );

        // Optionally, extend maximum execution time (default is 30 seconds) or memory limit - could be useful if we write or test more complex queries in the future - db is 19M+ rows (with 700k being added per day)
        ini_set('max_execution_time', 0); //300 seconds = 5 minutes

        // Add to the response array (data is raw data)
        $this->response = array('data' => NULL);
        // debug
        // echo DB::last_query('e2eanalysis');
        // Build response array, bucketize by date
        $this->response['data'] = $this->createArrayBucketsByField($responseAverageAvailibility['data'], 'date');
    }


    // Query the database for the average availability data for the date/range specified
    protected function selectDataFore2e(
        $dbConnection = NULL,
        // Required: The database connection object to use (maps to objects specified in /fuel/app/config/{development|production|test}/db.php)
        $dateProvidedStart = NULL,
        // Required: The date to search for (may be a wildcard '%') or the start date if specifying a range; cannot be null
        $dateProvidedEnd = NULL             // Opt: The end date if a date range is provided
    )
    {
        $query = DB::query(
            "
                SELECT
                    m.time,
                    p.date,
                    p.Pfail,
                    P.total,
                    p.Pavailability,
                    s.S8fail,
                    s.S8total,
                    s.S8availability,
                    v.Vfail,
                    v.Vtotal,
                    v.Vavailability,
                    m.failed,
                    m.succeeded,
                    m.availability
                FROM
                    (SELECT
                        DATE(TIMESTAMP(SUBSTRING_INDEX(_time, '.', 1))) AS date,
                            _time,
                            TIMESTAMP(SUBSTRING_INDEX(_time, '.', 1)) AS time1,
                            SUM(ErrorCount) AS Pfail,
                            SUM(TotalCount) AS Ptotal,
                            (1 - SUM(ErrorCount) / SUM(TotalCount)) * 100 AS Pavailability
                    FROM
                        e2eanalysis.T6pillar10streams
                    WHERE
                        DATE(TIMESTAMP(SUBSTRING_INDEX(_time, '.', 1))) = '$dateProvidedStart'
                    GROUP BY _time) p
                        LEFT JOIN
                    (SELECT
                        DATE(TIMESTAMP(SUBSTRING_INDEX(_time, '.', 1))) AS date,
                            _time,
                            TIMESTAMP(SUBSTRING_INDEX(_time, '.', 1)) AS time1,
                            SUM(SuccessCount) AS S8fail,
                            SUM(Total) AS S8total,
                            (1 - SUM(SuccessCount) / SUM(Total)) * 100 AS S8availability
                    FROM
                        e2eanalysis.super810streams
                    GROUP BY _time) s ON (p._time = s._time)
                        LEFT JOIN
                    (SELECT
                        DATE(TIMESTAMP(SUBSTRING_INDEX(_time, '.', 1))) AS date,
                            _time,
                            TIMESTAMP(SUBSTRING_INDEX(_time, '.', 1)) AS time1,
                            SUM(Count) AS Vfail,
                            SUM(Total) AS Vtotal,
                            (1 - SUM(Count) / SUM(Total)) * 100 AS Vavailability
                    FROM
                        e2eanalysis.varnish10streams
                    GROUP BY _time) v ON (p._time = s._time AND s._time = v._time)
                        LEFT JOIN
                    e2eanalysis.player10streams m ON (p._time = s._time AND s._time = v._time
                        AND v.time1 = m.time)


            "
       );


        // Execute the query builder object and return the result set
        return array('data' => $this->queryRunUsingConnection($query, $dbConnection));
    }


}
