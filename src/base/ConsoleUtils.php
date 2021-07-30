<?php
namespace Mouf\Console;

use Mouf\MoufInstanceDescriptor;
use Mouf\MoufManager;

class ConsoleUtils
{

    /**
     * @var MoufManager
     */
    private $moufManager;

    public function __construct(MoufManager $moufManager)
    {
        $this->moufManager = $moufManager;
    }

    /**
     * Registers a new command
     * @param  MoufInstanceDescriptor $commandDescriptor
     * @param  bool                   $avoidDuplicateClass If true and if $commandDescriptor as a descriptor of a class already added,
     *                                                     nothing is done.
     * @throws \Mouf\MoufException
     */
    public function registerCommand(MoufInstanceDescriptor $commandDescriptor, $avoidDuplicateClass = true)
    {
        $console = $this->moufManager->getInstanceDescriptor('console');
        $commands = $console->getSetterProperty('setCommands')->getValue();
        
        if(!is_array($commands)) {
            $commands = array();
        }

        if ($avoidDuplicateClass) {
            foreach ($commands as $command) {
                /* @var $command MoufInstanceDescriptor */
                if ($command->getClassName() == $commandDescriptor->getClassName()) {
                    return;
                }
            }
        }

        $commands[] = $commandDescriptor;

        $console->getSetterProperty('setCommands')->setValue($commands);
    }

    /**
     * @param  MoufInstanceDescriptor $helperDescriptor
     * @param  string                 $key
     * @throws \Mouf\MoufException
     */
    public function registerHelper(MoufInstanceDescriptor $helperDescriptor, $key)
    {
        $helperSet = $this->moufManager->getInstanceDescriptor('helperSet');

        $helpers = $helperSet->getConstructorArgumentProperty('helpers')->getValue();
        $helpers[$key] = $helperDescriptor;
        $helperSet->getConstructorArgumentProperty('helpers')->setValue($helpers);
    }
}
