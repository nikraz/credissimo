<?php
/**
 * Description of Account
 *
 * @author niki
 */
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Query\Expr\Base;

/**
 * @ORM\Entity
 */
class Account extends Base
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\OneToMany(targetEntity="App\Entity\Deposit", mappedBy="accountId")
     */
    private $id;

    /**
     * @ORM\Column(name="total", type="decimal", precision=4)
     */
    private $total;

    /**
     * @ORM\Column(name="client_id", type="integer")
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="id")
     * @ORM\JoinColumn(name="client_id", referencedColumnName="id")
     */
    private $clientId;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param mixed $total
     */
    public function setTotal($total)
    {
        $this->total = $total;
    }

    /**
     * @return mixed
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * @param mixed $clientId
     */
    public function setClientId($clientId)
    {
        $this->clientId = $clientId;
    }

}