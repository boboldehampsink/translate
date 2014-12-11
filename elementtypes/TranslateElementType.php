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
    
    // Don't encode the attribute html
    public function getTableAttributeHtml(BaseElementModel $element, $attribute)
    {
        return $element->$attribute;
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

        // Get plugin sources
        $pluginSources = array();
        $plugins = craft()->plugins->getPlugins();
        foreach($plugins as $path => $plugin) {
            $pluginSources['plugins:'.$path] = array(
                'label' => $plugin->classHandle,
                'criteria' => array(
                    'source' => craft()->path->getPluginsPath().$path
                )
            );
        }

        // Get template sources
        $templateSources = array();
        $templates = IOHelper::getFolderContents(craft()->path->getSiteTemplatesPath(), false);
        foreach($templates as $template) {

            // Get path/name of html/twig/js/json files and folders
            preg_match('/(.*)\/(.*?)(\.(html|twig|js)|\/)$/', $template, $matches);
            $path = $matches[2];

            $templateSources['templates:'.$path] = array(
                'label' => $path,
                'criteria' => array(
                    'source' => $template
                )
            );
        }
    
        // Get default sources
        $sources = array(
            '*' => array(
                'label'      => Craft::t('All translations'),
                'criteria'   => array(
                    'source' => array(
                        craft()->path->getPluginsPath(), 
                        craft()->path->getSiteTemplatesPath()
                    )
                )
            ),
            array('heading' => Craft::t('Default')),
            'plugins' => array(
                'label'      => Craft::t('Plugins'),
                'criteria'   => array(
                    'source' => craft()->path->getPluginsPath()
                ),
                'nested' => $pluginSources
            ),
            'templates' => array(
                'label'      => Craft::t('Templates'),
                'criteria'   => array(
                    'source' => craft()->path->getSiteTemplatesPath()
                ),
                'nested' => $templateSources
            )
        );
       
        // Get sources by hook
        $plugins = craft()->plugins->call('registerTranslateSources');
        if(count($plugins)) {
            $sources[] = array('heading' => Craft::t('Custom'));
            foreach($plugins as $plugin) {
            
                // Add as own source
                $sources = array_merge($sources, $plugin);
                
                // Add to "All translations"
                foreach($plugin as $key => $values) {
                     $sources['*']['criteria']['source'][] = $values['criteria']['source'];
                }
                
            }
        }
        
        // Return sources
        return $sources;
        
    }
    
    // Return the html
    public function getIndexHtml($criteria, $disabledElementIds, $viewState, $sourceKey, $context, $includeContainer, $showCheckboxes)
    {
        $variables = array(
            'viewMode'            => $viewState['mode'],
            'context'             => $context,
            'elementType'         => new ElementTypeVariable($this),
            'disabledElementIds'  => $disabledElementIds,
            'attributes'          => $this->defineTableAttributes($sourceKey),
            'elements'            => craft()->translate->get($criteria),
            'showCheckboxes'      => $showCheckboxes,
        );
        
        // Inject some custom js also
        craft()->templates->includeJs("$('table.fullwidth thead th').css('width', '50%');");
        craft()->templates->includeJs("$('.buttons.hidden').removeClass('hidden');");
       
        $template = '_elements/'.$viewState['mode'].'view/'.($includeContainer ? 'container' : 'elements');
        return craft()->templates->render($template, $variables);
    }

}