<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="program_remix_backward_relation")
 * @ORM\Entity(repositoryClass="App\Repository\ProgramRemixBackwardRepository")
 */
class ProgramRemixBackwardRelation implements ProgramRemixRelationInterface, ProgramCatrobatRemixRelationInterface
{
  /**
   * -----------------------------------------------------------------------------------------------------------------
   * NOTE: this entity uses a Doctrine workaround in order to allow using foreign keys as primary keys.
   *
   * @link{http://stackoverflow.com/questions/6383964/primary-key-and-foreign-key-with-doctrine-2-at-the-same-time}
   * -----------------------------------------------------------------------------------------------------------------
   */

  /**
   * @ORM\Id
   * @ORM\Column(type="guid")
   */
  protected $parent_id;

  /**
   * @ORM\ManyToOne(targetEntity="\App\Entity\Program", inversedBy="catrobat_remix_backward_child_relations",
   * fetch="LAZY")
   * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
   *
   * @var Program
   */
  protected $parent;

  /**
   * @ORM\Id
   * @ORM\Column(type="guid")
   */
  protected $child_id;

  /**
   * @ORM\ManyToOne(targetEntity="\App\Entity\Program", inversedBy="catrobat_remix_backward_parent_relations",
   * fetch="LAZY")
   * @ORM\JoinColumn(name="child_id", referencedColumnName="id")
   *
   * @var Program
   */
  protected $child;

  /**
   * @ORM\Column(type="datetime")
   */
  protected $created_at;

  /**
   * @var \DateTime
   * @ORM\Column(type="datetime", nullable=true)
   */
  protected $seen_at;

  public function __construct(Program $parent, Program $child)
  {
    $this->setParent($parent);
    $this->setChild($child);
    $this->created_at = null;
    $this->seen_at = null;
  }

  /**
   * @return string
   */
  public function __toString()
  {
    return '(#'.$this->parent_id.', #'.$this->child_id.')';
  }

  /**
   * @ORM\PrePersist
   *
   * @throws \Exception
   */
  public function updateTimestamps()
  {
    if (null == $this->getCreatedAt())
    {
      $this->setCreatedAt(new \DateTime());
    }
  }

  /**
   * @return $this
   */
  public function setParent(Program $parent)
  {
    $this->parent = $parent;
    $this->parent_id = $parent->getId();

    return $this;
  }

  /**
   * @return Program
   */
  public function getParent()
  {
    return $this->parent;
  }

  /**
   * @return int
   */
  public function getParentId()
  {
    return $this->parent_id;
  }

  /**
   * @return $this
   */
  public function setChild(Program $child)
  {
    $this->child = $child;
    $this->child_id = $child->getId();

    return $this;
  }

  /**
   * @return Program
   */
  public function getChild()
  {
    return $this->child;
  }

  /**
   * @return int
   */
  public function getChildId()
  {
    return $this->child_id;
  }

  /**
   * @return int
   */
  public function getDepth()
  {
    return 1;
  }

  /**
   * @return \DateTime
   */
  public function getCreatedAt()
  {
    return $this->created_at;
  }

  /**
   * @return $this
   */
  public function setCreatedAt(\DateTime $created_at)
  {
    $this->created_at = $created_at;

    return $this;
  }

  /**
   * @return \DateTime
   */
  public function getSeenAt()
  {
    return $this->seen_at;
  }

  /**
   * @param \DateTime $seen_at
   *
   * @return $this
   */
  public function setSeenAt($seen_at)
  {
    $this->seen_at = $seen_at;

    return $this;
  }

  /**
   * @return string
   */
  public function getUniqueKey()
  {
    return sprintf('ProgramRemixBackwardRelation(%d,%d)', $this->parent_id, $this->child_id);
  }

  /**
   * @return Program
   */
  public function getAncestor()
  {
    return $this->parent;
  }

  /**
   * @return Program
   */
  public function getDescendant()
  {
    return $this->child;
  }
}
