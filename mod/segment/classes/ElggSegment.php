<?php
/**
 * Extended class to override the time_created
 */
class ElggSegment extends ElggObject {

	/**
	 * Set subtype to segment.
	 */
	protected function initializeAttributes() {
		parent::initializeAttributes();

		$this->attributes['subtype'] = "segment";
	}

	/**
	 * Can a user comment on this segment?
	 *
	 * @see ElggObject::canComment()
	 *
	 * @param int $user_guid User guid (default is logged in user)
	 * @return bool
	 * @since 1.8.0
	 */
	public function canComment($user_guid = 0) {
		$result = parent::canComment($user_guid);
		if ($result == false) {
			return $result;
		}

		if ($this->comments_on == 'Off') {
			return false;
		}
		
		return true;
	}

    /**
     * Can a user edit this channel.
     *
     * @param int $user_guid The user GUID, optionally (default: logged in user)
     *
     * @return bool
     */
    public function canEdit($user_guid = 0) {        
        $user_guid = ($user_guid == 0) ? elgg_get_logged_in_user_guid() : $user_guid;
        if(isMonitor($user_guid) || elgg_is_admin_logged_in()){
//            smail("ismon","ismon");
            return true;
        }
        return false;
    }
    
    
}