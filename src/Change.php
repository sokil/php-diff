<?php

namespace Sokil\Diff;

class Change
{
    private $oldValue;

    private $newValue;

    /**
     * @param array|string $oldValue
     * @param array|string $newValue
     */
    public function __construct($oldValue, $newValue)
    {
        // old value
        if (!is_array($oldValue)) {
            $oldValue = (string)$oldValue;
        }
        $this->oldValue = $oldValue;

        // new value
        if (!is_array($newValue)) {
            $newValue = (string)$newValue;
        }
        $this->newValue = $newValue;
    }

    /**
     * @return array|string
     */
    public function getOldValue()
    {
        return $this->oldValue;
    }

    /**
     * @return array|string
     */
    public function getNewValue()
    {
        return $this->newValue;
    }
}