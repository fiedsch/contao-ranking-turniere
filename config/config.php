<?php

// Menüpunkte

array_insert($GLOBALS['BE_MOD'], 0,
        [
            'ranking' => [
                'ranking.spieler' => [
                    'tables'     => ['tl_rankingplayer'],
                ],
                'ranking.ranking' => [
                    'tables'     => ['tl_ranking','tl_rankingevent','tl_rankingresult'],
                ],
                'ranking.result' => [
                    'tables'     => ['tl_rankingresult'],
                ]
            ],
        ]
);

// Content Elements

$GLOBALS['TL_CTE']['texts']['rankingranking'] = 'ContentRankingRanking';

// Backend-CSS

//if (TL_MODE === 'BE') {
//    $GLOBALS['TL_CSS'][] = 'bundles/qiscore/qis_be.css';
//}
