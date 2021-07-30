<?php 

namespace Escape\Console;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;
use Exception;

class AppInstallCommand extends BaseCommand 
{
    /**
     * Configure the command options.
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName('app:install')
             ->setDescription('Create a new laravel application by the Escape Boilerplate.')
             ->addArgument('name', InputArgument::REQUIRED)
             ->addOption('--type', null, InputOption::VALUE_OPTIONAL, 'laravel or html', 'laravel')
             ->addOption('--with-manager', null, InputOption::VALUE_NONE)
             ->addOption('--sudo', null, InputOption::VALUE_NONE);
    }

    /**
     * Execute the command.
     *
     * @param  InputInterface  $input
     * @param  OutputInterface  $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->setInputInterface($input);
        $this->setOutputInterface($output);
        
        $this->verifyApplicationDoesntExist($directory = getcwd().'/'.$input->getArgument('name'));

        $this->info('Crafting application...');

        $this->cloneRepo($directory);
        $this->createDotEnv();
        $this->bootstrap($directory);
        $this->createReadme();

        # manager
        if ($input->getOption('with-manager')) {
            $this->comment(' -> Installing escapework/manager... This may take a while...');

            $command = $this->getApplication()->find('manager:install');
            $input   = new ArrayInput(['command' => 'manager:install']);
            $code = $command->run($input, $output);

            if ($code == 0) {
                $this->info(' -> escapework/manager successfully installed!');
            }
        }

        $this->comment('Application ready! Go build something amazing.');
    }

    /**
     * Verify that the application does not already exist.
     *
     * @param  string  $directory
     * @return void
     */
    protected function verifyApplicationDoesntExist($directory)
    {
        if (is_dir($directory)) {
            $this->error(' -> Application already exists!!!');
            exit(1);
        }
    }

    protected function cloneRepo($directory)
    {
        if ($this->input->getOption('type') === 'html') {
            $this->comment(' -> Cloning the EscapeWork/html-boilerplate repository...');
            $this->executeCommand('git clone git@github.com:EscapeWork/html-boilerplate.git ' . $this->input->getArgument('name'));
        } else {
            $this->comment(' -> Cloning the EscapeWork/LaravelBoilerplate repository...');
            $this->executeCommand('git clone git@github.com:EscapeWork/LaravelBoilerplate.git ' . $this->input->getArgument('name'));
        }

        chdir($directory);
    }

    protected function bootstrap($directory)
    {
        if (is_file('package.json')) {
            $this->comment(' -> Installing npm dependencies...');
            $this->executeCommand($this->input->getOption('sudo') ? 'sudo npm install' : 'npm install');
        }

        if (is_file('composer.json')) {
            $this->comment(' -> Installing composer dependencies...');
            $this->executeCommand('composer install');
        }

        if (is_file('artisan')) {
            $this->comment(' -> Generating laravel key...');
            $this->executeCommand('php artisan key:generate');
        }

        if (is_dir('.git')) {
            $this->comment(' -> Removing .git directory...');
            $this->executeCommand('rm -rf .git');

            $this->comment(' -> Initializing a new .git directory...');
            $this->executeCommand('git init');
        }

        if (is_dir('storage')) {
            $this->comment(' -> Dando permissão de escrita no diretório storage...');
            $this->executeCommand('chmod -R 777 storage');
        }
    }

    protected function createReadme()
    {
        $file = fopen('readme.md', 'w');
        ftruncate($file, 0);
        fwrite($file, file_get_contents('https://gist.githubusercontent.com/luisdalmolin/b90f23bb0fc068c6e805/raw/readme.md'));
        fclose($file);
    }

    protected function createDotEnv()
    {
        $file = fopen('.env', 'w');
        ftruncate($file, 0);
        fwrite($file, file_get_contents('https://gist.githubusercontent.com/luisdalmolin/b90f23bb0fc068c6e805/raw/.env'));
        fclose($file);
    }
}