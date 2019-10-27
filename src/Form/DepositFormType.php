<?php
/**
 * Created by PhpStorm.
 * User: niki
 * Date: 10/27/19
 * Time: 7:22 PM
 */


namespace AppBundle\Form;

use App\Entity\Deposit;
use Doctrine\DBAL\Types\DecimalType;
use Doctrine\DBAL\Types\IntegerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DepositFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('clientID', IntegerType::class)
            ->add('accountID', IntegerType::class)
            ->add('amount', DecimalType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Deposit::class,
        ]);
    }
}
