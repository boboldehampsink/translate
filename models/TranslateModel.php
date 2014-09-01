<?php
namespace Craft;

class TranslateModel extends BaseElementModel
{

    const DONE     = 'done';
    const PENDING  = 'pending';

    protected $elementType = 'Translate';
    
    protected function defineAttributes()
    {
        return array_merge(parent::defineAttributes(), array(
            'original'        => AttributeType::String,
            'translation'     => AttributeType::String,
            'source'          => AttributeType::Mixed,
            'file'            => AttributeType::String,
            'status'          => array(AttributeType::String, 'default' => static::DONE)
        ));
    }
    
}