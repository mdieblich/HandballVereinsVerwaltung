<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

require_once __DIR__."/../../seed/DBScheme.php";

final class DBSchemeTest extends TestCase {

    private DBHandle $dbHandle;
    private DBScheme $dbScheme;

    protected function setUp(): void {
        $this->dbHandle = new DBHandle(
            "localhost",
            "root",
            "",
            "testdb"
        );
        $this->dbScheme = new DBScheme($this->dbHandle);
    }
    protected function tearDown(): void {
        $this->dbScheme->dropAllTables();
    }

    public function testDropsAllTables(): void{
        // arrange
        $this->dbHandle->query("CREATE TABLE IF NOT EXISTS ".$this->dbHandle->prefix."mannschaft(id int);");
        $this->assertTableExists('mannschaft');

        // act
        $this->dbScheme->dropAllTables();

        // assert
        $this->assertTableDoesNotExist('mannschaft');
    }
    
    public function testCreatesScheme(): void {
        // arrange

        // act
        $this->dbScheme->seed();

        // assert
        $this->assertTableExists('verein');
        $this->assertTableExists('mannschaft');

        $this->assertTableExists('meisterschaft');
        $this->assertTableExists('liga');
        $this->assertTableExists('mannschaftsmeldung');
        $this->assertTableExists('spiel');

        $this->assertTableExists('dienst');
    }

    private function assertTableExists(string $table_name): void {
        $this->assertTableExistanceIs($table_name, 1);
    }

    private function assertTableExistanceIs(string $table_name, int $present): void {
        $prefix = $this->dbHandle->prefix;
        $tableExists = $this->dbHandle->get_var("SELECT EXISTS (SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_SCHEMA='testdb' AND TABLE_NAME='$prefix$table_name')");
        $this->assertEquals($present, $tableExists, "Tabelle $table_name nicht gefunden");
    }

    private function assertTableDoesNotExist(string $table_name): void {
        $this->assertTableExistanceIs($table_name, 0);
    }

}
?>