<?php
/**
 *
 * @package app
 */
abstract class Filter_Date
{
    public function isValidDate($date)
    {
        if ($date instanceof DateTime) {
            return true;
        }
        if (!is_string($date) && !is_int($date)) {
            return false;
        }
        if ($this->isWildCard($date)) {
            return true;
        }
        $dtest = DateTime::createFromFormat($this->getFormatString(), $date);
        return $dtest && $this->formatDate($dtest) === $date;
    }

    public function convertDateToTimestamp($dateProvided = null)
    {
        return (new DateTime($dateProvided, new DateTimeZone('UTC')))->format('U');
    }

    abstract public function filterByDate($select, $date);

    abstract public function selectByDate($date);

    abstract public function filterByDateRange($select, $date_start, $date_end);

    abstract public function selectByDateRange($date_start, $date_end);

    public function formatDate($date)
    {
        if (! $date instanceof DateTime)
        {
            $date = new DateTime($date);
        }
        return $date->format($this->getFormatString());
    }

    protected function getFormatString()
    {
        return 'Y-m-d';
    }

    protected function getWildCard()
    {
        return '%';
    }

    abstract protected function processWildCard($query, $value);

    protected function isWildCard($value)
    {
        return $value === $this->getWildCard();
    }
}
