<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

require_once __DIR__."/../../seed/DBScheme.php";

final class DBSchemeTest extends TestCase {

    private DBHandle $dbHandle;
    private DBScheme $dbScheme;

    protected function setUp(): void {
        $this->dbhandle = new DBHandle(
            "localhost",
            "root",
            "",
            "testdb"
        );
        $this->dbScheme = new DBScheme($this->dbHandle);
        $this->dbScheme->drop();
    }

    public function testCreatesScheme(): void {
        // arrange

        // act
        $this->dbScheme->seed();

        // assert
        $this->assertTableExists('verein');
    }

    private function assertTableExists(string $table_name): void {
        $prefix = $this->dbHandle->prefix;
        $tableExists = $this->dbHandle->get_var("SELECT EXISTS (SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_SCHEMA='testdb' AND TABLE_NAME='$prefix$table_name')");
        $this->assertEquals(1, $tableExists);
    }

}
?>