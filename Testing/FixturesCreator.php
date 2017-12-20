<?php

namespace LiSinCin\ModeraFoundationTestingTools\Testing;
use Doctrine\Common\Annotations\DocParser;
use Doctrine\Common\Util\Debug;
use Symfony\Component\Debug\Exception\ContextErrorException;

/**
 * Create fixture with all non relations field filled.
 *
 * @author    Alex Plaksin <alex.plaksin@modera.net>
 * @copyright 2015 Modera Foundation
 */
class FixturesCreator
{
    /**
     * Create Class instance from given FQDN entity name.
     *
     * 1. Check if class is ORM\Entity
     * 2. Get non relation fields list if setter exists
     * 3. Fill them
     *
     * @param string $className
     *
     * @throws \InvalidArgumentException
     *
     * @return mixed
     */
    public static function createFixture($className, $index = 1, $excludedFields = ['id'])
    {
        if (!class_exists($className)) {
            throw new \InvalidArgumentException(sprintf('No such(%) class name ', $className));
        }

        $reflectionClass = new \ReflectionClass($className);
        $docComment = $reflectionClass->getDocComment();

        /*
         * if class docComment has
         * @ORM\Entity and @ORM\Table doc blocks all is ok
         */
        if (!preg_match('/@ORM\\\Entity/i', $docComment) || !preg_match('/@ORM\\\Table\(/i', $docComment)) {
            throw new \InvalidArgumentException(sprintf('Given class(%s) is not Doctrine Entity ', $className));
        }

        /* @var string[] */;
        $propertyNames = [];

        $resultClass = new $className();

        $reader = new \Doctrine\Common\Annotations\AnnotationReader();
        /*
         * Grabbing all class properties that have @ORM\Column in docComment
         */
        foreach ($reflectionClass->getProperties() as $property) {

            $columnParsed = $reader->getPropertyAnnotation($property, 'Doctrine\ORM\Mapping\Column');

            if ($columnParsed instanceof \Doctrine\ORM\Mapping\Column) {
                /** @var \Doctrine\ORM\Mapping\Column $columnParsed */
                switch ($columnParsed->type) {
                    case 'string':
                        $propertyNames[] = array('type' => $columnParsed->type, 'name' => $property->getName(), 'value' => (string) $property->getName(). $index);
                        break;
                    case 'float':
                        $propertyNames[] = array('type' => $columnParsed->type, 'name' => $property->getName(), 'value' => (float) $index);
                        break;
                    case 'integer':
                    case 'int':
                        $propertyNames[] = array('type' => $columnParsed->type, 'name' => $property->getName(), 'value' => (int) $index);
                        break;
                    case 'boolean':
                    case 'bool':
                        $propertyNames[] = array('type' => $columnParsed->type, 'name' => $property->getName(), 'value' => (boolean) $index);
                        break;
                }
            }
        }

        foreach ($propertyNames as $propertyName) {

            //skip excluded field set
            if (array_search($propertyName['name'], $excludedFields) !== FALSE ) continue;

            try {
                $resultClass->{static::getSetterName($propertyName['name'])}( $propertyName['value'] );
            } catch (\Exception $e) {}
        }

        return $resultClass;
    }

    protected static function getSetterName($propertyName)
    {
        return 'set'.ucfirst($propertyName);
    }
}
