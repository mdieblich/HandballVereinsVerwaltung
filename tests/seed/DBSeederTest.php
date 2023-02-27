<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

require_once __DIR__."/../../seed/DBSeeder.php";

final class DBSeederTest extends TestCase {

    private DBHandle $dbHandle;
    private DBScheme $dbScheme;
    private DBSeeder $dbSeeder;

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

    public function testCreatesHeimverein(): void{
        // arrange
        define( 'VEREIN_NAME', 'Turnerkreis Nippes' );
        define( 'VEREIN_NULIGA_ID', '74851' );
        $this->dbScheme->seed();
        $this->dbSeeder = new DBSeeder($this->dbHandle);

        // act
        $this->dbSeeder->seed();

        // assert
        $vereinTableName = $this->dbHandle->prefix.'Verein';
        $anzahlVereine = $this->dbHandle->get_var("SELECT COUNT(*) FROM $vereinTableName");
        $this->assertEquals(1, $anzahlVereine);

        $expectedHeimVerein = array(
            'name' => 'Turnerkreis Nippes',
            'heimVerein' => 1,
            'nuligaClubId' => 74851
        );
        $actualHeimVerein = $this->dbHandle->get_row_as_array("SELECT * FROM $vereinTableName");
        unset($actualHeimVerein['id']); // ID ist egal
        $this->assertEquals($expectedHeimVerein, $actualHeimVerein);
    }
}