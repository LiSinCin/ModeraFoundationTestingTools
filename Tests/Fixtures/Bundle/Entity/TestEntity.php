<?php

namespace LiSinCin\ModeraFoundationTestingTools\Tests\Fixtures\Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @author    Alex Plaksin <alex.plaksin@modera.net>
 * @copyright 2015 Modera Foundation
 *
 * @ORM\Entity
 * @ORM\Table()
 */
class TestEntity
{
    /**
     * @ORM\Column(type='string' )
     *
     * @var string
     */
    private $propertyOne;

    /**
     * @ORM\Column(type='string' )
     *
     * @var string
     */
    protected $propertyWithOutSetter;

    /**
     * @ORM\Column(type='string' )
     *
     * @var string
     */
    public $propertythree;

    /**
     * @ORM\JoinColumn(name="will_not_use_id" )
     *
     * @var string
     */
    private $relationProperty;

    /**
     * @ORM\Column(type='json_array' )
     *
     * @var array
     */
    private $ignoredProperty;

    /***
     * @var string
     */
    private $justProperty;

    public function setPropertyOne($string)
    {
        $this->propertyOne = $string;
    }

    public function getPropertyOne()
    {
        return $this->propertyOne;
    }

    public function getPropertyWithOutSetter()
    {
        return $this->propertyWithOutSetter;
    }

    public function setJustProperty($justProperty)
    {
        $this->justProperty = $justProperty;
    }

    public function getJustProperty()
    {
        return $this->justProperty;
    }

    public function setPropertythree($propertythree)
    {
        $this->propertythree = $propertythree;
    }

    public function getPropertythree()
    {
        return $this->propertythree;
    }

    /**
     * @return array
     */
    public function getIgnoredProperty()
    {
        return $this->ignoredProperty;
    }

    /**
     * @param array $ignoredProperty
     */
    public function setIgnoredProperty(array $ignoredProperty)
    {
        $this->ignoredProperty = $ignoredProperty;
    }


}
