<?php
/**
 * Code Owner: DuyHuynh
 * Modified date: 6/16/2015
 * Modified by: Duy Huynh
 */

namespace MongoTransactionBundle\Lib;


use Doctrine\ODM\MongoDB\Events;
use MongoTransactionBundle\EventListener\DoctrineMongoEventListener;

class MongoDBTransaction {

    /**
     * @throws \Exception
     */
    public static function startTransaction()
    {
        self::generatePublicId();

        $e = new DoctrineMongoEventListener();
        $dm = Utils::getDocumentManager();
        $evm = $dm->getEventManager();
        $evm->addEventListener(Events::preUpdate, $e);
    }

    /**
     * Commit
     * @throws \Exception
     */
    public static function commitTransaction()
    {
        self::checkTransaction();

        Utils::getDocumentManager()->flush();
        Utils::getDocumentManager()->clear();

        $collections = self::getRepositoryCollection();

        foreach($collections as $collection) {

            $list = MongoDBTransactionLog::getTransactionList($collection);

            $repo = Utils::getRepository($collection);

            //If new record, force update transaction info
            $repo->createQueryBuilder()
                ->update()
                ->multiple(true)
                ->field("transactioninfo.Transaction")->set("")
                ->field("transactioninfo.IsLock")->set(TransactionInfo::TRANSACTION_DOCUMENT_UNLOCK)
                ->field("transactioninfo.Status")->set(TransactionInfo::TRANSACTION_DOCUMENT_STATUS_OLD)
                ->field("transactionifo.Transaction")->equals(self::getTransaction())
                ->field("transactioninfo.Status")->equals(TransactionInfo::TRANSACTION_DOCUMENT_STATUS_NEW)
                ->getQuery()
                ->execute();


            foreach($list as $item){
                $repo   ->createQueryBuilder()
                    ->update()
                    ->setNewObj(
                        $item['data']
                    )
                    ->field('_id')->equals($item['data']['id'])
                    ->getQuery()
                    ->execute();
            }
        }

        MongoDBTransactionLog::transactionFinished();
    }

    /**
     * Rollback
     * @throws \Exception
     */
    public static function rollbackTransaction()
    {

        self::checkTransaction();

        Utils::getDocumentManager()->clear();

        $collections = self::getRepositoryCollection();

        foreach($collections as $collection){
            $repo = Utils::getRepository($collection);

            //if record new, force delete by Transaction Identified
            $repo->createQueryBuilder()
                ->remove()
                ->field("transactioninfo.Transaction")->equals(self::getTransaction())
                ->field("transactioninfo.Status")->equals(TransactionInfo::TRANSACTION_DOCUMENT_STATUS_NEW)
                ->getQuery()
                ->execute();

            //If update, unlock
            $repo->createQueryBuilder()
                ->update()
                ->multiple(true)
                ->field('transactioninfo.Transaction')->set("")
                ->field('transactioninfo.IsLock')->set(TransactionInfo::TRANSACTION_DOCUMENT_UNLOCK)
                ->field("transactioninfo.Transaction")->equals(self::getTransaction())
                ->field("transactioninfo.Status")->equals(TransactionInfo::TRANSACTION_DOCUMENT_STATUS_OLD)
                ->getQuery()->execute();

        }

        MongoDBTransactionLog::transactionFinished();

    }

    /**
     * Reading criteria for transaction
     * @return array
     */
    public static function getFilterTransaction()
    {
        return array('transactioninfo.Status'=>TransactionInfo::TRANSACTION_DOCUMENT_STATUS_OLD);
    }

    /**
     * @return \Ccicore\UtilityBundle\Lib\ramdom
     */
    private static function generatePublicId()
    {
        if(!isset($GLOBALS['TransInfo'])){
            $GLOBALS['TransInfo'] = new TransactionInfo();
        }else {
            throw new \Exception("Transaction is started.");
        }
    }

    public static function getTransaction()
    {
        return self::getTransactionInfo()->getTransNum();
    }

    private static function checkTransaction()
    {
        if(!isset($GLOBALS['TransInfo'])){
            throw new \Exception("Please start transaction.");
        }
    }

    /**
     * Get Transaction info
     * @return mixed
     */
    public static function getTransactionInfo()
    {
        if (isset($GLOBALS['TransInfo']))
            return $GLOBALS['TransInfo'];
        return false;
    }

    /**
     *Get Collection list of Repository
     * @return mixed
     */
    public static function getRepositoryCollection()
    {
        if(isset($GLOBALS['collectionlist']))
            return $GLOBALS['collectionlist'];
        return array();
    }


}