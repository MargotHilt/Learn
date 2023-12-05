<?php

namespace Simovative\Kaboom\User\Model\User;


use Simovative\Kaboom\App\ApplicationFactory;

class UserRepository implements UserRepositoryInterface
{

    private $pdo;
    private $lastSqlUsed;
    private $statement;

    public function __construct()
    {
        $applicationFactory = new ApplicationFactory();
        $this->pdo = $applicationFactory->createPdo();
    }

    public function insert(string $table, array $data): bool {
        $sql = 'INSERT
                INTO 
                `:table`
                    (`:fields`)
                VALUES 
                    (`:values`)';
        $fields = implode(', ', array_keys($data));
        $values = implode(', ', array_values($data));
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(':table', $table);
        $stmt->bindParam(':fields', $fields);
        $stmt->bindParam(':values', $values);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function delete(string $table)
    {
        $sql = 'DELETE FROM `:table`';

        $this->lastSqlUsed = $sql;

        return $this;
    }


    public function where()
    {
        // TODO: Implement update() method.
    }

    public function prepare()
    {
        $this->statement = $this->pdo->prepare($this->lastSqlUsed);
        return $this;
    }

    public function bind(string $table)
    {
        $this->statement->bindParam(':table', $table);
        return $this;
    }

    public function exec()
    {
        $this->statement->execute();
    }

    public function update(): bool
    {
        // TODO: Implement update() method.
    }

    public function select(): string|bool
    {
        // TODO: Implement select() method.
    }
}
