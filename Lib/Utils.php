<?php
/**
 * Code Owner: DuyHuynh
 * Modified date: 7/14/2015
 * Modified by: Duy Huynh
 */

namespace MongoTransactionBundle\Lib;


class Utils {

    public static function generateUID()
    {
        $uuid = "";
        mt_srand((double)microtime() * 10000);
        //optional for php 4.2.0 and up.
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45);

        $uuid = substr($charid, 0, 8) . $hyphen . substr($charid, 8, 4) . $hyphen . substr($charid, 12, 4) . $hyphen . substr($charid, 16, 4) . $hyphen . substr($charid, 20, 12);
        return strtolower($uuid);
    }

    public static function getDocumentManager()
    {
        $kernel = $GLOBALS['kernel'];
        if ('AppCache' == get_class($kernel)) {
            $kernel = $kernel -> getKernel();
        }

        return $kernel -> getContainer()->get('doctrine_mongodb')->getManager();
    }

    public static function getRepository($collection)
    {
        $dm = self::getDocumentManager();

        $repository = $dm->getRepository($collection);

        return $repository;
    }
}