<?php

namespace Tests;

use B4B\Library\Crawler\Exception;
use B4B\Library\Crawler\StorageInterface;
use PHPUnit\Framework\TestCase;

/**
 * Created by PhpStorm.
 * User: kamil.hurajt
 * Date: 11/01/2017
 * Time: 16:30
 */
class CrawlerTest extends TestCase
{
    protected $url = 'http://www.google.com';


    public function testFetch()
    {
        $key = md5($this->url);
        $storage = $this->createMock(StorageInterface::class);
        $storage->expects($this->once())->method('save')->with($key, date("Y-m-d"));

        $crawler = new \B4B\Library\Crawler\Crawler($storage);

        $this->assertNotEmpty($crawler->fetch($this->url));
    }

    public function testFetchInvalidUrl()
    {
        $this->expectException(Exception::class);

        $storage = $this->createMock(StorageInterface::class);

        $crawler = new \B4B\Library\Crawler\Crawler($storage);

        $crawler->fetch('invalid');
    }

    public function testIsExpired()
    {
        $key = md5($this->url);
        $storage = $this->createMock(StorageInterface::class);
        $storage->expects($this->once())->method('get')->with($key)->willReturn(date("Y-m-d", strtotime('-1 days')));

        $crawler = new \B4B\Library\Crawler\Crawler($storage);

        $this->assertTrue($crawler->isExpired($this->url));
    }

    public function testIsNotExpired()
    {
        $key = md5($this->url);
        $storage = $this->createMock(StorageInterface::class);
        $storage->expects($this->once())->method('get')->with($key)->willReturn(date("Y-m-d"));

        $crawler = new \B4B\Library\Crawler\Crawler($storage);

        $this->assertFalse($crawler->isExpired($this->url));
    }


}