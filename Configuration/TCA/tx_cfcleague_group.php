<?php

if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

$tx_cfcleague_group = [
    'ctrl' => [
        'title' => 'LLL:EXT:cfc_league/Resources/Private/Language/locallang_db.xml:tx_cfcleague_group',
        'label' => 'name',
        'searchFields' => 'uid,name,shortname',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'sortby' => 'sorting',
        'delete' => 'deleted',
        'useColumnsForDefaultValues' => 'hidden',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
        ],
        'typeicon_classes' => [
            'default' => 'ext-cfcleague-group-default',
        ],
        'iconfile' => 'EXT:cfc_league/Resources/Public/Icons/icon_tx_cfcleague_group.gif',
    ],
    'interface' => [
        'showRecordFieldList' => 'hidden,starttime,fe_group,name',
    ],
    'feInterface' => [
        'fe_admin_fieldList' => 'hidden, starttime, fe_group, name',
    ],
    'columns' => [
        'hidden' => [
            'exclude' => 1,
            'label' => \Sys25\RnBase\Backend\Utility\TcaTool::buildGeneralLabel('hidden'),
            'config' => [
                'type' => 'check',
                'default' => '0',
            ],
        ],
        'starttime' => [
            'exclude' => 1,
            'label' => \Sys25\RnBase\Backend\Utility\TcaTool::buildGeneralLabel('starttime'),
            'config' => [
                'type' => 'input',
                'renderType' => (tx_rnbase_util_TYPO3::isTYPO86OrHigher() ? 'inputDateTime' : ''),
                'eval' => 'datetime'.(tx_rnbase_util_TYPO3::isTYPO104OrHigher() ? ',int' : ''),
                'default' => '0',
            ],
        ],
        'name' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:cfc_league/Resources/Private/Language/locallang_db.xml:tx_cfcleague_group.name',
            'config' => [
                'type' => 'input',
                'size' => '30',
                'eval' => 'required,trim',
            ],
        ],
        'shortname' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:cfc_league/Resources/Private/Language/locallang_db.xml:tx_cfcleague_group.shortname',
            'config' => [
                'type' => 'input',
                'size' => '10',
                'max' => '8',
                'eval' => 'trim',
            ],
        ],
    ],
    'types' => [
        '0' => [
            'showitem' => 'hidden,--palette--;;1, name, shortname, logo, t3logo',
        ],
    ],
    'palettes' => [
        '1' => [
            'showitem' => 'starttime',
        ],
    ],
];

if (\Sys25\RnBase\Utility\TYPO3::isTYPO104OrHigher()) {
    unset($tx_cfcleague_group['interface']['showRecordFieldList']);
}

$tx_cfcleague_group['columns']['logo'] = tx_rnbase_util_TSFAL::getMediaTCA('logo', [
    'label' => 'LLL:EXT:cfc_league/Resources/Private/Language/locallang_db.xml:tx_cfcleague_club.logo',
    'size' => 1,
    'maxitems' => 1,
]);

return $tx_cfcleague_group;
