<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

require_once __DIR__."/../../dao/DBhandle.php";

final class DBHandleTest extends TestCase
{
    private function createTestDBConnection(): DBHandle {
        return new DBHandle(
            "localhost",
            "root",
            "",
            "testdb"
        );
    }

    public function testCanCreateConnection(): void {
        $dbHandle = $this->createTestDBConnection();
        $this->assertNotNull($dbHandle);
    }
    
    public function testCanQuery(): void {
        $dbHandle = $this->createTestDBConnection();
        $success = $dbHandle->query("SELECT CURRENT_TIMESTAMP");
        $this->assertTrue($success);
    }

    public function testGet_var(): void {
        $dbHandle = $this->createTestDBConnection();
        $success = $dbHandle->query("DROP TABLE A");
        $success = $dbHandle->query("CREATE TABLE A (b int)");
        $this->assertTrue($success);
        $success = $dbHandle->query("INSERT INTO A (b) VALUES (3)");
        $this->assertTrue($success);

        $value = $dbHandle->get_var("SELECT b FROM A");
        $this->assertEquals("3", $value);
    }

    public function testGet_row_as_array(): void {
        $dbHandle = $this->createTestDBConnection();
        $success = $dbHandle->query("DROP TABLE A");
        $success = $dbHandle->query("CREATE TABLE A (b int, c VARCHAR(25))");
        $this->assertTrue($success);
        $success = $dbHandle->query("INSERT INTO A (b,c) VALUES (9,'testGet_row_as_array')");
        $this->assertTrue($success);

        $value = $dbHandle->get_row_as_array("SELECT * FROM A");
        $expectedArray = array('b' => 9, 'c' => 'testGet_row_as_array');
        $this->assertEquals($expectedArray, $value);
    }
    public function testGet_results_as_array(): void {
        $dbHandle = $this->createTestDBConnection();
        $success = $dbHandle->query("DROP TABLE A");
        $success = $dbHandle->query("CREATE TABLE A (b int, c VARCHAR(25))");
        $this->assertTrue($success);
        $success = $dbHandle->query("INSERT INTO A (b,c) VALUES (2,'testGet_results_as_array0'), (4,'testGet_results_as_array1')");
        $this->assertTrue($success);

        $value = $dbHandle->get_results_as_array("SELECT * FROM A");
        $expectedArray = array();
        $expectedArray[] = array('b' => 2, 'c' => 'testGet_results_as_array0');
        $expectedArray[] = array('b' => 4, 'c' => 'testGet_results_as_array1');
        $this->assertEquals($expectedArray, $value);
    }
}


