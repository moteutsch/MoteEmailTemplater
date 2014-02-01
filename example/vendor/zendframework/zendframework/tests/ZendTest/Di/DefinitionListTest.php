<?php
/**
* Zend Framework (http://framework.zend.com/)
*
* @link http://github.com/zendframework/zf2 for the canonical source repository
* @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
* @license http://framework.zend.com/license/new-bsd New BSD License
* @package Zend_Di
*/

namespace ZendTest\Di;

use Zend\Di\DefinitionList;
use Zend\Di\Definition\ClassDefinition;

use PHPUnit_Framework_TestCase as TestCase;

class DefinitionListTest extends TestCase
{
    public function testGetClassSupertypes()
    {
        $definitionClassA = new ClassDefinition("A");
        $superTypesA = array("superA");
        $definitionClassA->setSupertypes($superTypesA);

        $definitionClassB = new ClassDefinition("B");
        $definitionClassB->setSupertypes(array("superB"));

        $definitionList = new DefinitionList(array($definitionClassA, $definitionClassB));

        $this->assertEquals($superTypesA, $definitionList->getClassSupertypes("A"));

    }
}
