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
        $success = $dbHandle->query("DROP TABLE IF EXISTS A");
        $success = $dbHandle->query("CREATE TABLE A (b int)");
        $this->assertTrue($success);
        $success = $dbHandle->query("INSERT INTO A (b) VALUES (3)");
        $this->assertTrue($success);

        $value = $dbHandle->get_var("SELECT b FROM A");
        $this->assertEquals("3", $value);
    }

    public function testGet_row_as_array(): void {
        $dbHandle = $this->createTestDBConnection();
        $success = $dbHandle->query("DROP TABLE IF EXISTS A");
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
        $success = $dbHandle->query("DROP TABLE IF EXISTS A");
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
    
    public function testCanInsertBooleanTrue(): void {
        $dbHandle = $this->createTestDBConnection();
        $success = $dbHandle->query("DROP TABLE IF EXISTS A");
        $success = $dbHandle->query("CREATE TABLE A (b TINYINT)");
        $this->assertTrue($success);

        // act
        $array_to_insert = array('b' => true);
        $dbHandle->insert("A", $array_to_insert);

        // assert
        $value = $dbHandle->get_var("SELECT b FROM A");
        $this->assertEquals(1, $value);
    }
    public function testCanInsertBooleanFalse(): void {
        $dbHandle = $this->createTestDBConnection();
        $success = $dbHandle->query("DROP TABLE IF EXISTS A");
        $success = $dbHandle->query("CREATE TABLE A (b TINYINT)");
        $this->assertTrue($success);

        // act
        $array_to_insert = array('b' => false);
        $dbHandle->insert("A", $array_to_insert);

        // assert
        $value = $dbHandle->get_var("SELECT b FROM A");
        $this->assertEquals(0, $value);
    }
    public function testCanInsertIntegers(): void {
        $dbHandle = $this->createTestDBConnection();
        $success = $dbHandle->query("DROP TABLE IF EXISTS A");
        $success = $dbHandle->query("CREATE TABLE A (b int)");
        $this->assertTrue($success);

        // act
        $array_to_insert = array('b' => 16);
        $dbHandle->insert("A", $array_to_insert);

        // assert
        $value = $dbHandle->get_var("SELECT b FROM A");
        $this->assertEquals(16, $value);
    }

    public function testCanInsertStrings(): void {
        $dbHandle = $this->createTestDBConnection();
        $success = $dbHandle->query("DROP TABLE IF EXISTS A");
        $success = $dbHandle->query("CREATE TABLE A (b VARCHAR(1024))");
        $this->assertTrue($success);

        // act
        $array_to_insert = array('b' => 'testCanInsertStrings');
        $dbHandle->insert("A", $array_to_insert);

        // assert
        $value = $dbHandle->get_var("SELECT b FROM A");
        $this->assertEquals('testCanInsertStrings', $value);
    }

    public function testCanNotInsertOtherTypes(): void {
        // assert
        $this->expectException(InvalidArgumentException::class);

        // arrange
        $dbHandle = $this->createTestDBConnection();
        $success = $dbHandle->query("DROP TABLE IF EXISTS A");
        $success = $dbHandle->query("CREATE TABLE A (b int)");
        $this->assertTrue($success);

        // act
        $exampleObject = new ExampleClass();
        $exampleObject->someValue = 99;
        $array_to_insert = array('b' => $exampleObject);
        $dbHandle->insert("A", $array_to_insert);
    }

    public function testGetInsertedId(): void {
        $dbHandle = $this->createTestDBConnection();
        $success = $dbHandle->query("DROP TABLE IF EXISTS A");
        $success = $dbHandle->query("CREATE TABLE A (id INT NOT NULL AUTO_INCREMENT, PRIMARY KEY (id), b int)");
        $this->assertTrue($success);

        // act
        $array_to_insert = array('b' => 16);
        $dbHandle->insert("A", $array_to_insert);
        $firstInsertedID = $dbHandle->insert_id;
        $array_to_insert = array('b' => 17);
        $dbHandle->insert("A", $array_to_insert);
        $secondInsertedID = $dbHandle->insert_id;

        // assert
        $this->assertGreaterThan($firstInsertedID, $secondInsertedID);
    }
}

class ExampleClass{
    public int $someValue;
}

