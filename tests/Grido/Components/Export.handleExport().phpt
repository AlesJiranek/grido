<?php

/**
 * Test: Export - handleExport()
 *
 * @author     Petr Bugyík
 * @package    Grido\Tests
 */

require_once __DIR__ . '/../bootstrap.php';
require_once __DIR__ . '/../Helper.inc';

use Tester\Assert,
    Grido\Grid;

class MockResponse extends \Nette\Object implements \Nette\Http\IResponse
{
    public static $headers = array();

    function setHeader($name, $value)
    {
        self::$headers[$name] = $value;
        return $this;
    }

    function setCode($code) {}
    function getCode() {}
    function addHeader($name, $value) {}
    function setContentType($type, $charset = NULL) {}
    function redirect($url, $code = self::S302_FOUND) {}
    function setExpiration($seconds) {}
    function isSent() {}
    function getHeaders() {}
    function setCookie($name, $value, $expire, $path = NULL, $domain = NULL, $secure = NULL, $httpOnly = NULL) {}
    function deleteCookie($name, $path = NULL, $domain = NULL, $secure = NULL) {}
}

test(function() {
    Helper::grid(function(Grid $grid) {
        $grid->setModel(array(
            array('id' => 1, 'a' => 'A1', 'b' => 'B1'),
            array('id' => 2, 'a' => 'A2', 'b' => 'B2'),
            array('id' => 3, 'a' => 'A3', 'b' => 'B3'),
            array('id' => 4, 'a' => 'A4', 'b' => 'B4'),
            array('id' => 5, 'a' => 'A5', 'b' => 'B5'),
        ));
        $grid->setDefaultPerPage(2);
        $grid->addColumnText('a', 'A');
        $grid->addColumnText('b', 'B');
        $grid->setExport();
    });

    ob_start();
        Helper::request(array('do' => 'grid-export-export'))->send(mock('\Nette\Http\IRequest'), new MockResponse);
    Assert::same(file_get_contents(__DIR__ . '/Export.handleExport().expect'), ob_get_clean());

    Assert::same(array(
	'Content-Encoding' => 'UTF-16LE',
	'Content-Length' => 68,
	'Content-Type' => 'text/csv; charset=UTF-16LE',
	'Content-Disposition' => 'attachment; filename="Grid.csv"; filename*=utf-8\'\'Grid.csv',
    ), MockResponse::$headers);
});
