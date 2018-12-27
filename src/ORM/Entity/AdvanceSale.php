<?php
/**
 * AdvanceSale.php
 * 
 * @author Atsushi Okui <okui@motionpicture.jp>
 */

namespace Toei\Portal\ORM\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;

/**
 * AdvanceSale entity class
 * 
 * @ORM\Entity
 * @ORM\Table(name="advance_sale", options={"collate"="utf8mb4_general_ci"})
 * @ORM\HasLifecycleCallbacks
 */
class AdvanceSale extends AbstractEntity
{
    use SavedUserTrait;
    use SoftDeleteTrait;
    use TimestampableTrait;
    
    /**
     * id
     * 
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer", options={"unsigned"=true})
     * @ORM\GeneratedValue
     */
    protected $id;
    
    /**
     * theater
     * 
     * @var Theater
     * @ORM\ManyToOne(targetEntity="Theater")
     * @ORM\JoinColumn(name="theater_id", referencedColumnName="id", onDelete="RESTRICT")
     */
    protected $theater;
    
    /**
     * title
     *
     * @var Title
     * @ORM\ManyToOne(targetEntity="Title")
     * @ORM\JoinColumn(name="title_id", referencedColumnName="id", onDelete="RESTRICT")
     */
    protected $title;
    
    /**
     * publishing_expected_date
     *
     * @var \DateTime|null
     * @ORM\Column(type="date", name="publishing_expected_date", nullable=true)
     */
    protected $publishingExpectedDate;
    
    /**
     * publishing_expected_date_text
     *
     * @var string
     * @ORM\Column(type="string", name="publishing_expected_date_text", nullable=true)
     */
    protected $publishingExpectedDateText;
    
    /**
     * advance_tickets
     *
     * @var Collection
     * @ORM\OneToMany(targetEntity="AdvanceTicket", mappedBy="advanceSale", indexBy="id")
     */
    protected $advanceTickets;
    
    
    /**
     * construct
     * 
     * @throws \LogicException
     */
    public function __construct()
    {
        throw new \LogicException('Not allowed.');
    }
    
    /**
     * get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * get tehater
     *
     * @return Theater
     */
    public function getTheater()
    {
        return $this->theater;
    }
    
    /**
     * set theater
     *
     * @param Theater $theater
     * @return void
     * @throws \LogicException
     */
    public function setTheater(Theater $theater)
    {
        throw new \LogicException('Not allowed.');
    }
    
    /**
     * get title
     *
     * @return Title
     */
    public function getTitle()
    {
        return $this->title;
    }
    
    /**
     * set title
     *
     * @param Title $title
     * @return void
     * @throws \LogicException
     */
    public function setTitle(Title $title)
    {
        throw new \LogicException('Not allowed.');
    }
    
    /**
     * get publishing_expected_date
     *
     * @return \DateTime|null
     */
    public function getPublishingExpectedDate()
    {
        return $this->publishingExpectedDate;
    }
    
    /**
     * set publishing_dxpected_date
     *
     * @param \DateTime|string|null $publishingExpectedDate
     * @return void
     * @throws \LogicException
     */
    public function setPublishingExpectedDate($publishingExpectedDate)
    {
        throw new \LogicException('Not allowed.');
    }
    
    /**
     * get publishing_expected_date_text
     *
     * @return string
     */
    public function getPublishingExpectedDateText()
    {
        return $this->publishingExpectedDateText;
    }
    
    /**
     * set publishing_expected_date_text
     *
     * @param string $publishingExpectedDateText
     * @return void
     * @throws \LogicException
     */
    public function setPublishingExpectedDateText(string $publishingExpectedDateText)
    {
        throw new \LogicException('Not allowed.');
    }
    
    /**
     * get advance_tickets
     *
     * @return Collection
     */
    public function getAdvanceTickets()
    {
        return $this->advanceTickets;
    }
}
