<?php

namespace App\Service;

use App\Entity\History;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Exception;

class CryptocompareService
{
    const URL = 'https://min-api.cryptocompare.com/data/v2/histohour';

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @throws NonUniqueResultException
     * @throws Exception
     */
    public function loadData($fsym = 'BTC', $tsym = 'USD', $limit = 24)
    {
        $data = [
            'fsym' => $fsym,
            'tsym' => $tsym,
            'limit' => $limit,
            'aggregate' => 1
        ];

        $url = self::URL . '?' . http_build_query($data);

        $response = $this->sendOverCurl($url);

        if (isset($response['Data']['Data']) and $response['Data']['Data']) {
            $pairName = strtolower($fsym . $tsym);
            $lastHistory = $this->entityManager->createQueryBuilder()
                ->select('history.date')
                ->from(History::class, 'history')
                ->orderBy('history.date', 'desc')
                ->where('history.pairName = :pairName')
                ->setParameter('pairName', $pairName)
                ->setMaxResults(1)
                ->getQuery()
                ->getOneOrNullResult();
            foreach ($response['Data']['Data'] as $hourData) {
                $date = new DateTime();
                $date->setTimestamp($hourData['time']);
                if (!$lastHistory or $date > $lastHistory['date']) {
                    $history = new History();
                    $history
                        ->setDate($date)
                        ->setPairName(strtolower($fsym . $tsym))
                        ->setOpen($hourData['open'])
                        ->setClose($hourData['close'])
                        ->setLow($hourData['low'])
                        ->setHigh($hourData['high']);

                    $this->entityManager->persist($history);
                    $this->entityManager->flush();
                }
            }
        }
    }

    public function sendOverCurl($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = json_decode(curl_exec($ch), true);
        curl_close($ch);
        return $response;
    }
}