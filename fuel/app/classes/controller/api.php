<?php
/**
 * The main API Controller.
 *
 * Responds to requests made programmatically
 *
 * @package app
 * @extends Controller
 */
class Controller_API extends Controller
{
    /** @var Filter_DateInterface Date filter object for validation and formatting */
    protected $dateFilter = null;
    /** @var Array Response data array. Initialized with key 'response', used by api/response  */
    protected $data = array('response' => null);

    /**
     * Set a response variable for the api view in $this->data['response'],
     * since the api/response view uses $data['response'], we'll use the
     * this method sets k,v in that key
     *
     * @access protected
     * @param  String $key   the key in the response
     * @param  Mixed  $value the value of the key
     * @return Void
     */
    protected function setResponse($key = null, $value = null)
    {
        if (! is_null($key) && $key !== '')
        {
            if (is_null($this->data['response']))
            {
                $this->data['response'] = array();
            }
            $this->data['response'][$key] = $value;
        }
    }

    /**
     * Forge and return a response with the data in $this->data
     *
     * @access protected
     * @param  Int    $code  response code, default 200
     * @param  String $view  the path to the view, default api/response
     * @return Response
     */
    protected function forgeResponse(
        $code = 200,
        $view = 'api/response',
        $contentType = 'application/json'
    )
    {
        $response = Response::forge(View::forge($view, $this->data), $code);
        $response->set_header('Content-Type', $contentType);
        return $response;
    }

    /**
     * The 404 action for the application.  API endpoint/query not found.
     *
     * @access public
     * @return Response
     */
    public function action_alive()
    {
        $this->data['response'] = 'alive';
        return $this->forgeResponse();
    }


    /**
     * The 404 action for the application.  API endpoint/query not found.
     *
     * @access public
     * @return Response
     */
    public function action_404()
    {
        return $this->forgeResponse(404);
    }

    /**
     * Process a value to a default value or wildcard
     *
     * @access protected
     * @param  Mixed  $paramValue          The input value
     * @param  Mixed  $defaultValue        Defaults to start date, and if given returns data for the date range
     * @param  Mixed  $wildcardValue       The wildcard value
     * @param  Mixed  $wildcardPlaceholder The placeholder which calls for replacement by the wildcard
     * @return Mixed  processed value
     */
    protected function ingestParameter(
        $paramValue = null,
        $defaultValue = '%',
        $wildcardValue = '%',
        $wildcardPlaceholder = 'all'
        )
    {
        if (is_null($paramValue))
        {
            $result = $defaultValue;
        }
        else
        {
            $result = $paramValue;
        }

        // If the parameter value is ingested as "all", convert it to the specified wildcard
        $result = ($result === $wildcardPlaceholder ? $wildcardValue : $result);

        // The param value is either the value of the parameter (if not null) or the default value (if null)
        return $result;
    }

    /**
     * Process a date to a formatted value or a default, $defaultDaysBefore the present date or wildcard
     *
     * @access protected
     * @param  Mixed  $paramValue          The input date
     * @param  Mixed  $defaultValue        The days before the present for the output if $paramValue is null or invalid date, default today
     * @param  Mixed  $wildcardValue       The wildcard value
     * @param  Mixed  $wildcardPlaceholder The placeholder which calls for replacement by the wildcard
     * @return String Y-m-d formatted date
     */
    protected function ingestDate(
        $paramValue = null,
        $defaultValue = 0,
        $wildcardValue = '%',
        $wildcardPlaceholder = 'all'
        )
    {
        if (is_null($paramValue) || !$this->dateFilter->isValidDate($paramValue))
        {
            if (is_int($defaultValue))
            {
                $dateValue = new DateTime();
                if ($defaultValue > 0)
                {
                    $dateValue->sub(new DateInterval('P'.$defaultValue.'D'));
                }
            }
            else
            {
                $dateValue = new DateTime($defaultValue);
            }
            $result = $this->dateFilter->formatDate($dateValue);
        }
        else
        {
            $result = $paramValue;
        }

        // If the parameter value is ingested as "all", convert it to the specified wildcard
        $result = ($result === $wildcardPlaceholder ? $wildcardValue : $result);
        // The param value is either the value of the parameter (if not null) or the default value (if null)
        return $result;
    }

    /**
    * 'before' hook from fuelphp. Instantiates a date filter instance for validation and formatting of dates
    */
    public function before()
    {
        parent::before();
        $this->dateFilter = new Filter_Date_Mysql();
    }

    public function debug($data = 'here')
    {
        print_r($data);
    }

    public function debugLastQuery($metric = null)
    {
        if (! is_null($metric))
        {
            $metric->debugLastQuery();
        }
    }

    public function getResponseData()
    {
        return $this->data['response'];
    }
}
