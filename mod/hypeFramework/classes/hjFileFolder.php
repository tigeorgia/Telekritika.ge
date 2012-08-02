<?php

class hjFileFolder extends ElggObject {

    protected function initializeAttributes() {
        parent::initializeAttributes();

        $this->attributes['subtype'] = "hjfilefolder";
    }

    public function getContainedFiles() {
        $files = hj_framework_get_entities_by_priority('object', 'hjfile', $this->owner_guid, $this->guid);
        return $files;
    }
    
    public function getDataTypes() {
        $types = hj_formbuilder_get_filefolder_types();
        return $types;
    }
    
}