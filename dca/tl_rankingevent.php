<?php

$GLOBALS['TL_DCA']['tl_rankingevent'] = [
    'config' => [
        'dataContainer' => 'Table',
        'enableVersioning' => true,
        'ptable' => 'tl_ranking',
        'ctable' => ['tl_rankingresult'],
        'sql' => [
            'keys' => [
                'id'  => 'primary',
                'pid' => 'index',
            ],
        ],
    ], // config

    'list' => [
        'sorting' => [
            'mode' => 4, // 4 Displays the child records of a parent record
            'fields' => ['date'],
            'flag' => 1, // 1 == Sort by initial letter ascending
            'panelLayout' => 'filter;search,limit',
            'headerFields' => ['name'],
            'child_record_callback' => function($row) { return \Date::parse('d.m.Y', $row['date']); }
        ],
        'label' => [
            'fields' => ['date'],
            'format' => '%s',
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
                'label' => &$GLOBALS['TL_LANG']['tl_rankingevent']['edit'],
                'href'  => 'table=tl_rankingresult',
                'icon'  => 'edit.gif',
            ],

            'editheader' => [
                'label' => &$GLOBALS['TL_LANG']['tl_rankingevent']['editheader'],
                'href'  => 'act=edit',
                'icon'  => 'header.gif',
            ],
            'copy' => [
                'label' => &$GLOBALS['TL_LANG']['tl_rankingevent']['copy'],
                'href'  => 'act=copy',
                'icon'  => 'copy.gif',
            ],

            'delete' => [
                'label'      => &$GLOBALS['TL_LANG']['tl_rankingevent']['delete'],
                'href'       => 'act=delete',
                'icon'       => 'delete.gif',
                'attributes' => 'onclick="if (!confirm(\''.$GLOBALS['TL_LANG']['MSC']['deleteConfirm'].'\')) return false; Backend.getScrollOffset();"',
            ],

            'show' => [
                'label' => &$GLOBALS['TL_LANG']['tl_rankingevent']['show'],
                'href'  => 'act=show',
                'icon'  => 'show.gif',
            ],
        ], // operations
    ], // list

    'palettes' => [
        '__selector__' => [],
        'default'      => '{title_legend},date',
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

        'date' => [
            'label'     => &$GLOBALS['TL_LANG']['tl_rankingevent']['date'],
            'exclude'   => true,
            'search'    => false,
            'filter'    => true,
            'inputType' => 'text',
            'eval'      => ['tl_class' => 'w50 widget', 'rgxp'=>'date', 'datepicker'=>true, 'maxlength' => 128],
            'flag'      => 7, // Sort by month ascending,
            'sql'       => "varchar(11) NOT NULL default ''",
        ],

    ], // fields

];
