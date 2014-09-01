<?php
namespace Craft;

class TranslateModel extends BaseElementModel
{

    const DONE     = 'live';
    const PENDING  = 'pending';

    protected $elementType = 'Translate';
    
    public function getTitle()
    {
        return $this->original;
    }
    
    protected function defineAttributes()
    {
        return array_merge(parent::defineAttributes(), array(
            'id'              => AttributeType::String,
            'original'        => AttributeType::String,
            'translation'     => AttributeType::String,
            'source'          => AttributeType::Mixed,
            'file'            => AttributeType::String,
            'locale'          => array(AttributeType::String, 'default' => 'en_us'),
            'field'			  => AttributeType::Mixed
        ));
    }
    
    public function getStatus()
    {
        if ($this->original != $this->translation)
        {
            return static::DONE;
        }
        else
        {
            return static::PENDING;
        }
    }
    
}