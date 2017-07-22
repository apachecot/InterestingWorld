<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * LocationRating
 *
 * @ORM\Table(name="location_rating", indexes={@ORM\Index(name="id_location", columns={"location_id"}), @ORM\Index(name="id_user", columns={"user_id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LocationRatingRepository")
 */
class LocationRating
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;

    /**
     * @var \AppBundle\Entity\Location
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Location")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="location_id", referencedColumnName="id")
     * })
     */
    private $location;

    /**
     * @var integer
     *
     * @ORM\Column(name="score", type="integer")
     * @Assert\GreaterThanOrEqual(0)
     * @Assert\LessThanOrEqual(5)
     */
    private $score;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return Location
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param Location $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

    /**
     * @return int
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * @param int $score
     */
    public function setScore($score)
    {
        $this->score = $score;
    }
}

