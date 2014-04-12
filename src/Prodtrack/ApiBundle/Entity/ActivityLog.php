<?php

namespace Prodtrack\ApiBundle\Entity;
use Doctrine\ORM\Mapping as ORM;


/**
 * Class Activity
 * @ORM\Entity(repositoryClass="Prodtrack\ApiBundle\Repository\ActivityLogRepository")
 * @ORM\Table(name="activity_log")
 */
class ActivityLog
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\Column(type="date", name="log_date")
     */
    protected $logDate;

    /**
     * @ORM\Column(type="integer")
     */
    protected $minutes;

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
     * Set logDate
     *
     * @param \DateTime $logDate
     * @return ActivityLog
     */
    public function setLogDate($logDate)
    {
        $this->logDate = $logDate;

        return $this;
    }

    /**
     * Get logDate
     *
     * @return \DateTime
     */
    public function getLogDate()
    {
        return $this->logDate;
    }

    /**
     * Set minutes
     *
     * @param integer $minutes
     * @return ActivityLog
     */
    public function setMinutes($minutes)
    {
        $this->minutes = $minutes;

        return $this;
    }

    /**
     * Get minutes
     *
     * @return integer
     */
    public function getMinutes()
    {
        return $this->minutes;
    }

    /**
     * Set activityId
     *
     * @param integer $activityId
     * @return ActivityLog
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
     * @return ActivityLog
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
