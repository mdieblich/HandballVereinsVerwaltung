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
        $vereinExists = $this->dbHandle->get_var("SELECT EXISTS (SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_SCHEMA='testdb' AND TABLE_NAME='mwd_Verein')");
        $this->assertEquals(1, $vereinExists);
    }

}
?>