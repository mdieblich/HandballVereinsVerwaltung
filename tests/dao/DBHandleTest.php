<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

require_once __DIR__."/../../dao/DBhandle.php";

final class DBHandleTest extends TestCase
{
    private DBHandle $dbHandle;

    protected function setUp(): void {
        $this->dbHandle = new DBHandle(
            "localhost",
            "root",
            "",
            "testdb"
        );
        $success = $this->dbHandle->query("DROP TABLE IF EXISTS A");
        $this->assertTrue($success);
    }


    public function testCanCreateConnection(): void {
        $this->assertNotNull($this->dbHandle);
    }
    
    public function testCanQuery(): void {
        $success = $this->dbHandle->query("SELECT CURRENT_TIMESTAMP");
        $this->assertTrue($success);
    }

    public function testGet_var(): void {
        $success = $this->dbHandle->query("CREATE TABLE A (b int)");
        $this->assertTrue($success);
        $success = $this->dbHandle->query("INSERT INTO A (b) VALUES (3)");
        $this->assertTrue($success);

        $value = $this->dbHandle->get_var("SELECT b FROM A");
        $this->assertEquals("3", $value);
    }

    public function testGet_row_as_array(): void {
        $success = $this->dbHandle->query("CREATE TABLE A (b int, c VARCHAR(25))");
        $this->assertTrue($success);
        $success = $this->dbHandle->query("INSERT INTO A (b,c) VALUES (9,'testGet_row_as_array')");
        $this->assertTrue($success);

        $value = $this->dbHandle->get_row_as_array("SELECT * FROM A");
        $expectedArray = array('b' => 9, 'c' => 'testGet_row_as_array');
        $this->assertEquals($expectedArray, $value);
    }
    public function testGet_results_as_array(): void {
        $success = $this->dbHandle->query("CREATE TABLE A (b int, c VARCHAR(25))");
        $this->assertTrue($success);
        $success = $this->dbHandle->query("INSERT INTO A (b,c) VALUES (2,'testGet_results_as_array0'), (4,'testGet_results_as_array1')");
        $this->assertTrue($success);

        $value = $this->dbHandle->get_results_as_array("SELECT * FROM A");
        $expectedArray = array();
        $expectedArray[] = array('b' => 2, 'c' => 'testGet_results_as_array0');
        $expectedArray[] = array('b' => 4, 'c' => 'testGet_results_as_array1');
        $this->assertEquals($expectedArray, $value);
    }
    
    public function testCanInsertBooleanTrue(): void {
        $success = $this->dbHandle->query("CREATE TABLE A (b TINYINT)");
        $this->assertTrue($success);

        // act
        $array_to_insert = array('b' => true);
        $this->dbHandle->insert("A", $array_to_insert);

        // assert
        $value = $this->dbHandle->get_var("SELECT b FROM A");
        $this->assertEquals(1, $value);
    }
    public function testCanInsertBooleanFalse(): void {
        $success = $this->dbHandle->query("CREATE TABLE A (b TINYINT)");
        $this->assertTrue($success);

        // act
        $array_to_insert = array('b' => false);
        $this->dbHandle->insert("A", $array_to_insert);

        // assert
        $value = $this->dbHandle->get_var("SELECT b FROM A");
        $this->assertEquals(0, $value);
    }
    public function testCanInsertIntegers(): void {
        $success = $this->dbHandle->query("CREATE TABLE A (b int)");
        $this->assertTrue($success);

        // act
        $array_to_insert = array('b' => 16);
        $this->dbHandle->insert("A", $array_to_insert);

        // assert
        $value = $this->dbHandle->get_var("SELECT b FROM A");
        $this->assertEquals(16, $value);
    }

    public function testCanInsertStrings(): void {
        $success = $this->dbHandle->query("CREATE TABLE A (b VARCHAR(1024))");
        $this->assertTrue($success);

        // act
        $array_to_insert = array('b' => 'testCanInsertStrings');
        $this->dbHandle->insert("A", $array_to_insert);

        // assert
        $value = $this->dbHandle->get_var("SELECT b FROM A");
        $this->assertEquals('testCanInsertStrings', $value);
    }

    public function testCanNotInsertOtherTypes(): void {
        // assert
        $this->expectException(InvalidArgumentException::class);

        // arrange
        $success = $this->dbHandle->query("CREATE TABLE A (b int)");
        $this->assertTrue($success);

        // act
        $exampleObject = new ExampleClass();
        $exampleObject->someValue = 99;
        $array_to_insert = array('b' => $exampleObject);
        $this->dbHandle->insert("A", $array_to_insert);
    }

    public function testGetInsertedId(): void {
        $success = $this->dbHandle->query("CREATE TABLE A (id INT NOT NULL AUTO_INCREMENT, PRIMARY KEY (id), b int)");
        $this->assertTrue($success);

        // act
        $array_to_insert = array('b' => 16);
        $this->dbHandle->insert("A", $array_to_insert);
        $firstInsertedID = $this->dbHandle->insert_id;
        $array_to_insert = array('b' => 17);
        $this->dbHandle->insert("A", $array_to_insert);
        $secondInsertedID = $this->dbHandle->insert_id;

        // assert
        $this->assertGreaterThan($firstInsertedID, $secondInsertedID);
    }

    public function testUpdateWithOneKey(): void {
        // arrange
        $success = $this->dbHandle->query("CREATE TABLE A (b VARCHAR(50), c INT)");
        $this->assertTrue($success);
        
        $success = $this->dbHandle->query("INSERT INTO A (b,c) VALUES ('please change',2),('do not change',4)");
        $this->assertTrue($success);
        
        // act
        $this->dbHandle->update("A", array('b' => 'changed'), array('c' => 2));

        // assert
        $unchangedValueForB = $this->dbHandle->get_var("SELECT b FROM A where c=4");
        $this->assertEquals('do not change', $unchangedValueForB);
        $newValueForB = $this->dbHandle->get_var("SELECT b FROM A where c=2");
        $this->assertEquals('changed', $newValueForB);

    }

    public function testUpdateWithMultipleKeys(): void {
        // arrange
        $success = $this->dbHandle->query("CREATE TABLE A (b VARCHAR(50), c INT, d INT)");
        $this->assertTrue($success);
        
        $success = $this->dbHandle->query("INSERT INTO A (b,c,d) VALUES ('please change',1,1),('do not change',1,2),('do not change',2,1)");
        $this->assertTrue($success);
        
        // act
        $this->dbHandle->update("A", array('b' => 'changed'), array('c' => 1, 'd' => 1));

        // assert
        $unchangedValue0 = $this->dbHandle->get_var("SELECT b FROM A where c=1 AND d=2");
        $this->assertEquals('do not change', $unchangedValue0);
        $unchangedValue1 = $this->dbHandle->get_var("SELECT b FROM A where c=2 AND d=1");
        $this->assertEquals('do not change', $unchangedValue1);
        $changedValue = $this->dbHandle->get_var("SELECT b FROM A where c=1 AND d=1");
        $this->assertEquals('changed', $changedValue);

    }
}

class ExampleClass{
    public int $someValue;
}

