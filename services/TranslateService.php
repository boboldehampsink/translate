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
            '/\{\{(| )\'(.*?)\'.*?\|.*?(t|translate)(\(.*?\)|)(| )\}\}/',
            // Double quotes
            '/\{\{(| )"(.*?)".*?\|.*?(t|translate)(\(.*?\)|)(| )\}\}/'
        ),
        
        // Expressions for Craft.t()
        'js' => array(
            // Single quotes
            '/Craft\.(t|translate)\(.*?\'(.*?)\'.*?\)/',
            // Double quotes
            '/Craft\.(t|translate)\(.*?"(.*?)".*?\)/'
        )
        
    ); 
    
    public function get() 
    {
    
        // Check if we have 'em cached
        if(!($files = craft()->cache->get('translations'))) {
    
            // Get all plugin occurences
            $plugins = $this->_occurences(craft()->path->getPluginsPath(), '^((?!vendor).)*(\.(\.php|\.html|\.js)?)$');
            
            // Get all template occurences
            $templates = $this->_occurences(craft()->path->getSiteTemplatesPath(), '.html');
                    
            // Merge all files
            $files = array_merge($plugins, $templates);
            
            // Save cache
            craft()->cache->set('translations', $files);
            
        }
        
        // Return all
        return $files;
    
    }
    
    public function set($locale, $translations)
    {
    
        // Prepare php file
        $php = "<?php\r\n\r\nreturn ";
    
        // Get translations as php
        $php .= var_export($translations, true);
        
        // End php file
        $php .= ";";
        
        // Convert double space to tab (as in Craft's own translation files)
        $php = str_replace("  '", "\t'", $php);
        
        // Determine locale's translation destination file
        $file = __DIR__ . '/../translations/' . $locale . '.php';
        
        // Save code to file
        if(!IOHelper::writeToFile($file, $php)) {
        
            // If not, complain
            throw new Exception(Craft::t("Something went wrong while saving your translations"));
        
        }
        
        // Clear the cache
        craft()->cache->delete('translations');
    
    }
    
    protected function _occurences($path, $filter)
    {
    
        // Get files
        $files = IOHelper::getFolderContents($path, true, $filter);
                
        // Gather all translatable strings
        $occurences = array();
        
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
                    foreach($matches[2] as $match) {
                        $occurences[$match] = Craft::t($match);
                    }
                                
                }
            
            }
                    
        }
        
        return $occurences;
    
    }

}