<?php
/**
 * PHPUnit
 *
 * Copyright (c) 2001-2014, Sebastian Bergmann <sebastian@phpunit.de>.
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
 * @package    PHPUnit
 * @subpackage Framework_Constraint
 * @author     Sebastian Bergmann <sebastian@phpunit.de>
 * @author     Bernhard Schussek <bschussek@2bepublished.at>
 * @copyright  2001-2014 Sebastian Bergmann <sebastian@phpunit.de>
 * @license    http://www.opensource.org/licenses/BSD-3-Clause  The BSD 3-Clause License
 * @link       http://www.phpunit.de/
 * @since      File available since Release 3.0.0
 */

/**
 * Logical XOR.
 *
 * @package    PHPUnit
 * @subpackage Framework_Constraint
 * @author     Sebastian Bergmann <sebastian@phpunit.de>
 * @author     Bernhard Schussek <bschussek@2bepublished.at>
 * @copyright  2001-2014 Sebastian Bergmann <sebastian@phpunit.de>
 * @license    http://www.opensource.org/licenses/BSD-3-Clause  The BSD 3-Clause License
 * @link       http://www.phpunit.de/
 * @since      Class available since Release 3.0.0
 */
class PHPUnit_Framework_Constraint_Xor extends PHPUnit_Framework_Constraint
{
    /**
     * @var PHPUnit_Framework_Constraint[]
     */
    protected $constraints = array();

    /**
     * @param PHPUnit_Framework_Constraint[] $constraints
     */
    public function setConstraints(array $constraints)
    {
        $this->constraints = array();

        foreach ($constraints as $key => $constraint) {
            if (!($constraint instanceof PHPUnit_Framework_Constraint)) {
                $constraint = new PHPUnit_Framework_Constraint_IsEqual(
                  $constraint
                );
            }

            $this->constraints[] = $constraint;
        }
    }

    /**
     * Evaluates the constraint for parameter $other
     *
     * If $returnResult is set to FALSE (the default), an exception is thrown
     * in case of a failure. NULL is returned otherwise.
     *
     * If $returnResult is TRUE, the result of the evaluation is returned as
     * a boolean value instead: TRUE in case of success, FALSE in case of a
     * failure.
     *
     * @param  mixed $other Value or object to evaluate.
     * @param  string $description Additional information about the test
     * @param  bool $returnResult Whether to return a result or throw an exception
     * @return mixed
     * @throws PHPUnit_Framework_ExpectationFailedException
     */
    public function evaluate($other, $description = '', $returnResult = FALSE)
    {
        $success = TRUE;
        $lastResult = NULL;
        $constraint = NULL;

        foreach ($this->constraints as $constraint) {
            $result = $constraint->evaluate($other, $description, TRUE);

            if ($result === $lastResult) {
                $success = FALSE;
                break;
            }

            $lastResult = $result;
        }

        if ($returnResult) {
            return $success;
        }

        if (!$success) {
            $this->fail($other, $description);
        }
    }

    /**
     * Returns a string representation of the constraint.
     *
     * @return string
     */
    public function toString()
    {
        $text = '';

        foreach ($this->constraints as $key => $constraint) {
            if ($key > 0) {
                $text .= ' xor ';
            }

            $text .= $constraint->toString();
        }

        return $text;
    }

    /**
     * Counts the number of constraint elements.
     *
     * @return integer
     * @since  Method available since Release 3.4.0
     */
    #[ReturnTypeWillChange]
    public function count()
    {
        $count = 0;

        foreach ($this->constraints as $constraint) {
            $count += count($constraint);
        }

        return $count;
    }
}
