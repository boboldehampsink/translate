<?php
namespace Craft;

class TranslateElementType extends BaseElementType
{

    public function getName()
    {
        return Craft::t('Translations');
    }
    
    // Return true so we have a locale select menu
    public function isLocalized()
    {
        return true;
    }
    
    // Return true so we have a status select menu
    public function hasStatuses()
    {
        return true;
    }

    // Define statuses
    public function getStatuses()
    {
        return array(
            TranslateModel::DONE    => Craft::t('Done'),
            TranslateModel::PENDING => Craft::t('Pending')
        );
    }

    // Define table column names
    public function defineTableAttributes($source = null)
    {
        return array(
            'original' => Craft::t('Original'),
            'field'    => Craft::t('Translation')
        );
    }
    
    // Define criteria
    public function defineCriteriaAttributes()
    {
        return array(
            'original'    => AttributeType::String,
            'translation' => AttributeType::String,
            'source'      => AttributeType::String,
            'file'        => AttributeType::String,
            'status'      => array(AttributeType::String, 'default' => TranslateModel::DONE),
            'locale'      => array(AttributeType::String, 'default' => 'en_us')
        );
    }
    
    // Cancel the elements query
    public function modifyElementsQuery(DbCommand $query, ElementCriteriaModel $criteria)
    {
        return false;
    }
    
    // Create element from row
    public function populateElementModel($row)
    {
        return TranslateModel::populateModel($row);
    }
    
    // Define the sources
    public function getSources($context = null)
    {
        return array(
            '*' => array(
                'label'      => Craft::t('All translations'),
                'criteria'   => array(
                    'source' => array(
                        craft()->path->getPluginsPath(), 
                        craft()->path->getSiteTemplatesPath()
                    )
                )
            ),
            'plugins' => array(
                'label'      => Craft::t('Plugins'),
                'criteria'   => array(
                    'source' => craft()->path->getPluginsPath()
                )
            ),
            'templates' => array(
                'label'      => Craft::t('Templates'),
                'criteria'   => array(
                    'source' => craft()->path->getSiteTemplatesPath()
                )
            )
        );
    }
    
    // Return the html
    public function getIndexHtml($criteria, $disabledElementIds, $viewState, $sourceKey, $context)
    {
        $variables = array(
            'viewMode'            => $viewState['mode'],
            'context'             => $context,
            'elementType'         => new ElementTypeVariable($this),
            'disabledElementIds'  => $disabledElementIds,
            'attributes'          => $this->defineTableAttributes($sourceKey),
            'elements'            => craft()->translate->get($criteria)
        );
        
        // Inject some custom js also
        craft()->templates->includeJs("$('table.fullwidth thead th').css('width', '50%');");
        craft()->templates->includeJs("$('.buttons.hidden').removeClass('hidden');");
       
        $template = '_elements/'.$viewState['mode'].'view/'.(!$criteria->offset ? 'container' : 'elements');
        return craft()->templates->render($template, $variables);
    }

}