<?php

namespace Core;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Device
{
    /**
     * @var DeviceIdentifier
     */
    private DeviceIdentifier $identifier;

    /**
     * @var string
     */
    private $name;

    private $attributes;

    public function __construct(DeviceIdentifier $deviceIdentifier)
    {
        $this->identifier = $deviceIdentifier;
        $this->attributes = new ArrayCollection();
    }

    /**
     * @return DeviceIdentifier
     */
    public function id(): DeviceIdentifier
    {
        return $this->identifier;
    }

    /**
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Device
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function attributes()
    {
        return $this->attributes;
    }

    /**
     * @param DeviceAttribute $attribute
     * @return Device
     */
    public function setAttribute(DeviceAttribute $attribute)
    {
        $attribute->setDevice($this);
        $this->attributes->remove($attribute->type()->getId());
        $this->attributes->set($attribute->type()->getId(), $attribute);

        return $this;
    }
}
