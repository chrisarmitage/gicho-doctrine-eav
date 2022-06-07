<?php

namespace Core;

class DeviceAttribute
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $value;

    private $device;

    private $type;

    public function __construct(string $value, AttributeType $type)
    {
        $this->value = $value;
        $this->type = $type;
    }

    public function setDevice(Device $device)
    {
        $this->device = $device;

        return $this;
    }

    /**
     * @return int
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function value()
    {
        return $this->value;
    }

    public function device(): Device
    {
        return $this->device;
    }

    public function type(): AttributeType
    {
        return $this->type;
    }
}
