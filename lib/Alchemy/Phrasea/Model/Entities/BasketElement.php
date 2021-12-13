<?php

/*
 * This file is part of Phraseanet
 *
 * (c) 2005-2014 Alchemy
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Alchemy\Phrasea\Model\Entities;

use Alchemy\Phrasea\Application;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use Gedmo\Mapping\Annotation as Gedmo;
use record_adapter;

/**
 * @ORM\Table(name="BasketElements", uniqueConstraints={@ORM\UniqueConstraint(name="unique_recordcle", columns={"basket_id","sbas_id","record_id"})})
 * @ORM\Entity(repositoryClass="Alchemy\Phrasea\Model\Repositories\BasketElementRepository")
 */
class BasketElement
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $record_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $sbas_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $ord;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updated;

    /**
     * @ORM\OneToMany(targetEntity="BasketElementVote", mappedBy="basket_element", cascade={"all"})
     */
    private $votes;

    /**
     * @ORM\ManyToOne(targetEntity="Basket", inversedBy="elements", cascade={"persist"})
     * @ORM\JoinColumn(name="basket_id", referencedColumnName="id")
     */
    private $basket;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->votes = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set record_id
     *
     * @param integer $recordId
     * @return BasketElement
     */
    public function setRecordId(int $recordId): BasketElement
    {
        $this->record_id = $recordId;

        return $this;
    }

    /**
     * Get record_id
     *
     * @return integer
     */
    public function getRecordId(): int
    {
        return $this->record_id;
    }

    /**
     * Set sbas_id
     *
     * @param integer $sbasId
     * @return self
     */
    public function setSbasId(int $sbasId): BasketElement
    {
        $this->sbas_id = $sbasId;

        return $this;
    }

    /**
     * Get sbas_id
     *
     * @return integer
     */
    public function getSbasId(): int
    {
        return $this->sbas_id;
    }

    public function getRecord(Application $app): record_adapter
    {
        return new record_adapter($app, $this->getSbasId(), $this->getRecordId(), $this->getOrd());
    }

    public function setRecord(record_adapter $record)
    {
        $this->setRecordId($record->getRecordId());
        $this->setSbasId($record->getDataboxId());
    }

    /**
     * Set ord
     *
     * @param integer $ord
     * @return self
     */
    public function setOrd(int $ord): BasketElement
    {
        $this->ord = $ord;

        return $this;
    }

    /**
     * Get ord
     *
     * @return integer
     */
    public function getOrd(): int
    {
        return $this->ord;
    }

    /**
     * Set created
     *
     * @param  DateTime     $created
     * @return self
     */
    public function setCreated(DateTime $created): BasketElement
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return DateTime
     */
    public function getCreated(): DateTime
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param  DateTime     $updated
     * @return self
     */
    public function setUpdated(DateTime $updated): BasketElement
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return DateTime
     */
    public function getUpdated(): DateTime
    {
        return $this->updated;
    }

    /**
     * Add vote
     *
     * @param  BasketElementVote $vote
     * @return self
     */
    public function addVote(BasketElementVote $vote): BasketElement
    {
        $this->votes[] = $vote;

        return $this;
    }

    /**
     * Remove vote
     *
     * @param BasketElementVote $vote
     */
    public function removeVote(BasketElementVote $vote)
    {
        $this->votes->removeElement($vote);
    }

    /**
     * Get votes
     *
     * @return ArrayCollection|BasketElementVote[]
     */
    public function getVotes()
    {
        return $this->votes;
    }

    /**
     * Set basket
     *
     * @param  Basket        $basket
     * @return BasketElement
     */
    public function setBasket(Basket $basket = null): BasketElement
    {
        $this->basket = $basket;

        return $this;
    }

    /**
     * Get basket
     *
     * @return Basket
     */
    public function getBasket(): Basket
    {
        return $this->basket;
    }

    /**
     * create a vote data for a participant on this element (unique)
     *
     * @param BasketParticipant $participant
     * @return BasketElementVote
     */
    public function createVote(BasketParticipant $participant): BasketElementVote
    {
        // !!!!!!!!!!!!!!!!!!!!!!!!!! persist ?
        $bev = new BasketElementVote($participant, $this);
        $participant->addVote($bev);

        return $bev;
    }

    /**
     * @param User $user
     * @param bool $createIfMissing
     * @return BasketElementVote
     * @throws Exception
     */
    public function getUserVote(User $user, bool $createIfMissing): BasketElementVote
    {
        // ensure the user is a participant
        $participant = $this->getBasket()->getParticipant($user);

        foreach ($this->getVotes() as $vote) {
            if ($vote->getParticipant()->getId() == $participant->getId()) {
                return $vote;
            }
        }
        if($createIfMissing) {
            return $this->createVote($participant);
        }

        throw new Exception('There is no such participant ' . $user->getEmail());
    }
}
