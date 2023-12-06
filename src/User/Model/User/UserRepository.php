<?php

namespace Simovative\Kaboom\User\Model\User;

use PDO;
use Simovative\Kaboom\App\ApplicationFactory;

class UserRepository implements UserRepositoryInterface
{

    private PDO $pdo;
    private string $lastSqlUsed;
    private $statement;

    public function __construct()
    {
        $applicationFactory = new ApplicationFactory();
        $this->pdo = $applicationFactory->createPdo();
    }

    public function insert(string $table, array $colData): UserRepository
    {
        $fields = implode(', ', array_values($colData));
        $values = ':' . implode(', :', array_values($colData));

        $sql = 'INSERT INTO ' . $table .
            ' (' . $fields . ') 
            VALUES (' . $values . ')';

        $this->lastSqlUsed = $sql;

        return $this;
    }

    public function delete(string $table): UserRepository
    {
        $sql = 'DELETE FROM ' . $table;

        $this->lastSqlUsed = $sql;

        return $this;
    }

    public function prepBindExec(array $bindingParam = null): void
    {
        $this->statement = $this->pdo->prepare($this->lastSqlUsed);

        if(isset($bindingParam)){
            foreach ($bindingParam as $key=>&$value) { //pass by ref with an &

                $this->statement->bindParam(":".$key,$value);
            }
        }

        $this->statement->execute();
    }

    //public function update(): bool
    //{
        // TODO: Implement update() method.
    //}

    public function select(string $table, array $columnsArr): UserRepository
    {
        $columns = implode(', ', array_values($columnsArr));

        $sql = 'SELECT ' . $columns .
                ' FROM ' . $table;

        $this->lastSqlUsed = $sql;

        return $this;
    }

    public function leftJoin(string $rightTable, string $colRight, string $leftTable, string $colLeft): UserRepository
    {
        $this->lastSqlUsed = $this->lastSqlUsed .
            ' LEFT JOIN ' . $rightTable .
            ' ON ' . $rightTable . '.' . $colRight . ' = ' . $leftTable . '.' . $colLeft;

        return $this;
    }

    public function where(string $cond1, string $sign, string $cond2): UserRepository
    {
        $this->lastSqlUsed = $this->lastSqlUsed .
            ' WHERE ' . $cond1 . ' '. $sign . ' ' . $cond2;

        return $this;
    }

    public function fetchAll(): array
    {
        return $this->statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
