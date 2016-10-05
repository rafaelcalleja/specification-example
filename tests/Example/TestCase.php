<?php

/*
 * This file is part of the example specification package.
 *
 * (c) Rafael Calleja <rafaelcalleja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Example\Tests;

abstract class TestCase extends \PHPUnit_Framework_TestCase
{
    protected function getMockParam($params, $decode = false)
    {
        $mock =  $this->getMockBuilder('Example\Request\Param')
            ->disableOriginalConstructor()
            ->setMethods(array('jsonSerialize', 'count', 'params'))
            ->getMock()
        ;

        if ($decode) {
            $mock->expects($this->once())
                ->method('params')
                ->will($this->returnValue($params));

            $mock->expects($this->once())
                ->method('count')
                ->will($this->returnValue(count($params)));

            $mock->expects($this->once())
                ->method('jsonSerialize')
                ->will($this->returnValue($params));
        }

        return $mock;
    }

    protected function getSimpleMock($class, $param)
    {
        $mock =  $this->getMockBuilder($class)
            ->disableOriginalConstructor()
            ->setMethods(array('jsonSerialize', 'equals'))
            ->getMock()
        ;

        $mock->expects($this->once())
            ->method('equals')
            ->will($this->returnValue(true));

        $mock->expects($this->once())
            ->method('jsonSerialize')
            ->will($this->returnValue($param));

        return $mock;
    }

    protected function getMockMethod($name)
    {
        return $this->getSimpleMock('Example\Request\Method', $name);
    }

    protected function getMockRequestId($id)
    {
        return $this->getSimpleMock('Example\Request\RequestId', $id);
    }

    /**
     * Call protected/private method of a class.
     *
     * @param object &$object    Instantiated object that we will run method on
     * @param string $methodName Method name to call
     * @param array  $parameters Array of parameters to pass into method
     *
     * @return mixed Method return
     */
    public function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }

    /**
     * Call protected/private method of a class.
     *
     * @param object &$object    Instantiated object that we will run method on
     * @param string $methodName Method name to call
     * @param array  $parameters Array of parameters to pass into method
     *
     * @return mixed Method return
     */
    public function getClosureMethod(&$object, $methodName)
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);

        return $method->getClosure($object);
    }
}
