<?php
/**
 * The API Market-Incidents presenter.
 *
 * @package app
 * @extends Presenter_API
 */
// The Presenter_API class includes Model\Validator already
// use \Model\Validator;
class Presenter_API_cLinear_Incidents_Markets_Comcast extends Presenter_API_cLinear_Template
{


    /**
     * Prepare the view data, keeping this in here helps clean up
     * the controller.
     *
     * @return void
     */
    public function view()
    {
        // Ingest normalized application parameters from the URL
        $dateStart = $this->ingestParameter('start');
        $dateEnd   = $this->ingestParameter('end');
        $market    = $this->ingestParameter('market');

        // Query the database using the info needed for this API
        $responseIncidentsDay = $this->selectDataByDateRangeAndMarket(
            'jira_metrics',                     // DB Connection Label (from app config)
            't6m',                              // DB Table Name (MySQL)
            'date_created',                     // DB Field Name for dates
            $dateStart,                         // The actual start date ingested above
            $dateEnd,                           // The actual end date ingested above
            'market',                           // DB Field Name for locations ('site' : CS,DDN,Recorders; 'region' : Rio, 'market': ABRN-VA: Ashburn; Beltway& DC (BaD))
            $market                             // The actual market ingested above
        );

        // Query the database using the info needed for this API
        $responseIncidentsWeek = $this->selectDataByDateRangeAndMarket(
            'jira_metrics',                     // DB Connection Label (from app config)
            't6m_weekly',                              // DB Table Name (MySQL)
            'date_created',                     // DB Field Name for dates
            $dateStart,                         // The actual start date ingested above
            $dateEnd,                           // The actual end date ingested above
            'component',                           // DB Field Name for locations ('site' : CS,DDN,Recorders; 'region' : Rio, 'market': ABRN-VA: Ashburn; Beltway& DC (BaD))
            $market                             // The actual market ingested above
        );

        // Add to the response array (data is raw data)
        $this->response = array('data' => NULL);

        // Write the response data for consumption by the client
        $this->response['data'] = array(
                                   'Hours24' => $this->createArrayBucketsByField($responseIncidentsDay['data'], 'date_created'),
                                   'Days7'   => $this->createArrayBucketsByField($responseIncidentsWeek['data'], 'date_created'),
                                  );
    }


}
