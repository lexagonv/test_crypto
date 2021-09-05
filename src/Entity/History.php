<?php

namespace App\Entity;

use App\Repository\HistoryRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HistoryRepository::class)
 */
class History
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pairName;
    /**
     * @ORM\Column(type="datetime")
     */
    private $date;
    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    private $high;
    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    private $low;
    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    private $open;
    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    private $close;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getPairName()
    {
        return $this->pairName;
    }

    /**
     * @param mixed $pairName
     * @return History
     */
    public function setPairName($pairName): History
    {
        $this->pairName = $pairName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     * @return History
     */
    public function setDate($date): History
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOpen()
    {
        return $this->open;
    }

    /**
     * @param mixed $open
     * @return History
     */
    public function setOpen($open): History
    {
        $this->open = $open;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getClose()
    {
        return $this->close;
    }

    /**
     * @param mixed $close
     * @return History
     */
    public function setClose($close): History
    {
        $this->close = $close;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getHigh()
    {
        return $this->high;
    }

    /**
     * @param mixed $high
     * @return History
     */
    public function setHigh($high): History
    {
        $this->high = $high;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLow()
    {
        return $this->low;
    }

    /**
     * @param mixed $low
     * @return History
     */
    public function setLow($low): History
    {
        $this->low = $low;
        return $this;
    }
}