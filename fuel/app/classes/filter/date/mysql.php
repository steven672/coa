<?php
/**
 *
 * @package app
 */
class Filter_Date_Mysql extends Filter_Date implements Filter_Date_Interface
{
    /** @var String Table name to be date filtered */
    protected $table;
    /** @var String Column name containing dates*/
    protected $column;

    public function __construct($table = '', $column = '')
    {
        $this->table = $table;
        $this->column = $column;
    }

    public function filterByDate($select, $date)
    {
        return $this->decorateDateRangeQuery($select, $date);
    }

    public function selectByDate($date)
    {
        $select = $this->provideSelect();
        return $this->filterByDate($select, $date);
    }

    public function filterByDateRange($select, $date_start, $date_end)
    {
        return $this->decorateDateRangeQuery($select, $date_start, $date_end);
    }

    public function selectByDateRange($date_start, $date_end)
    {
        $select = $this->provideSelect();
        return $this->filterByDateRange($select, $date_start, $date_end);
    }


    public function getTable()
    {
        return $this->table;
    }

    public function getColumn()
    {
        return $this->column;
    }

    protected function decorateDateRangeQuery($query, $date_one, $date_two = null)
    {
        // Check whether date is valid (wildcard or YYYY-MM-DD format)
        if ($this->isValidDate($date_one))
        {
            // Build the date search for the query (either a single date or a date range)
            if (is_null($date_two) || $date_two === '%')
            {
                // Query for a single date using MySQL native dates
                $query->where(DB::expr('DATE(' . $this->column . ')'), '=', DB::expr("DATE('$date_one')"));
            }
            else
            {
                // Query for a date range, inclusive, using MySQL native dates
                $query->where(DB::expr('DATE(' . $this->column . ')'), '>=', DB::expr("DATE('$date_one')"));
                $query->where(DB::expr('DATE(' . $this->column . ')'), '<=', DB::expr("DATE('$date_two')"));
            }
        }
        // Return the updated query builder object
        return $query;
    }

    protected function provideSelect()
    {
        return DB::select()->from($this->table);
    }

    protected function processWildcard($query, $value)
    {
        return '%';
    }
}
