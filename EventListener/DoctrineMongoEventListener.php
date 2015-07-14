<?php
/**
 * Code Owner: DuyHuynh
 * Modified date: 7/3/2015
 * Modified by: Duy Huynh
 */

namespace MongoTransactionBundle\EventListener;


use MongoTransactionBundle\Lib\MongoDBTransaction;
use MongoTransactionBundle\Lib\MongoDBTransactionLog;
use MongoTransactionBundle\Lib\Utils;

class DoctrineMongoEventListener {

    public function preUpdate(\Doctrine\ODM\MongoDB\Event\LifecycleEventArgs $eventArgs)
    {
        $transacInfo = MongoDBTransaction::getTransactionInfo();
        if ($transacInfo) {

            $document = $eventArgs->getDocument();

            $documentTrans = $document->getTransactioninfo();

            if(is_object($documentTrans)) {

                $document->setTransactionInfo($transacInfo->makeupTransactionInfo($document));

                //Log
                MongoDBTransactionLog::transferTo($document);

                Utils::getDocumentManager()->refresh($document);
                $document->setWd($GLOBALS['TransInfo']->makeupWD($document, false));
                $dm = $eventArgs->getDocumentManager();
                $class = $dm->getClassMetadata(get_class($document));
                $dm->getUnitOfWork()->computeChangeSet($class, $document);
            }else {
                Utils::getDocumentManager()->detach($document);
            }
        }
    }
}