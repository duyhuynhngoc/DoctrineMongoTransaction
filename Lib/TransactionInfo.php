<?php
/**
 * Code Owner: DuyHuynh
 * Modified date: 6/16/2015
 * Modified by: Duy Huynh
 */

namespace MongoTransactionBundle\Lib;


use MongoTransactionBundle\Document\BaseDocument;

class TransactionInfo {

    const TRANSACTION_DOCUMENT_LOCK      = 1;
    const TRANSACTION_DOCUMENT_UNLOCK    = 0;
    const TRANSACTION_DOCUMENT_STATUS_NEW = 1;
    const TRANSACTION_DOCUMENT_STATUS_OLD = 0;
    const TRANSACTION_STATUS_FAILURE = 0;
    const TRANSACTION_STATUS_SUCCESSFUL = 1;

    protected $transactionIdentified = "";
    protected $isLockDocument = 1;
    protected $docStatus = 1;
    protected $status = 1;

    /**
     * Construction and generate a transaction identified
     */
    public function __construct()
    {
        $this->transactionIdentified = Utils::generateUID();
    }


    /**
     * Return minimum of transaction information
     * @return \stdClass
     * @throws \Exception
     */
    public function encode()
    {
        $this->checkingTransaction();

        $obj = new \stdClass();

        $obj->Transaction = $this->transactionIdentified;
        $obj->IsLock        = $this->isLockDocument;
        $obj->Status        = $this->docStatus;
        return $obj;
    }

    private function checkingTransaction()
    {
        if(empty($this->transactionIdentified))
            throw new \Exception("Transaction must be start.");
    }


    /**
     * Get transaction status
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * set Transaction status
     * @param int $status
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }


    /**
     * Lock/Unlock document
     * @param int $lock
     * @return $this
     */
    public function lockDocument($lock = 1)
    {
        $this->isLockDocument = $lock;
        return $this;
    }

    /**
     * Document status
     * @param $status
     */
    public function documentStatus($status)
    {
        $this->docStatus = $status;
        return $this;
    }

    public function getTransaction()
    {
        return $this->transactionIdentified;
    }


    /**
     * Apply transaction information to document
     * @param BaseDocument $obj
     * @return \stdClass
     * @throws \Exception
     */
    public function makeupTransactionInfo(BaseDocument $obj)
    {
        $this->checkingTransaction();

        $id = $obj->getId();
        $collection = $obj->getCollection();

        $this->applyRepository($collection);

        if (!empty($id)) {
            $repo = Utils::getRepository($collection);

            $this->docStatus = self::TRANSACTION_DOCUMENT_STATUS_OLD;
            $this->isLockDocument = self::TRANSACTION_DOCUMENT_LOCK;

        } else {
            $this->docStatus = self::TRANSACTION_DOCUMENT_STATUS_NEW;
            $this->isLockDocument = self::TRANSACTION_DOCUMENT_LOCK;
        }

        return $this->encode();
    }

    /**
     * Storage interacted collections
     * @param $collection
     * @return $this
     */
    private function applyRepository($collection)
    {
        if(!isset($GLOBALS['collectionlist'])){
            $GLOBALS['collectionlist'] = array();
        }
        if(!in_array($collection, $GLOBALS['collectionlist']))
            $GLOBALS['collectionlist'][] = $collection;

        return $this;
    }
}