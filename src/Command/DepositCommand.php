<?php

namespace App\Command;

use App\Entity\Account;
use App\Entity\Deposit;
use App\Util\InterestCalculator;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\ControllerTrait;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Symfony\Component\HttpClient\HttpClient;

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
     * @param InputInterface $input
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

        $date = date('Y-m-d h:i:s', strtotime("-1 days"));

        $dailyInterest = 0;
        $interestCalculator = new InterestCalculator();

        foreach ($account as $acc) {

            $interest = $interestCalculator->calculateInterest($acc->getTotal());
            $dailyInterest += $interest;

            $withInterest = $acc->getTotal() + $interest;
            $acc->setTotal($withInterest);

            $em->persist($acc);
            $em->flush();

            $io->comment('account:'.$acc->getId().' has been updated with interest');
        }

        //Set deposits availability to 1
        $em->getConnection()->executeUpdate('UPDATE account SET available = 1');

        $latestDeposits = $em->getRepository('App\Entity\Deposit')
            ->createQueryBuilder('e')
            ->select('SUM(e.amount) as sum')
            ->where('e.createdAt > :n1days')
            ->setParameter('n1days', $date)
            ->getQuery()
            ->getResult()
        ;

        $summedDeposits = $latestDeposits[0]['sum'];

        //Load TWIG and use to render the report
        $loader = new FilesystemLoader(__DIR__.'/../../templates/deposit');
        /** @var ControllerTrait $twig */
        $twig = new Environment($loader);

        //HTTP client
        $client = HttpClient::create();

        $response = $client->request(
            'GET',
            'http://data.fixer.io/api/latest?access_key=0d52da9f2090212bec148d7cd9d858b1'
        );

        //TODO make client class and handle statuses and responses there and logs
        $statusCode = $response->getStatusCode();

        $content = $response->toArray();

        $eurToBgn = $content['rates']['BGN'];
        $eurToUsd = $content['rates']['USD'];
        $bgnToUsd = $eurToUsd / $eurToBgn;


        $dailyInterest = $dailyInterest * $bgnToUsd;
        $summedDeposits = $summedDeposits * $bgnToUsd;

        $htmlReport = $twig->render(
            'create_deposit_report.html.twig',
            [
                'interest' => $dailyInterest,
                'deposit' => $summedDeposits,
            ]
        );

        file_put_contents(__DIR__.'/../../public/reports/report_'.date('Y-m-d', time()).'.html', $htmlReport);

        $io->comment('Report url: http://localhost/reports/report_'.date('Y-m-d', time()).'.html');
        $io->comment('command executed');
    }
}