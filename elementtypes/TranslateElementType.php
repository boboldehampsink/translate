<?php
namespace Craft;

class TranslateElementType extends BaseElementType
{

    public function getName()
    {
        return Craft::t('Translations');
    }

    public function defineTableAttributes($source = null)
    {
        return array(
            'original' => Craft::t('Original'),
            'translation' => Craft::t('Translation')
        );
    }
    
    public function defineCriteriaAttributes()
    {
        return array(
            'original'        => AttributeType::String,
            'translation'     => AttributeType::String,
            'source'          => AttributeType::Mixed,
            'file'            => AttributeType::String,
            'status'          => array(AttributeType::String, 'default' => TranslateModel::DONE)
        );
    }
    
    public function modifyElementsQuery(DbCommand $query, ElementCriteriaModel $criteria)
    {
        return false;
    }
    
    public function populateElementModel($row)
    {
        return TranslateModel::populateModel($row);
    }
    
    public function getSources($context = null)
    {
        return array(
        	'*' => array(
        		'label'    => Craft::t('All translations'),
        		'criteria' => array()
        	),
        	'plugins' => array(
        	    'label'    => Craft::t('Plugins'),
        	    'criteria' => array('source' => 'plugins')
        	),
        	'templates' => array(
        	    'label'    => Craft::t('Templates'),
        	    'criteria' => array('source' => 'templates')
        	)
        );
    }

}