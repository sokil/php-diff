<?php

namespace Sokil\Diff;

class Change
{
    /**
     * @var mixed
     */
    private $oldValue;

    /**
     * @var mixed
     */
    private $newValue;

    /**
     * @param mixed $oldValue
     * @param mixed $newValue
     */
    public function __construct($oldValue, $newValue)
    {
        $this->oldValue = $oldValue;
        $this->newValue = $newValue;
    }

    /**
     * @return mixed
     */
    public function getOldValue()
    {
        return $this->oldValue;
    }

    /**
     * @return mixed
     */
    public function getNewValue()
    {
        return $this->newValue;
    }
}
