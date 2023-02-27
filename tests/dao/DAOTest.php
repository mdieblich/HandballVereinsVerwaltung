<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

require_once __DIR__."/../../dao/DAO.php";

final class DAOTest extends TestCase {

    public function testTableName(): void {
        // arrange
        $dbHandle = new stdClass();
        $dbHandle->prefix="mwd_";

        // act
        $table_name = ExampleDAO::tableName($dbHandle);

        // assert
        $this->assertEquals('mwd_example', $table_name);
    }
}

class ExampleDAO extends DAO{}
?>