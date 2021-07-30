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

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\HelperSet as SymfonyHelperSet;

/**
 * This class is a simple Symfony based console application
 * extended to match Mouf convention about setters.
 *
 */
class ConsoleApplication extends Application
{

    /**
     * Set a helper set to be used with the command.
     *
     *
     * @param HelperSet $helperSet The helper set
     *
     * @api
     */
    public function setHelperSet(SymfonyHelperSet $helperSet)
    {
        // Only redeclared here to be above setCommands (it must be executed before!)
        parent::setHelperSet($helperSet);
    }

    /**
     * Simple alias to 'addCommands' so that we can use the Mouf UI.
     * @param Command[] $commands
     */
    public function setCommands(array $commands)
    {
        $this->addCommands($commands);
    }
}
