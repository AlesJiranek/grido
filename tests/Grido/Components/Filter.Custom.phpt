<?php

/**
 * Test: Filter.
 *
 * @author     Petr Bugyík
 * @package    Grido\Tests
 */

require_once __DIR__ . '/../bootstrap.php';

use Tester\Assert,
    Grido\Grid;

class FilterCustom extends Tester\TestCase
{
    function testFormControl()
    {
        $grid = new Grid;
        $control = new \Nette\Forms\Controls\TextArea;
        $filter = $grid->addFilterCustom('custom', $control);
        Assert::same($control, $filter->control);
    }

    function testMakeFilter() //__makeFilter()
    {
        $grid = new Grid;
        $control = new \Nette\Forms\Controls\TextArea;
        $filter = $grid->addFilterCustom('custom', $control);
        Assert::same(array(' ([custom] = %s )', 'TEST'), $filter->__makeFilter('TEST'));
    }
}

run(__FILE__);
