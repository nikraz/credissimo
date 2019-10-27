<?php
/**
 * Created by PhpStorm.
 * User: niki
 * Date: 10/27/19
 * Time: 6:51 PM
 */

namespace App\Controller;

use App\Entity\Account;
use App\Entity\Deposit;
use App\Form\DepositFromType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DepositController extends AbstractController
{
    /**
     * @Route("/deposit", name="deposit_make")
     * @param Request $request
     *
     * @return Response
     */
    public function register(Request $request)
    {
        $form = $this->createForm(DepositFromType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Deposit $deposit */
            $deposit = $form->getData();

            /** @var Account $acc */
            $acc = $this->getDoctrine()->getRepository(Account::class)->find( $deposit->getAccountId());
            $total = $acc->getTotal();
            $available = $acc->getAvailable();
            if($available){
                //generate current date
                 $date = new \DateTime();
                $date->setTimestamp(time());

                $deposit->setAmount($deposit->getAmount());
                $deposit->setAccountId($deposit->getAccountId());
                $deposit->setCreatedAt($date);
                $em = $this->getDoctrine()->getManager();
                $em->persist($deposit);
                $em->flush();

                $total = $total + $deposit->getAmount();
                $acc->setTotal($total);
                $acc->setUpdatedAt($date);
                $em->persist($acc);
                $em->flush();
            } else {
                $form->addError(new FormError('Not available for deposit at the moment, please retry later.'));
            }

         }
        return $this->render('deposit/create_deposit.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
