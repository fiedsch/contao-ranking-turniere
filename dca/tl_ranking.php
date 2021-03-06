<?php

$GLOBALS['TL_DCA']['tl_ranking'] = [
    'config' => [
        'dataContainer' => 'Table',
        'enableVersioning' => true,
        'ctable' => ['tl_rankingevent'],
        'sql' => [
            'keys' => [
                'id'  => 'primary',
                'name' => 'unique',
            ],
        ],
    ], // config

    'list' => [
        'sorting' => [
            'mode' => 2,
            'fields' => ['name'],
            'flag' => 1, // 1 == Sort by initial letter ascending
            'panelLayout' => 'sort,filter;search,limit',
            'headerFields' => ['name'],
        ],
        'label' => [
            'fields' => ['name'],
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
                'label' => &$GLOBALS['TL_LANG']['tl_ranking']['edit'],
                'href'  => 'table=tl_rankingevent',
                'icon'  => 'edit.gif',
            ],

            'editheader' => [
                'label' => &$GLOBALS['TL_LANG']['tl_ranking']['editheader'],
                'href'  => 'act=edit',
                'icon'  => 'header.gif',
            ],

            'copy' => [
                'label' => &$GLOBALS['TL_LANG']['tl_ranking']['copy'],
                'href'  => 'act=copy',
                'icon'  => 'copy.gif',
            ],

            'delete' => [
                'label'      => &$GLOBALS['TL_LANG']['tl_ranking']['delete'],
                'href'       => 'act=delete',
                'icon'       => 'delete.gif',
                'attributes' => 'onclick="if (!confirm(\''.$GLOBALS['TL_LANG']['MSC']['deleteConfirm'].'\')) return false; Backend.getScrollOffset();"',
            ],

            'show' => [
                'label' => &$GLOBALS['TL_LANG']['tl_ranking']['show'],
                'href'  => 'act=show',
                'icon'  => 'show.gif',
            ],
        ], // operations
    ], // list

    'palettes' => [
        '__selector__' => [],
        'default'      => '{title_legend},name',
    ], // palettes

    'fields' => [

        'id' => [
            'sql' => 'int(10) unsigned NOT NULL auto_increment',
        ],

        'tstamp' => [
            'sql' => "int(10) unsigned NOT NULL default '0'",
        ],

        'name' => [
            'label'     => &$GLOBALS['TL_LANG']['tl_ranking']['name'],
            'exclude'   => true,
            'search'    => false,
            'filter'    => true,
            'inputType' => 'text',
            'eval'      => ['tl_class' => 'long', 'maxlength' => 128],
            'sql'       => "varchar(128) NOT NULL default ''",
        ],

    ], // fields

];
// Nur Administratoren dürfen Include-Elemente verwenden
// if (!BackendUser::getInstance()->isAdmin) {
//    unset($GLOBALS['TL_DCA']['tl_ranking']['list']['operations']['delete']);
//}