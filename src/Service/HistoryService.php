<?php

namespace App\Service;

use App\Entity\History;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

class HistoryService
{
    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    public function getData(DateTime $from, DateTime $to, $currency = 'usd')
    {
        $pairName = 'btc' . strtolower($currency);
        $historyData = $this->em->getRepository(History::class)->getDataByDates($from, $to, $pairName);
        $data = [];
        /** @var History $history */
        foreach ($historyData as $history) {
            $data[] = [
                'date' => $history->getDate()->format('d.m.Y H:i:s'),
                'high' => $history->getHigh(),
                'low' => $history->getLow(),
                'open' => $history->getOpen(),
                'close' => $history->getClose()
            ];
        }
        return $data;
    }
}