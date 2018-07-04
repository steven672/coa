<?php

/**
 *
 * @package app
 */

class Metric_Watermark extends Metric_Base
{
    /**
     * Returns the used database type
     *
     * @access protected
     * @return String 'mysql'
     */

    protected function getDatabaseType()
    {
        return 'mysql';
    }

    /**
     * Returns the used database connection
     * @access protected
     * @return String 'viper_watermark'
     */

    protected function getConnection()
    {
        return 'viper_watermark';
    }

    public function cox($count, $dateStart, $dateEnd)
    {

        // Query logic
        $this->date = $this->provideDateFilter('pillar_w10_host', 'date_created');
        $select = DB::select('date_created', 'host', 'down','code', 'avail_p')->from('pillar_w10_host');
        $select     = $this->date->filterByDateRange($select,$dateStart,$dateEnd );
        $select->order_by('date_created', 'ASC');
        $select->order_by('down', 'DESC');
        $data = $this->runQuery($select);
        return $this->createArrayBucketsByField($data, 'date_created');


    }

}
