<?php
	/**
	 * Badges Badge class
	 * 
	 */


	class BadgesBadge extends ElggFile
	{
		protected function initialise_attributes()
		{
			parent::initialise_attributes();
			
			$this->attributes['subtype'] = "badge";
		}
		
		public function __construct($guid = null) 
		{
			parent::__construct($guid);
		}
        
            /**
         * Delete this file.
         *
         * @return bool
         */
        public function delete() {
            $fs = $this->getFilestore();
//            $filename = $this->getFilenameOnFilestore();
            $filename = $this->filename;
//            $filename = substr($filename, strrpos($filename, "/")+1);
            $options['metadata_name_value_pair'] = array(
                'name' => 'filename',
                'value' => $filename,
                'operand' => '=',
                'case_sensitive' => TRUE
            );
            $options['count'] = TRUE;
            if(elgg_get_entities_from_metadata($options) > 1){
                return delete_entity($this->get('guid'), $recursive);
            }else{
                if ($fs->delete($this)) {
                    return delete_entity($this->get('guid'), $recursive);
                }            
            }
        }


	}
	
?>
