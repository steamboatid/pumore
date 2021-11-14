<?php declare(strict_types=1);
/*
 * This file is part of PHPUnit.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PHPUnit\Runner\Filter;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\TestSuite;
use PHPUnit\Runner\PhptTestCase;
use PHPUnit\Util\DevTool;
use RecursiveFilterIterator;
use RecursiveIterator;

final class ChunkFilterIterator extends RecursiveFilterIterator
{
    protected array $allowedTests;

    public function __construct(RecursiveIterator $iterator, array $allowedTests)
    {
        parent::__construct($iterator);

        $this->allowedTests = $allowedTests;
    }

    public function accept(): bool
    {
        $test = $this->getInnerIterator()->current();

        if ($test instanceof TestSuite) {
            return true;
        }

        if (empty($this->allowedTests)) {
            return true;
        }
        //DevTool::print_rr($this->allowedTests);

        $accept = false;

        if ($test instanceof TestCase || $test instanceof PhptTestCase) {
            $testName = $test->getTestName();
            $accept   = in_array($testName, $this->allowedTests, false);
            //DevTool::print_rr($accept);
        }
        //DevTool::print_rr(get_class($test));

        return $accept;
    }
}
