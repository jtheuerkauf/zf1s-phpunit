<?php
class DoubleTestCase implements PHPUnit_Framework_Test
{
    protected $testCase;

    public function __construct(PHPUnit_Framework_TestCase $testCase)
    {
        $this->testCase = $testCase;
    }

    #[ReturnTypeWillChange]
    public function count()
    {
        return 2;
    }

    public function run(PHPUnit_Framework_TestResult $result = NULL)
    {
        $result->startTest($this);

        $this->testCase->runBare();
        $this->testCase->runBare();

        $result->endTest($this, 0);
    }
}
