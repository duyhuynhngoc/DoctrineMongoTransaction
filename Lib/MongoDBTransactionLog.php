<?php
/**
 * Code Owner: DuyHuynh
 * Modified date: 6/29/2015
 * Modified by: Duy Huynh
 */

namespace MongoTransactionBundle\Lib;


use MongoTransactionBundle\Document\TransactionLogs;
use Doctrine\ODM\MongoDB\DocumentManager;

class MongoDBTransactionLog {

    public static function transactionFinished()
    {
        $repo = self::getRepository();

        $repo->createQueryBuilder()->remove()->field("transaction")->equals(MongoDBTransaction::getTransaction())->getQuery()->execute();

    }

    public static function getTransactionList($collection)
    {
        $repo = self::getRepository();
        return $repo->createQueryBuilder()
                    ->hydrate(false)
                    ->field('transaction')->equals(MongoDBTransaction::getTransaction())
                    ->field('fromcollection')->equals($collection)
                    ->getQuery()
                    ->execute();
    }

    public static function transferTo($obj)
    {

        $repo = self::getRepository();

        $data = array();
        $data['data'] = $obj->toArray();
        unset($data['id']);

        $data['fromcollection'] = $obj->getCollection();

        $data['transaction'] = MongoDBTransaction::getTransaction();

        $repo->createQueryBuilder()->insert()->setNewObj($data)->getQuery()->execute();

    }

    public static function getRepository()
    {
        try {
            $dm = Utils::getDocumentManager();

            return $dm->getRepository("MongoTransactionBundle:TransactionLogs");

        }catch (\Exception $e){
            var_dump($e->getMessage());
        }
    }

}