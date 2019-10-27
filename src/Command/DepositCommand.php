<?php

namespace App\Command;

use App\Entity\Account;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ContainerInterface;

class DepositCommand extends Command
{
    /**
     * @var ContainerInterface
     */
    private $container;

    protected static $defaultName = 'Deposit';


    /**
     * DepositCommand constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct();
        $this->container = $container;
    }

    protected function configure()
    {
        $this
            ->setDescription('Adding interest to deposits over 1 day');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     * @throws ORMException
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        //TODO add logs and error handling

        $io = new SymfonyStyle($input, $output);

        /** @var EntityManager $em */
        $em = $this->container->get('doctrine')->getManager();

        //Set deposits availability to 0
        $em->getConnection()->executeUpdate('UPDATE account SET available = 0');

        /** @var $account Account[] */
        $account = $this->container->get('doctrine')
            ->getRepository(Account::class)
            ->findAll()
        ;

        foreach ($account as $acc) {
            $interest = ($acc->getTotal() * 100.01)/100;
            $acc->setTotal($interest);

            $em->persist($acc);
            $em->flush();

            $io->comment('account:'.$acc->getId().' has been updated with interest');
        }

        //Set deposits availability to 1
        $em->getConnection()->executeUpdate('UPDATE account SET available = 1');

        $io->comment('command executed');
    }
}