<?php
/**
 * Extended class to override the time_created
 */
class ElggChannel extends ElggGroup {

    /**
     * Set subtype to segment.
     */
    protected function initializeAttributes() {
        parent::initializeAttributes();

        $this->attributes['subtype'] = "channel";
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
        if(isMonitor($user_guid) || elgg_is_admin_logged_in($user_guid)){
//            smail("ismonitor?","ismon");
            return true;
        }
        return false;
    }
         
}
