<?php
/*
 * This file is part of the Mouf package.
 *
 * (c) 2012-2015 David Negrier <david@mouf-php.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */
namespace Mouf\Console;

use Symfony\Component\Console\Helper\Helper;

/**
 * This class is a simple Symfony console HelperSet
 * extended to match Mouf convention about associative arrays.
 *
 */
class HelperSet extends \Symfony\Component\Console\Helper\HelperSet
{

    /**
     * Constructor.
     *
     * @param array<string, Helper> $helpers An array of helper.
     */
    public function __construct(array $helpers = array())
    {
        parent::__construct($helpers);
    }
}
