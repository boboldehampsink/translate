<?php
namespace Craft;

class TranslateController extends BaseController
{

    public function actionRefresh()
    {
    
        // Clear the cache
        craft()->cache->delete('translations');
        
        // Set a flash message
        craft()->userSession->setNotice(Craft::t('The translation sources have been refreshed.'));
    
        // Redirect back to page
        $this->redirect('translate');    
    
    }

    public function actionSave() 
    {
        
        // Get params
        $locale = craft()->request->getPost('locale');
        $translations = craft()->request->getRequiredPost('translation');
        
        // Save to translation file
        craft()->translate->set($locale, $translations);
        
        // Set a flash message
        craft()->userSession->setNotice(Craft::t('The translations have been updated.'));
        
        // Redirect back to page
        $this->redirect('translate');
        
    }
    
}