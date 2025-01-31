<?php
/**
 * PHPUnit
 *
 * Copyright (c) 2010-2013, Sebastian Bergmann <sb@sebastian-bergmann.de>.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *   * Neither the name of Sebastian Bergmann nor the names of his
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @package    PHPUnit_MockObject
 * @author     Sebastian Bergmann <sb@sebastian-bergmann.de>
 * @copyright  2010-2013 Sebastian Bergmann <sb@sebastian-bergmann.de>
 * @license    http://www.opensource.org/licenses/BSD-3-Clause  The BSD 3-Clause License
 * @link       http://github.com/sebastianbergmann/phpunit-mock-objects
 * @since      File available since Release 1.0.0
 */

/**
 * Invocation matcher which checks if a method has been invoked a certain amount
 * of times.
 * If the number of invocations exceeds the value it will immediately throw an
 * exception,
 * If the number is less it will later be checked in verify() and also throw an
 * exception.
 *
 * @package    PHPUnit_MockObject
 * @author     Sebastian Bergmann <sb@sebastian-bergmann.de>
 * @copyright  2010-2013 Sebastian Bergmann <sb@sebastian-bergmann.de>
 * @license    http://www.opensource.org/licenses/BSD-3-Clause  The BSD 3-Clause License
 * @version    Release: @package_version@
 * @link       http://github.com/sebastianbergmann/phpunit-mock-objects
 * @since      Class available since Release 1.0.0
 */
class PHPUnit_Framework_MockObject_Matcher_InvokedCount extends PHPUnit_Framework_MockObject_Matcher_InvokedRecorder
{
    /**
     * @var integer
     */
    protected $expectedCount;

    /**
     * @param interger $expectedCount
     */
    public function __construct($expectedCount)
    {
        $this->expectedCount = $expectedCount;
    }

    /**
     * @return string
     */
    public function toString()
    {
        return 'invoked ' . $this->expectedCount . ' time(s)';
    }

    /**
     * @param  PHPUnit_Framework_MockObject_Invocation $invocation
     * @throws PHPUnit_Framework_ExpectationFailedException
     */
    public function invoked(PHPUnit_Framework_MockObject_Invocation $invocation)
    {
        parent::invoked($invocation);

        $count = $this->getInvocationCount();

        if ($count > $this->expectedCount) {
            $message = $invocation->toString() . ' InvokedCount.php';

            switch ($this->expectedCount) {
                case 0: {
                    $message .= 'was not expected to be called.';
                }
                break;

                case 1: {
                    $message .= 'was not expected to be called more than once.';
                }
                break;

                default: {
                    $message .= sprintf(
                      'was not expected to be called more than %d times.',

                      $this->expectedCount
                    );
                }
            }

            throw new PHPUnit_Framework_ExpectationFailedException($message);
        }
    }

    /**
     * Verifies that the current expectation is valid. If everything is OK the
     * code should just return, if not it must throw an exception.
     *
     * @throws PHPUnit_Framework_ExpectationFailedException
     */
    public function verify()
    {
        $count = $this->getInvocationCount();

        if ($count !== $this->expectedCount) {
            throw new PHPUnit_Framework_ExpectationFailedException(
              sprintf(
                'Method was expected to be called %d times, ' .
                'actually called %d times.',

                $this->expectedCount,
                $count
              )
            );
        }
    }
}
