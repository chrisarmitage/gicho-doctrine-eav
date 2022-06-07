<?php

namespace Core;

class AttributeType
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    public function getId()
    {
        return $this->id;
    }

    public function name()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
}
