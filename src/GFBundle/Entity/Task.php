<?php

namespace GFBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Task
 *
 * @ORM\Table(name="task")
 * @ORM\Entity
 */
class Task
{
    /**
     * @var string
     *
     * @ORM\Column(name="phid", type="string", length=64, nullable=false)
     */
    private $phid;

    /**
     * @var string
     *
     * @ORM\Column(name="author", type="string", length=64, nullable=false)
     */
    private $author;

    /**
     * @var string
     *
     * @ORM\Column(name="owner", type="string", length=64, nullable=false)
     */
    private $owner;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=64, nullable=false)
     */
    private $status;

    /**
     * @var integer
     *
     * @ORM\Column(name="title", type="integer", nullable=false)
     */
    private $title;

    /**
     * @var integer
     *
     * @ORM\Column(name="description", type="integer", nullable=false)
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="dateCreated", type="integer", nullable=false)
     */
    private $datecreated;

    /**
     * @var integer
     *
     * @ORM\Column(name="dateModified", type="integer", nullable=false)
     */
    private $datemodified;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set phid
     *
     * @param string $phid
     *
     * @return Task
     */
    public function setPhid($phid)
    {
        $this->phid = $phid;

        return $this;
    }

    /**
     * Get phid
     *
     * @return string
     */
    public function getPhid()
    {
        return $this->phid;
    }

    /**
     * Set author
     *
     * @param string $author
     *
     * @return Task
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set owner
     *
     * @param string $owner
     *
     * @return Task
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * Get owner
     *
     * @return string
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Task
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set title
     *
     * @param integer $title
     *
     * @return Task
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return integer
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param integer $description
     *
     * @return Task
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return integer
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set datecreated
     *
     * @param integer $datecreated
     *
     * @return Task
     */
    public function setDatecreated($datecreated)
    {
        $this->datecreated = $datecreated;

        return $this;
    }

    /**
     * Get datecreated
     *
     * @return integer
     */
    public function getDatecreated()
    {
        return $this->datecreated;
    }

    /**
     * Set datemodified
     *
     * @param integer $datemodified
     *
     * @return Task
     */
    public function setDatemodified($datemodified)
    {
        $this->datemodified = $datemodified;

        return $this;
    }

    /**
     * Get datemodified
     *
     * @return integer
     */
    public function getDatemodified()
    {
        return $this->datemodified;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}