<?php
namespace App\model;
use Aura\SqlQuery\QueryFactory;
use Exception;
use PDO;
use \Tamtamchik\SimpleFlash\Flash;

class User {
    private static $queryFactory, $pdo;
    private $results;
    private $flash;

    public function __construct(QueryFactory $queryFactory, PDO $pdo, Flash $flash)
    {
        self::$queryFactory = $queryFactory;
        self::$pdo = $pdo;
        $this->flash = $flash;

    }

    public function getResults()
    {
        return $this->results;
    }

    public function getUserNameById()
    {
        return $this->results;
    }

    public function UserNameById($id)
    {
        $select = self::$queryFactory->newSelect();
        $select
            ->cols (['*'])
            ->from('users')
            ->where('id = :id')
            ->bindValue('id', $id);

        $sth = self::$pdo->prepare($select->getStatement());
        $sth->execute($select->getBindValues());
        $this->results = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $this->results;
    }

    public function getAllUsers()
    {
        $select = self::$queryFactory->newSelect();
        
            $select
                ->cols (['*'])
                ->from('users');
       
        $sth = self::$pdo->prepare($select->getStatement());
        $sth->execute($select->getBindValues());
        $this->results = $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteById($id)
    {
        $delete = self::$queryFactory->newDelete();

        $delete
            ->from('users')                   // FROM this table
            ->where('id = :id')           // AND WHERE these conditions
            ->bindValue('id', $id);   // bind one value to a placeholder
        // prepare the statement
        $sth = self::$pdo->prepare($delete->getStatement());

        // execute with bound values
        $sth->execute($delete->getBindValues()); 

        $delete = self::$queryFactory->newDelete();
        $delete
            ->from('reviews')                   // FROM this table
            ->where('user_id = :id')           // AND WHERE these conditions
            ->bindValue('id', $id);   // bind one value to a placeholder
        // prepare the statement
        $sth = self::$pdo->prepare($delete->getStatement());

        // execute with bound values
        $sth->execute($delete->getBindValues()); 

        $delete = self::$queryFactory->newDelete();
        $delete
            ->from('posts')                   // FROM this table
            ->where('user_id = :id')           // AND WHERE these conditions
            ->bindValue('id', $id);   // bind one value to a placeholder
        // prepare the statement
        $sth = self::$pdo->prepare($delete->getStatement());

        // execute with bound values
        $sth->execute($delete->getBindValues()); 

    }

}