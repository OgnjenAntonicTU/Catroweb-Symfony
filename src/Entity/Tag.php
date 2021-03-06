<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="tags")
 * @ORM\Entity(repositoryClass="App\Repository\TagRepository")
 */
class Tag
{
  /**
   * @ORM\Id
   * @ORM\Column(type="integer")
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  protected $id;

  /**
   * @var Collection|Program[]
   *
   * @ORM\ManyToMany(targetEntity="\App\Entity\Program", mappedBy="tags")
   */
  protected $programs;

  /**
   * @ORM\Column(type="string", nullable=true)
   */
  protected $en;

  /**
   * @ORM\Column(type="string", nullable=true)
   */
  protected $de;

  /**
   * @ORM\Column(type="string", nullable=true)
   */
  protected $it;

  /**
   * @ORM\Column(type="string", nullable=true)
   */
  protected $fr;

  /**
   * Default constructor, initializes collections.
   */
  public function __construct()
  {
    $this->programs = new ArrayCollection();
  }

  public function __toString()
  {
    return $this->id.'';
  }

  /**
   * @return mixed
   */
  public function getId()
  {
    return $this->id;
  }

  public function addProgram(Program $program)
  {
    if ($this->programs->contains($program))
    {
      return;
    }
    $this->programs->add($program);
    $program->addTag($this);
  }

  public function removeProgram(Program $program)
  {
    if (!$this->programs->contains($program))
    {
      return;
    }
    $this->programs->removeElement($program);
    $program->removeTag($this);
  }

  /**
   * @return Program[]|Collection
   */
  public function getPrograms()
  {
    return $this->programs;
  }

  /**
   * @return mixed
   */
  public function getEn()
  {
    return $this->en;
  }

  /**
   * @param mixed $en
   */
  public function setEn($en)
  {
    $this->en = $en;
  }

  /**
   * @return mixed
   */
  public function getDe()
  {
    return $this->de;
  }

  /**
   * @param mixed $de
   */
  public function setDe($de)
  {
    $this->de = $de;
  }

  /**
   * @return mixed
   */
  public function getIt()
  {
    return $this->it;
  }

  /**
   * @param mixed $it
   */
  public function setIt($it)
  {
    $this->it = $it;
  }

  /**
   * @return mixed
   */
  public function getFr()
  {
    return $this->fr;
  }

  /**
   * @param mixed $fr
   */
  public function setFr($fr)
  {
    $this->fr = $fr;
  }
}
