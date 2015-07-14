<?php
/**
 * Code owner: DuyHuynh
 * Modified Date: 2015/03/03
 * Modified by: Duy Huynh
 */


namespace MongoTransactionBundle\Document;
use Ccicore\MongoTransactionBundle\Lib\MongoDBTransaction;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Ccicore\UtilityBundle\Lib\StaticKernel;
/**
 * @MongoDB\Document(repositoryClass="MongoTransactionBundle\Repository\TransactionLogsRepository")
 */
class TransactionLogs
{
    
    /**
     * @var MongoId $id
     */
    protected $id;

    /**
     * @var int $code
     */
    protected $code;

    /**
     * @var raw $data
     */
    protected $data;

    /**
     * @var string $transaction
     */
    protected $transaction;

    /**
     * @var boolean $error
     */
    protected $error;

    /**
     * @var string $fromdb
     */
    protected $fromdb;

    /**
     * @var string $fromcollection
     */
    protected $fromcollection;

    /**
     * @var date $lastmodified
     */
    protected $lastmodified;

    /**
     * @var int $isdeleted
     */
    protected $isdeleted;

    /**
     * @var string $modifiedby
     */
    protected $modifiedby;


    /**
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set code
     *
     * @param int $code
     * @return self
     */
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    /**
     * Get code
     *
     * @return int $code
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set data
     *
     * @param raw $data
     * @return self
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * Get data
     *
     * @return raw $data
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set transaction
     *
     * @param string $transaction
     * @return self
     */
    public function setTransaction($transaction)
    {
        $this->transaction = $transaction;
        return $this;
    }

    /**
     * Get transaction
     *
     * @return string $transaction
     */
    public function getTransaction()
    {
        return $this->transaction;
    }

    /**
     * Set error
     *
     * @param boolean $error
     * @return self
     */
    public function setError($error)
    {
        $this->error = $error;
        return $this;
    }

    /**
     * Get error
     *
     * @return boolean $error
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * Set fromdb
     *
     * @param string $fromdb
     * @return self
     */
    public function setFromdb($fromdb)
    {
        $this->fromdb = $fromdb;
        return $this;
    }

    /**
     * Get fromdb
     *
     * @return string $fromdb
     */
    public function getFromdb()
    {
        return $this->fromdb;
    }

    /**
     * Set fromcollection
     *
     * @param string $fromcollection
     * @return self
     */
    public function setFromcollection($fromcollection)
    {
        $this->fromcollection = $fromcollection;
        return $this;
    }

    /**
     * Get fromcollection
     *
     * @return string $fromcollection
     */
    public function getFromcollection()
    {
        return $this->fromcollection;
    }

    /**
     * Set lastmodified
     *
     * @param date $lastmodified
     * @return self
     */
    public function setLastmodified($lastmodified)
    {
        $this->lastmodified = $lastmodified;
        return $this;
    }

    /**
     * Get lastmodified
     *
     * @return date $lastmodified
     */
    public function getLastmodified()
    {
        return $this->lastmodified;
    }

    /**
     * Set isdeleted
     *
     * @param int $isdeleted
     * @return self
     */
    public function setIsdeleted($isdeleted)
    {
        $this->isdeleted = $isdeleted;
        return $this;
    }

    /**
     * Get isdeleted
     *
     * @return int $isdeleted
     */
    public function getIsdeleted()
    {
        return $this->isdeleted;
    }

    /**
     * Set modifiedby
     *
     * @param string $modifiedby
     * @return self
     */
    public function setModifiedby($modifiedby)
    {
        $this->modifiedby = $modifiedby;
        return $this;
    }

    /**
     * Get modifiedby
     *
     * @return string $modifiedby
     */
    public function getModifiedby()
    {
        return $this->modifiedby;
    }
}
