<?php

namespace Craft;

/**
 * Translate Model.
 *
 * Represents translate data.
 *
 * @author    Bob Olde Hampsink <b.oldehampsink@itmundi.nl>
 * @copyright Copyright (c) 2015, Bob Olde Hampsink
 * @license   MIT
 *
 * @link      http://github.com/boboldehampsink
 */
class TranslateModel extends BaseElementModel
{
    /**
     * Status constants.
     */
    const DONE     = 'live';
    const PENDING  = 'pending';

    /**
     * Element type.
     *
     * @var string
     */
    protected $elementType = 'Translate';

    /**
     * Return this model's title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->original;
    }

    /**
     * Return this model's status.
     *
     * @return string
     */
    public function getStatus()
    {
        if ($this->original != $this->translation) {
            return static::DONE;
        } else {
            return static::PENDING;
        }
    }

    /**
     * Define model attributes.
     *
     * @return array
     */
    protected function defineAttributes()
    {
        return array_merge(parent::defineAttributes(), array(
            'id'          => AttributeType::String,
            'original'    => AttributeType::String,
            'translation' => AttributeType::String,
            'source'      => AttributeType::Mixed,
            'file'        => AttributeType::String,
            'locale'      => array(AttributeType::String, 'default' => 'en_us'),
            'field'       => AttributeType::Mixed,
        ));
    }
}
