<?php

use LaravelLegends\Sorter\Sorter;
use Illuminate\View\Factory;
use Illuminate\Http\Request;

use Mockery as m;

class SorterTest extends PHPUnit_Framework_Testcase
{
    public function setUp()
    {

        $this->request = Request::create(
            '/foo', 'GET', ['__order__' => 'asc', '__sort__' => 'id']
        );

        $this->url = new Illuminate\Routing\UrlGenerator(
            new Illuminate\Routing\RouteCollection(),
            $this->request
        );

        $this->viewFactory = m::mock('\Illuminate\View\Factory');

        $this->html = new Illuminate\Html\HtmlBuilder(
            $this->url, 
            $this->viewFactory
        );

        $this->sorter = new Sorter(
            $this->url,
            $this->html,
            $this->request,
            '__sort__',
            '__order__'
        );
    }

    public function testUrl()
    {
        $this->assertEquals(
            'http://localhost/path?__sort__=name&__order__=asc',
            $this->sorter->url('name', '/path')
        );
    }

    public function testCurrent()
    {
        $this->assertEquals('id', $this->sorter->getCurrentField());

        // Repeat for test 'asc'

        $this->assertEquals(
            'http://localhost/path?__sort__=name&__order__=asc',
            $this->sorter->url('name', '/path')
        );

        $this->assertEquals(
            'http://localhost/path?__sort__=id&__order__=desc',
            $this->sorter->url('id', '/path')
        );
    }

    public function testAcceptedField()
    {
        $this->assertTrue(
            $this->sorter->checkCurrentByWhitelist(['id'])
        );

        $this->assertFalse(
            $this->sorter->checkCurrentByWhitelist(['name'])
        );

        // When is empty, is true

        $this->assertTrue(
            $this->sorter->checkCurrentByWhitelist([])
        );
    }


    public function testIndexs()
    {
        $this->assertEquals('__sort__', $this->sorter->getFieldIndex());

        $this->assertEquals('__order__', $this->sorter->getDirectionIndex());
    }

}