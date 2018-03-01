<?php

$GLOBALS['TL_DCA']['tl_rankingresult'] = [
    'config' => [
        'dataContainer'    => 'Table',
        'enableVersioning' => true,
        'ptable' => 'tl_rankingevent',
        'sql' => [
            'keys' => [
                'id' => 'primary',
                'pid,name'   => 'unique'
            ],
        ],
    ], // config

    'list' => [
        'sorting' => [
            // Für den Aufruf "als child records" (4) vs "als eigenständige Tabelle (eigener Menüpunkt)" (1)
            'mode' => \Input::get('do')==='ranking.ranking' ? 4 : 1, // 4 Displays the child records of a parent record
            'fields' => ['platz'],
            'flag' => 11, // 11 == Sort ascending
            'disableGrouping' => true,
            'panelLayout' => 'filter;search,limit',
            'headerFields' => ['date'],
            'child_record_callback' => function($row) {
                // Für den Aufruf "als child records"
                $member = \RankingplayerModel::findById($row['name']);
                return sprintf("%d. %s", $row['platz'], $member->name);
            }
        ],
        'label' => [
            'fields' => ['platz', 'name'],
            'format' => '%s. %s',
            // Für den Aufruf als "eigenständige Tabelle"
            'label_callback' => function($row) {
                $member = \RankingplayerModel::findById($row['name']);
                $event = \RankingeventModel::findById($row['pid']);
                $ranking = \RankingModel::findById($event->pid);

                return sprintf("%s, %s: %d. %s",
                    $ranking->name,
                    Date::parse('d.m.Y', $event->date), $row['platz'], $member->name);
            }
        ],
        'global_operations' => [
            'all' => [
                'label'      => &$GLOBALS['TL_LANG']['MSC']['all'],
                'href'       => 'act=select',
                'class'      => 'header_edit_all',
                'attributes' => 'onclick="Backend.getScrollOffset();"',
            ]
        ],
        'operations' => [

            'edit' => [
                'label' => &$GLOBALS['TL_LANG']['tl_rankingresult']['edit'],
                'href'  => 'act=edit',
                'icon'  => 'edit.gif',
            ],

            'copy' => [
                'label' => &$GLOBALS['TL_LANG']['tl_rankingresult']['copy'],
                'href'  => 'act=copy',
                'icon'  => 'copy.gif',
            ],

            'delete' => [
                'label'      => &$GLOBALS['TL_LANG']['tl_rankingresult']['delete'],
                'href'       => 'act=delete',
                'icon'       => 'delete.gif',
                'attributes' => 'onclick="if (!confirm(\''.$GLOBALS['TL_LANG']['MSC']['deleteConfirm'].'\')) return false; Backend.getScrollOffset();"',
            ],

            'show' => [
                'label' => &$GLOBALS['TL_LANG']['tl_rankingresult']['show'],
                'href'  => 'act=show',
                'icon'  => 'show.gif',
            ],
        ], // operations
    ], // list

    'palettes' => [
        '__selector__' => [],
        'default'      => '{title_legend},name,platz',
    ], // palettes

    'fields' => [

        'id' => [
            'sql' => 'int(10) unsigned NOT NULL auto_increment',
        ],

        'pid' => [
            'sql' => "int(10) unsigned NOT NULL default '0'",
        ],

        'tstamp' => [
            'sql' => "int(10) unsigned NOT NULL default '0'",
        ],

        'name' => [
            'label'      => &$GLOBALS['TL_LANG']['tl_rankingresult']['name'],
            'exclude'    => true,
            'search'     => false,
            'filter'     => true,
            'inputType'  => 'select',
            'eval'       => ['doNotCopy'=>true,'tl_class' => 'w50', 'includeBlankOption' => true, 'chosen' => true],
            'foreignKey' => 'tl_rankingplayer.name',
            'sql'        => "int(10) NOT NULL default '0'",
        ],

        'platz' => [
            'label'     => &$GLOBALS['TL_LANG']['tl_rankingresult']['platz'],
            'exclude'   => true,
            'search'    => false,
            'filter'    => true,
            'inputType' => 'text',
            'eval'      => ['tl_class' => 'w50', 'rgxp'=>'natural', 'maxlength' => 128],
            'sql'       => "varchar(128) NOT NULL default ''",
        ],

    ], // fields

];
