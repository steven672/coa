<?php
/**
 *
 * @package app
 */
class Metric_e2eanalysis extends Metric_Base
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
     * @return String 'headwaters'
     */
    protected function getConnection()
    {
        return 'tvx_e2eanalysis';
    }

    /**
     * Generates region trend data for player data
     *
     * @access public
     * @param  String $dateStart Y-m-d formatted date, beginning date of range
     * @param  String $dateEnd   Y-m-d formatted date, end date of range
     * @return Array  Array of daily availability grouped by date
     */

    public function comcast($dateStart, $dateEnd)
    {
        $this->dateFilter = $this->provideDateFilter('pillarPercentile', 'pillarPercentile.date_created');
        $select = DB::select(
                'pillarPercentile.date_created',
                ['pillarPercentile.p0_5', 'pillarp0_5'],
                ['pillarPercentile.p1', 'pillarp1'],
                ['pillarPercentile.p5', 'pillarp5'],
                ['varnishPercentile.p0_5', 'varnishp0_5'],
                ['varnishPercentile.p1', 'varnishp1'],
                ['varnishPercentile.p5', 'varnishp5'],
                ['super8Percentile.p0_5', 'super8_p0_5'],
                ['super8Percentile.p1', 'super8p1'],
                ['super8Percentile.p5', 'super8p5'],
                ['playerPercentile.p0_5', 'player_p0_5'],
                ['playerPercentile.p1', 'playerp1'],
                ['playerPercentile.p5', 'playerp5']
        )
        ->from('pillarPercentile')
        ->join('varnishPercentile', 'LEFT')->on('pillarPercentile.date_created', '=', 'varnishPercentile.date_created')
        ->join('super8Percentile', 'LEFT')->on('super8Percentile.date_created', '=', 'pillarPercentile.date_created')
        ->join('playerPercentile', 'LEFT')->on('pillarPercentile.date_created', '=', 'playerPercentile.date_created');
        $select = $this->dateFilter->filterByDateRange($select, $dateStart, $dateEnd);
        $select->order_by('date_created', 'DESC');
        return $this->runQuery($select);
    }

    public function regioncomcast($dateStart, $dateEnd)
    {


        $this->dateFilter = $this->provideDateFilter('e2eanalysis.pillarregionlevelpercentile', 'a.date_created');

        $select_without_cmc = DB::select(
                'a.date_created',
                'a.Facility',
                'a.Region',
                array('a.p0_5','pillar p0_5'),
                ['a.p5','pillar p5'],
                ['a.average','pillarAvgErrorFree'],
                 array('c.p0_5','varnish p0_5'),
                ['c.p0_5','varnish p5'],
                ['c.average','varnish varnishAvgErrorFree'],
                 array('b.p0_5','super8 p0_5'),
                ['b.p0_5','super8 p5'],
                ['b.average','super8 super8AvgErrorFree'],
                 array('p.p0_5','player p0_5'),
                ['p.p0_5','player p5'],
                ['p.average','player playerAvgErrorFree']
        )
        ->from(['pillarregionlevelpercentile',  'a'])
        ->join(['varnishregionlevelpercentile', 'c'],'LEFT')->on('a.date_created','=','c.date_created')
        ->and_on('a.Region','=','c.Region')->and_on('a.Facility','=','c.Facility')
        ->join(['super8regionlevelpercentile',  'b'],'LEFT')->on('a.date_created','=','b.date_created')
        ->and_on('a.Region','=','b.Region')->and_on('a.Facility','=','b.Facility')
        ->join(['playerRegionLevelPercentile',  'p'],'LEFT')->on('a.date_created','=','p.date_created')
        ->and_on('a.Region','=','p.Region')->and_on('a.Facility','=','p.Facility')
        ->where('a.Facility','!=','CMC')  ;
        $select_without_cmc = $this->dateFilter->filterByDateRange($select_without_cmc, $dateStart, $dateEnd);
        $select_without_cmc->order_by('a.average', 'ASC');

       return $this->runQuery($select_without_cmc);

         }


}

