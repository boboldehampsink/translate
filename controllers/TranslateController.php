<?php
namespace Craft;

class TranslateController extends BaseController
{

    public function actionSave() 
    {
        
        // Get params
        $locale = craft()->request->getPost('locale');
        $translations = craft()->request->getRequiredPost('translation');
        
        // Save to translation file
        craft()->translate->set($locale, $translations);
        
        // Redirect back to page
        $this->redirectToPostedUrl();
        
    }
    
}