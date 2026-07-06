<?php

namespace App\Command;

use App\Service\Manager\UserManager;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'db:admin:create',
    description: 'Create a new admin user.'
)]
class CreateAdminCommand extends Command
{
    private UserManager $userManager;

    public function __construct(UserManager $userManager, ?string $name = null)
    {
        $this->userManager = $userManager;
        parent::__construct($name);
    }

    public function configure(): void
    {
        $this->addArgument('emailAddress', InputArgument::REQUIRED);
        $this->addArgument('password', InputArgument::REQUIRED);
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $emailAddress = $input->getArgument('emailAddress');
        $password = $input->getArgument('password');
        $this->userManager->createAdminUser($emailAddress, $password);
        return Command::SUCCESS;
    }
}
