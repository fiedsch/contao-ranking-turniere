<?php

/**
 * Register the namespaces
 */
ClassLoader::addNamespaces([
    'Fiedsch\Ranking',
]);

ClassLoader::addClasses([
    // Elements
    'ContentRankingRanking'         => 'system/modules/ranking/elements/ContentRankingRanking.php',

    // Models
    'RankingModel'                  => 'system/modules/ranking/models/RankingModel.php',
    'RankingeventModel'             => 'system/modules/ranking/models/RankingeventModel.php',
    'RankingresultModel'            => 'system/modules/ranking/models/RankingresultModel.php',
    'RankingplayerModel'            => 'system/modules/ranking/models/RankingplayerModel.php',

]);

TemplateLoader::addFiles([
    'ce_rankingranking'           => 'system/modules/ranking/templates',
]);
