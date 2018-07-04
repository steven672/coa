<?php

interface Filter_Date_Interface
{
    public function isValidDate($date);

    public function filterByDate($select, $date);

    public function selectByDate($date);

    public function filterByDateRange($select, $date_start, $date_end);

    public function selectByDateRange($date_start, $date_end);
}
