<?php
/*
 * This file is part of the Mouf package.
 *
 * (c) 2012-2015 David Negrier <david@mouf-php.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */
namespace Mouf\Console\Command;

use Mouf\MoufManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * A command to force rewriting file mouf/MoufComponents.php
 * Useful after manual editions to ensure indentation, instances order, etc
 */
class MoufRewriteCommand extends Command
{
    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $moufManager = MoufManager::getMoufManager();
        $moufManager->rewriteMouf();
    }
}
