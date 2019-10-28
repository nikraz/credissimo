<?php
/**
 * Created by PhpStorm.
 * User: niki
 * Date: 10/28/19
 * Time: 6:30 PM
 */

namespace App\Validator\Constraints;

use App\Entity\Account;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\UnexpectedResultException;
use Psr\Container\ContainerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;
use Symfony\Component\Validator\Exception\RuntimeException;

class ConstrainsDepositValidator extends ConstraintValidator
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * ConstrainsDepositValidator constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param mixed      $value
     * @param Constraint $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof ConstrainsDeposit) {
            throw new UnexpectedTypeException($constraint, ConstrainsDeposit::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (!is_int($value)) {
            // throw this exception if your validator cannot handle the passed type so that it can be marked as invalid
            throw new UnexpectedValueException($value, 'int');
        }

        /** @var EntityManager $em */
        $em = $this->container->get('doctrine')->getManager();

        /** @var $account Account[] */
        $account = $this->container->get('doctrine')
            ->getRepository(Account::class)
            ->find($value)
        ;

        if (empty($account)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ account_id }}', $value)
                ->atPath('deposit')
                ->addViolation();
        }
    }
}