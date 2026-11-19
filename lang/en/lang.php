<?php return [
    'plugin' => [
        'name' => 'Collections for Shopaholic Trade offers',
        'description' => '',
    ],
    'field' => [
        'widht' => 'Collection preview image width 12/12',
        'height' => 'Collection preview image is',
        'horisontal' => 'Horisontal',
        'vertical' => 'Vertical',
        'default' => 'Dark - Dark gray color',
        'textclass' => 'Text color - If image has dark background - use light text color',
        'textlight' => 'Light - White color'
    ],
    'menu' => [
        'main' => 'Offer Collections',
        'collections' => 'Collection list',
    ],
    'tab' => [
        'permissions' => 'OfferCollectionsShopaholic',
    ],
    'comment' => [],
    'message' => [],
    'button' => [],
    'component' => [
        'collection_page_name' => 'Offer Collection Page',
        'collection_page_description' => 'Get collection page data',
        'collection_data_name' => 'Offer Collection Data',
        'collection_data_description' => 'Get collection by ID',
        'collection_list_name' => 'Offer Collection List',
        'collection_list_description' => 'Get collection list',
        'collection_hub_name' => 'Collections Hub',
        'collection_hub_description' => 'Every collection and colour family that carries a live shade, as chips',
        'collection_family_page_name' => 'Collection / Colour Family Page',
        'collection_family_page_description' => 'One family by its value slug: its shades, its stored copy and whether it is indexable',
    ],
    'permission' => [
        'collection' => 'Manage collection',
    ],
    'collection' => [
        'name' => 'collection',
        'list_title' => 'Offer Collection list',
    ],
];