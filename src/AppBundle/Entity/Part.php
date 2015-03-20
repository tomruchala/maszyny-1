<?php

namespace AppBundle\Entity;


use AppBundle\Entity\Project;
use AppBundle\Entity\PartRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\GroupSequenceProviderInterface;


/**
 * @ORM\Table(name="part")
 * @ORM\Entity(repositoryClass="PartRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Part extends BaseEntity implements GroupSequenceProviderInterface
{

    /** 
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")     
     */
    private $id;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="parent_id", type="integer", nullable=true)
     */
    private $parentId;

    
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=500, nullable=false)
     */
    private $name;
  

    /**
     * @var \AppBundle\Entity\User
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\User", inversedBy="parts")
     * 
     */
    private $user;

    /**
     * @var \AppBundle\Entity\User
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\Project", inversedBy="parts")
     */
    private $project;

    /**
     * Set parentId
     *
     * @param integer $parentId
     * @return Part
     */
    public function setParentId($parentId)
    {
        $this->parentId = $parentId;

        return $this;
    }

    /**
     * Get parentId
     *
     * @return integer 
     */
    public function getParentId()
    {
        return $this->parentId;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Part
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
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

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     * @return Part
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set project
     *
     * @param \AppBundle\Entity\Project $project
     * @return Part
     */
    public function setProject(Project $project = null)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * Get project
     *
     * @return \AppBundle\Entity\Project 
     */
    public function getProject()
    {
        return $this->project;
    }

    public function getGroupSequence()
    {
        return array('add', 'update');
    }

}