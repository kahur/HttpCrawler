<?php
/**
 * Created by PhpStorm.
 * User: kamil.hurajt
 * Date: 11/01/2017
 * Time: 16:18
 */

namespace B4B\Library\Crawler;


interface StorageInterface
{
    public function save($key, $value);
    public function get($key);

}