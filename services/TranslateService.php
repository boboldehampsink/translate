<?php
namespace Craft;

class TranslateService extends BaseApplicationComponent 
{

    protected $_expressions = array(
    
        // Expressions for Craft::t()
        'php' => array(
            // Single quotes
            '/Craft::(t|translate)\(.*?\'(.*?)\'.*?\)/',
            // Double quotes
            '/Craft::(t|translate)\(.*?"(.*?)".*?\)/'    
        ),
        
        // Expressions for ""|t()
        'html' => array(
            // Single quotes
            '/\{\{(| )\'(.*?)\'.*?\|.*?(t|translate)(\(.*?\)|).*?\}\}/',
            // Double quotes
            '/\{\{(| )"(.*?)".*?\|.*?(t|translate)(\(.*?\)|).*?\}\}/'
        ),
        
        // Expressions for Craft.t()
        'js' => array(
            // Single quotes
            '/Craft\.(t|translate)\(.*?\'(.*?)\'.*?\)/',
            // Double quotes
            '/Craft\.(t|translate)\(.*?"(.*?)".*?\)/'
        )
        
    );
    
    public function set($locale, $translations)
    {
    
        // Determine locale's translation destination file
        $file = __DIR__ . '/../translations/' . $locale . '.php';
        
        // Get current translation
        if($current = @include($file)) {
            $translations = array_merge($current, $translations);
        }
    
        // Prepare php file
        $php = "<?php\r\n\r\nreturn ";
    
        // Get translations as php
        $php .= var_export($translations, true);
        
        // End php file
        $php .= ";";
        
        // Convert double space to tab (as in Craft's own translation files)
        $php = str_replace("  '", "\t'", $php);
        
        // Save code to file
        if(!IOHelper::writeToFile($file, $php)) {
        
            // If not, complain
            throw new Exception(Craft::t("Something went wrong while saving your translations"));
        
        }
    
    }
    
    public function get($criteria)
    {
        
        // Ensure source is an array    
        if(!is_array($criteria->source)) {
            $criteria->source = array($criteria->source);
        }
        
        // Gather all translatable strings
        $occurences = array();
                
        // Loop through paths
        foreach($criteria->source as $path) {
        
            // Set filter - no vendor folders, only php, html, twig or js
            $filter = '^((?!vendor).)*(\.(php|html|twig|js)?)$';
    
            // Get files
            $files = IOHelper::getFolderContents($path, true, $filter);
                        
            // Loop through files and find translate occurences
            foreach($files as $file) {
            
                // Get file contents
                $contents = IOHelper::getFileContents($file);
                
                // Get extension
                $extension = IOHelper::getExtension($file);
            
                // Get matches per extension
                foreach($this->_expressions[$extension] as $regex) {
                
                    // Match translation functions
                    if(preg_match_all($regex, $contents, $matches)) {
                        
                        // Collect
                        foreach($matches[2] as $original) {
                        
                            // Translate
                            $translation = Craft::t($original, array(), null, $criteria->locale);
                            
                            // Show translation in textfield
                            $field = craft()->templates->render('_includes/forms/text', array(
                                'id'          => ElementHelper::createSlug($original),
                                'name'        => 'translation[' . $original . ']', 
                                'value'       => $translation,
                                'placeholder' => $translation
                            ));
                                                    
                            // Fill element with translation data
                            $element = TranslateModel::populateModel(array(
                                'id'          => ElementHelper::createSlug($original),
                                'original'    => $original,
                                'translation' => $translation,
                                'source'      => $path,
                                'file'        => $file,
                                'locale'      => $criteria->locale,
                                'field'       => $field
                            ));
                            
                            // If searching, only return matches
                            if($criteria->search && !stristr($element->original, $criteria->search) && !stristr($element->translation, $criteria->search)) {
                                continue;
                            }
                                                        
                            // If wanting one status, ditch the rest
                            if($criteria->status && $criteria->status != $element->getStatus()) {
                                continue;
                            }
                                                    
                            // Collect in array
                            $occurences[$original] = $element;
                            
                        }
                                    
                    }
                
                }
                        
            }
        
        }
        
        return $occurences;
    
    }

}