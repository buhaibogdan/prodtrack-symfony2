<?php


namespace Prodtrack\Bundle\Services;


use Prodtrack\Bundle\Repository\TargetRepository;

class TargetCollectionService
{
    private $targetRepository;

    public function __construct(TargetRepository $tr)
    {
        $this->targetRepository = $tr;
    }

    public function getTargetCollection($userId, $startDate, $endDate)
    {
        $start = new \DateTime($startDate);
        $end = new \DateTime($endDate);
        $targets = $this->targetRepository->getTargetsBetweenDates($userId, $start, $end);
        $targetItems = array();

        foreach ($targets as $target) {
            $targetItems[] = array(
                'data' => array(
                    array(
                        'name' => 'activity-name',
                        'value' => $target['name']
                    ),
                    array(
                        'name' => 'start-date',
                        'value' => $target['startDate']
                    ),
                    array(
                        'name' => 'end-date',
                        'value' => $target['endDate']
                    ),
                    array(
                        'name' => 'target-minutes',
                        'value' => $target['targetMinutes']
                    ),
                    array(
                        'name' => 'actual-minutes',
                        'value' => $target[1]
                    )
                ),
                'links' => array(
                    array(
                        'rel' => 'logs',
                        'href' => '/activity/' . $target['activityId'] . '/logs'
                    )
                )
            );
        }

        $collection = array(
            'collection' => array(
                'version' => "1.0",
                'href' => '/status?userId=' . $userId . '&startDate=' . $startDate . '&endDate=' . $endDate,
                'items' => $targetItems
            )
        );
        return json_encode($collection);
    }
}