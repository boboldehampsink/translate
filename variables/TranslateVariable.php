<?php
namespace Craft;

class TranslateVariable
{

    public function occurences()
    {
    
        return craft()->translate->get();
    
    }

}