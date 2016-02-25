<?php

namespace Craft;

/**
 * Translate Controller.
 *
 * Contains translate request actions.
 *
 * @author    Bob Olde Hampsink <b.oldehampsink@nerds.company>
 * @copyright Copyright (c) 2016, Bob Olde Hampsink
 * @license   MIT
 *
 * @link      http://github.com/boboldehampsink
 */
class TranslateController extends BaseController
{
    /**
     * Download translations.
     */
    public function actionDownload()
    {
        // Get params
        $locale = craft()->request->getParam('locale');

        // Set criteria
        $criteria = craft()->elements->getCriteria('Translate');
        $criteria->search = false;
        $criteria->status = false;
        $criteria->locale = $locale;
        $criteria->source = array(
            craft()->path->getPluginsPath(),
            craft()->path->getSiteTemplatesPath(),
        );

        // Get occurences
        $occurences = craft()->translate->get($criteria);

        // Re-order data
        $data = StringHelper::convertToUTF8('"'.Craft::t('Original').'","'.Craft::t('Translation')."\"\r\n");
        foreach ($occurences as $element) {
            $data .= StringHelper::convertToUTF8('"'.$element->original.'","'.$element->translation."\"\r\n");
        }

        // Download the file
        craft()->request->sendFile('translations_'.$locale.'.csv', $data, array('forceDownload' => true, 'mimeType' => 'text/csv'));
    }

    /**
     * Upload translations.
     */
    public function actionUpload()
    {
        // Get params
        $locale = craft()->request->getRequiredPost('locale');

        // Get file
        $file = \CUploadedFile::getInstanceByName('translations-upload');

        // Get filepath
        $path = craft()->path->getTempUploadsPath().$file->getName();

        // Save file to Craft's temp folder
        $file->saveAs($path);

        // Open file and parse csv rows
        $translations = array();
        $handle = fopen($path, 'r');
        while (($row = fgetcsv($handle)) !== false) {
            $translations[$row[0]] = $row[1];
        }
        fclose($handle);

        // Save
        craft()->translate->set($locale, $translations);

        // Set a flash message
        craft()->userSession->setNotice(Craft::t('The translations have been updated.'));

        // Redirect back to page
        $this->redirectToPostedUrl();
    }

    /**
     * Save translations.
     */
    public function actionSave()
    {
        // Get params
        $locale = craft()->request->getRequiredPost('locale');
        $translations = craft()->request->getRequiredPost('translation');

        // Save to translation file
        craft()->translate->set($locale, $translations);

        // Set a flash message
        craft()->userSession->setNotice(Craft::t('The translations have been updated.'));

        // Redirect back to page
        $this->redirectToPostedUrl();
    }
}
