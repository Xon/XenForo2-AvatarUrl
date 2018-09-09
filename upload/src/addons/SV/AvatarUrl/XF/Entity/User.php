<?php

namespace SV\AvatarUrl\XF\Entity;

class User extends XFCP_User
{
    public function getAvatarUrl($sizeCode, $forceType = null, $canonical = false)
    {
        if ($this->user_id && $this->avatar_date && $forceType != 'default')
        {
            $app = $this->app();

            $sizeMap = $app->container('avatarSizeMap');
            if (!isset($sizeMap[$sizeCode]))
            {
                // Always fallback to 's' in the event of an unknown size (e.g. 'xs', 'xxs' etc.)
                $sizeCode = 's';
            }

            $group = floor($this->user_id / 1000);

            return $app->applyExternalDataUrl(
                "avatars/{$this->avatar_date}/{$sizeCode}/{$group}/{$this->user_id}.jpg",
                $canonical
            );
        }

        return parent::getAvatarUrl($sizeCode, $forceType, $canonical);
    }
}