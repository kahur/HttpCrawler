<?php

namespace B4B\Library\Crawler;

/**
 * Created by PhpStorm.
 * User: kamil.hurajt
 * Date: 11/01/2017
 * Time: 16:17
 */
class Crawler
{

    /**
     * @var StorageInterface
     */
    protected $storage;

    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;
    }

    /**
     * @param $url
     * @return string
     */
    public function fetch($url) : string
    {
        if(!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new Exception('Invalid URL');
        }

        $this->storage->save(md5($url), date("Y-m-d"));

        return file_get_contents($url);
    }

    /**
     * @param $url
     * @param int $lastVisitDays
     * @return bool
     */
    public function isExpired(string $url,int $lastVisitDays = 1) : bool
    {
        $lastVisit = $this->storage->get(md5($url));

        $date = date("Y-m-d", strtotime('-1 day'));

        if($lastVisit <= $date) {
            return true;
        }

        return false;
    }

}