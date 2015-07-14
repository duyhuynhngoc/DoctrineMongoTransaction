<?php
/**
 * Code owner: DuyHuynh
 * Modified Date: 2015/03/03
 * Modified by: Duy Huynh
 */


namespace MongoTransactionBundle\Document;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use MongoTransactionBundle\Lib\Utils;

/**
 * @Document
 */
class BaseDocument
{
	/**
     * @MongoDB\Id
     */
    protected $id;
    /**
     * @var \DateTime  
  	 * @MongoDB\Field(name="lastmodified", type="date")
     */
    protected $lastmodified;
    /**
     * @MongoDB\Int
     */
    protected $isdeleted;
	/**
     * @MongoDB\Int
     */
    protected $modifiedby;
    /**
     * @var string $wd
     */
    protected $transactoninfo;


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
     * Set lastmodified
     *
     * @param datetime $lastmodified
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
     * @return datetime $lastmodified
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
     * @param int $modifiedby
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
     * @return int $modifiedby
     */
    public function getModifiedby()
    {
        return $this->modifiedby;
    }

    /**
     * Set transactioninfo
     *
     * @param string $transactioninfo
     * @return self
     */
    public function setTransactioninfo($transactioninfo)
    {
        $this->transactoninfo = $transactioninfo;
        return $this;
    }

    /**
     * Get transactioninfo
     *
     * @return string $transactioninfo
     */
    public function getTransactionifo()
    {
        return $this->transactoninfo;
    }

    /**
     *
     * @param null $dm
     * @return MongoDBTransaction|null Return session working
     */


    public function save($dm = null){

        if($dm == null){
            $dm = Utils::getDocumentManager();
        }

        $this->setLastmodified(new \MongoDate());

        if(MongoDBTransaction::getTransactionInfo()) {
            $this->setWd(MongoDBTransaction::getTransactionInfo()->makeupWD($this));

            if (empty($this->id))
                $dm->persist($this);

            if (!$dm->getUnitOfWork()->isInIdentityMap($this))
                $dm->merge($this);

        }

    }

    /**
     * Get collection for repository
     * @return string
     */
    public function getCollection()
    {
        $cls = preg_split("/\\\/", get_called_class());

        $colection = $cls[0] . $cls[1] . ":" . $cls[count($cls) - 1];

        return $colection;
    }


    /**
     * Convert class's property to object
     * @return \stdClass
     */
    public function toObject()
    {
        $properties = (array)$this;
        $data = new \stdClass();

        foreach($properties as $key => $value){
            $data->{trim(substr($key, 2))} = $value;
        }

        return $data;
    }

    /**
     * Convert class's property to associated array
     * @return array
     */
    public function toArray()
    {
        $properties = (array)$this;
        $data = array();

        foreach($properties as $key => $value){
            $data[trim(substr($key, 2))] = $value;
        }

        return $data;
    }
}
