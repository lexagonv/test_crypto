<?php

namespace App\Controller;

use App\Service\HistoryService;
use DateTime;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HistoryController extends AbstractController
{
    /**
     * @Route("/history", name="get_history", methods={"POST"})
     * @param HistoryService $historyService
     * @param Request $request
     * @return JsonResponse
     */
    public function getByDates(HistoryService $historyService, Request $request): JsonResponse
    {
        $currency = $request->request->has('currency') ? $request->request->get('currency') : 'usd';
        $from = $request->request->has('from') ? $request->request->get('from') : '';
        $to = $request->request->has('to') ? $request->request->get('to') : '';

        if ($from == '' or $to == '') {
            $response = [
                'success' => false,
                'message' => 'Не указан обязательный параметр.'
            ];

            return new JsonResponse($response);
        }

        try {
            $fromDate = new DateTime($from);
        } catch (Exception $exception) {
            $response = [
                'success' => false,
                'message' => 'Неверный формат даты начала периода.'
            ];

            return new JsonResponse($response);
        }

        try {
            $toDate = new DateTime($to);
        } catch (Exception $exception) {
            $response = [
                'success' => false,
                'message' => 'Неверный формат даты окончания периода.'
            ];

            return new JsonResponse($response);
        }

        $data = $historyService->getData($fromDate, $toDate, $currency);

        if (count($data) > 0) {
            $response = [
                'success' => true,
                'message' => '',
                'data' => $data
            ];

            return new JsonResponse($response);
        }

        $response = [
            'success' => false,
            'message' => 'В заданном периоде данных не найдено.'
        ];

        return new JsonResponse($response);
    }
}