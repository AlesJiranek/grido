<?php

/**
 * Test: Filter.
 *
 * @author     Petr Bugyík
 * @package    Grido\Tests
 */

namespace Grido\Tests;

require_once __DIR__ . '/../bootstrap.php';

use Tester\Assert,
    Grido\Grid;

class FilterDateTest extends \Tester\TestCase
{
    function testFormControl()
    {
        $grid = new Grid;
        $filter = $grid->addFilterDate('date', 'Date');
        Assert::type('Nette\Forms\Controls\TextInput', $filter->control);
        Assert::same('off', $filter->control->controlPrototype->attrs['autocomplete']);
        Assert::same(['text', 'date'], $filter->control->controlPrototype->class);
    }

    function testGetCondition()
    {
        $grid = new Grid;
        $filter = $grid->addFilterDate('date', 'Date');
        Assert::same(['date = ?', 'TEST'], $filter->__getCondition('TEST')->__toArray());
    }
}

run(__FILE__);
