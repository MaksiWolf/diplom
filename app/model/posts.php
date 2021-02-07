<?php
namespace App\model;
use Aura\SqlQuery\QueryFactory;
use Exception;
use PDO;
use \Tamtamchik\SimpleFlash\Flash;

class Posts {

    private static $queryFactory, $pdo;
    private $results;
    private $category;
    private $flash;

    public function __construct(QueryFactory $queryFactory, PDO $pdo, Flash $flash)
    {
        self::$queryFactory = $queryFactory;
        self::$pdo = $pdo;
        $this->flash = $flash;

        //get category
        $this->category();
        $this->getCategory();
    }

    public function category()
    {
        try {
            $select = self::$queryFactory->newSelect();
            $select
                ->cols (['*'])
                ->from('category');

            $sth = self::$pdo->prepare($select->getStatement());
            $sth->execute();
            $this->category = $sth->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $exception) {
            $this->flash->error($exception->getMessage('Execution error SELECT function post->category'));
        }
    }

    public function findCategoryByName($name)
    {
        try {
            $select = self::$queryFactory->newSelect();
            $select
                ->cols (['*'])
                ->from('category')
                ->where('name = :name')
                ->bindValue('name', $name) ;

            $sth = self::$pdo->prepare($select->getStatement());
            $sth->execute($select->getBindValues());
            $this->category = $sth->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $exception) {
            $this->flash->error($exception->getMessage('Execution error SELECT function post->findCategoryByName'));
        }
    }

    public function getResults()
    {
        return $this->results;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function getByIdWithReviews($table, $id)
    {
        $select = self::$queryFactory->newSelect();
        $select
            ->cols (['*'])
            ->from('posts AS p')
            ->join(
                'LEFT',             // the join-type
                'reviews AS r',        // join to this table ...
                'p.id = r.post_id' // ... ON these conditions
            )
            ->join(
                'LEFT',             // the join-type
                'users AS u',        // join to this table ...
                'u.id = r.user_id' // ... ON these conditions
            )
            ->where('p.id = :id')
            ->bindValue('id', $id);


        $sth = self::$pdo->prepare($select->getStatement());
        $sth->execute($select->getBindValues());
        $this->results = $sth->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getById($table, $id)
    {
        $select = self::$queryFactory->newSelect();
        $select
            ->cols (['*'])
            ->from($table)
            ->where('id = :id')
            ->bindValue('id', $id);

        $sth = self::$pdo->prepare($select->getStatement());
        $sth->execute($select->getBindValues());
        $this->results = $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllFromTable($table, $status)
    {
        $select = self::$queryFactory->newSelect();
        if($status) {
            $select
                ->cols (['*'])
                ->from($table)
                ->where('status = :status')
                ->bindValue('status', $status) ;
        } else {
            $select
                ->cols (['*'])
                ->from($table);
        }

        $sth = self::$pdo->prepare($select->getStatement());
        $sth->execute($select->getBindValues());
        $this->results = $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllFromTableByCategory($table, $category)
    {
        $select = self::$queryFactory->newSelect();
        $select
            ->cols (['*'])
            ->from($table)
            ->where('category = :category')
            ->bindValue('category', $category) ;

        $sth = self::$pdo->prepare($select->getStatement());
        $sth->execute($select->getBindValues());
        $this->results = $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateTableById($table, $id, $params)
    {
        $update = self::$queryFactory->newUpdate();

        $update
            ->table($table)                  // update this table
            ->cols($params)
            ->where('id = :id')           // AND WHERE these conditions
            ->bindValue('id', $id);   // bind one value to a placeholder

        $sth = self::$pdo->prepare($update->getStatement());

        // execute with bound values
        $sth->execute($update->getBindValues());
    }

    public function deleteById($table, $id)
    {
        $this->getById($table, $id);
        $file = $this->results['0']['img'];
        unlink($file);

        $delete = self::$queryFactory->newDelete();
        $delete
            ->from('posts')
            ->where('id= :id')
            ->bindValue('id', $id) ;

        $sth = self::$pdo->prepare($delete->getStatement());
        // execute with bound values
        $sth->execute($delete->getBindValues());

        $delete = self::$queryFactory->newDelete();
        $delete
            ->from('reviews')
            ->where('post_id = :id')
            ->bindValue('id', $id) ;

        $sth = self::$pdo->prepare($delete->getStatement());
        // execute with bound values
        $sth->execute($delete->getBindValues());

    }

    public function insert($table, $params)
    {
        if($params['status']) {
            if($params['status'] == 'on') {
                $params['status'] = '0';
            } else {
                $params['status'] = '1';
            }
        }

        $insert = self::$queryFactory->newInsert();

        $insert
            ->into($table)                   // INTO this table
            ->cols($params);

         $sth = self::$pdo->prepare($insert->getStatement());

        // execute with bound values
        $sth->execute($insert->getBindValues());
        if (!empty($sth->errorInfo())){
            $this->flash->error($sth->errorInfo()['2']);
        }

    }
}