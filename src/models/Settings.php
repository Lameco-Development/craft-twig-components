<?php

namespace lameco\crafttwigcomponents\models;

use craft\base\Model;

class Settings extends Model
{
    public array $components = [
        [
            'name' => 'Content Media',
            'enabled' => false,
            'migration' => 'm241030_094050_create_content_media_block'
        ],
        [
            'name' => 'Collapsible Content',
            'enabled' => false,
            'migration' => 'm241111_183745_create_collapsible_content_block'
        ],
        [
            'name' => 'General Content',
            'enabled' => false,
            'migration' => 'm241111_183745_create_general_content_block'
        ],
        [
            'name' => 'Call To Action',
            'enabled' => false,
            'migration' => 'm241111_183745_create_call_to_action_content_block'
        ]
    ];

    public int|null $pageBuilderFieldId = null;

    public function defineRules(): array
    {
        return [
            [['components'], 'required'],
            [['components'], 'each', 'rule' => ['safe']],
        ];
    }
}
