<?php

namespace Prodtrack\ApiBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * Class Activity
 * @ORM\Entity(repositoryClass="Prodtrack\ApiBundle\Repository\UserRepository")
 * @ORM\Table(name="`users`")
 */
class User
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=128)
     */
    protected $username;

    /**
     * @ORM\Column(type="string", length=128)
     */
    protected $password;

    /**
     * @ORM\Column(type="string", length=128, unique=true)
     */
    protected $email;

    /**
     * @ORM\Column(type="date", name="register_date")
     */
    protected $register_date;

    /**
     * @ORM\Column(type="date", name="last_login", nullable=true)
     */
    protected $last_login;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set username
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     * @param int $cost
     * @return User
     */
    public function setPassword($password, $cost = 10)
    {
        $this->password = password_hash($password, PASSWORD_BCRYPT, array('cost' => $cost));

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set register_date
     *
     * @param \DateTime $registerDate
     * @return User
     */
    public function setRegisterDate($registerDate)
    {
        $this->register_date = $registerDate;

        return $this;
    }

    /**
     * Get register_date
     *
     * @return \DateTime
     */
    public function getRegisterDate()
    {
        return $this->register_date;
    }

    /**
     * Set last_login
     *
     * @param \DateTime $lastLogin
     * @return User
     */
    public function setLastLogin($lastLogin)
    {
        $this->last_login = $lastLogin;

        return $this;
    }

    /**
     * Get last_login
     *
     * @return \DateTime
     */
    public function getLastLogin()
    {
        return $this->last_login;
    }

    public function __construct()
    {
        $this->register_date = new \DateTime();
    }
}
