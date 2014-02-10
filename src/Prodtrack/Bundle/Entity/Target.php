<?php

namespace Prodtrack\Bundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Activity
 * @ORM\Entity(repositoryClass="Prodtrack\Bundle\Repository\TargetRepository")
 * @ORM\Table(name="target")
 */
class Target
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\Column(type="date", name="start_date")
     */
    protected $startDate;

    /**
     * @ORM\Column(type="date", name="end_date")
     */
    protected $endDate;


    /**
     * @ORM\Column(type="integer", name="target_minutes")
     */
    protected $targetMinutes;

    /**
     * @ORM\Column(type="integer", name="activity_id")
     */
    protected $activityId;

    /**
     * @ORM\Column(type="integer", name="user_id")
     */
    protected $userId;

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
     * Set startDate
     *
     * @param \DateTime $startDate
     * @return Target
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get startDate
     *
     * @return \DateTime 
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set endDate
     *
     * @param \DateTime $endDate
     * @return Target
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get endDate
     *
     * @return \DateTime 
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set targetMinutes
     *
     * @param integer $targetMinutes
     * @return Target
     */
    public function setTargetMinutes($targetMinutes)
    {
        $this->targetMinutes = $targetMinutes;

        return $this;
    }

    /**
     * Get targetMinutes
     *
     * @return integer 
     */
    public function getTargetMinutes()
    {
        return $this->targetMinutes;
    }

    /**
     * Set activityId
     *
     * @param integer $activityId
     * @return Target
     */
    public function setActivityId($activityId)
    {
        $this->activityId = $activityId;

        return $this;
    }

    /**
     * Get activityId
     *
     * @return integer 
     */
    public function getActivityId()
    {
        return $this->activityId;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     * @return Target
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return integer 
     */
    public function getUserId()
    {
        return $this->userId;
    }
}
