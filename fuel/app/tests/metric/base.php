<?php

    /**
     * @group App
     * @group aar
     * @group Model
     * @group Metric
     */

    class Test_Metric_Base extends TestCase
    {

        protected function getClassName()
        {
            return 'Metric_Headwaters';
        }

        protected function provideMetric($overrideDbConnection = false)
        {
            $className = $this->getClassName();
            if ($overrideDbConnection === false)
            {
                $metric = new $className();
            }
            else
            {
                $metric = new $className($overrideDbConnection);
            }
            return $metric;
        }

        protected function extractField($array, $field)
        {
            return array_map(function($e) use ($field) { return $e[$field]; }, $array);
        }

        protected function assertMaxValue($array, $fieldOrValue, $value = null)
        {
            if (is_null($value))
            {
                $value = $fieldOrValue;
                $values = $array;
            }
            else
            {
                $field = $fieldOrValue;
                $values = $this->extractField($array, $field);
            }
            $this->assertEquals($value, max($values));
        }

        protected function assertMinValue($array, $fieldOrValue, $value = null)
        {
            if (is_null($value))
            {
                $value = $fieldOrValue;
                $values = $array;
            }
            else
            {
                $field = $fieldOrValue;
                $values = $this->extractField($array, $field);
            }
            $this->assertEquals($value, min($values));
        }
    }
