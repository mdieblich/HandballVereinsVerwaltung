<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

final class PHPUnitTest extends TestCase
{
    /**
     * @testdox PHPUnit funktioniert
     */
    public function testIfPhpunitWorks(): void
    {
        $this->assertSame("A", "A");
    }
}


