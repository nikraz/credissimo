<?php
/**
 * Description of Client
 *
 * @author niki
 */
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Query\Expr\Base;

/**
 * @ORM\Entity
 */
class Client extends Base
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\OneToMany(targetEntity="App\Entity\Account", mappedBy="clientId")
     */
    private $id;

    /**
     * @ORM\Column(name="name", type="string")
     */
    private $name;

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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

}