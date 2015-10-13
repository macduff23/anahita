<?php

jimport('joomla.plugin.plugin');

/**
 * Subscription system plugins. Validates the viewer subscriptions.
 *
 * @category   Anahita
 *
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 *
 * @link       http://www.GetAnahita.com
 */
class plgSystemInvites extends JPlugin
{
    /**
     * onAfterRender handler.
     */
    public function onAfterRoute()
    {
        global $mainframe;

        if ($mainframe->isAdmin()) {
            return;
        }

        if ((
              $token = KRequest::get('get.invitetoken', 'string')) &&
              KRequest::get('get.option', 'cmd') != 'com_invites'
        ) {
            $token = KService::get('repos:invites.token')->fetch(array('value' => $token));

            if ($token) {
                $response = KService::get('application.dispatcher')->getResponse();
                $response->setRedirect(JRoute::_('option=com_invites&view=token&invitetoken='.$token->value));
                $response->send();
                exit(0);
            }

            return;
        }

        $invite_token = KRequest::get('session.invite_token', 'string', null);

        if($invite_token) {
    		    $personConfig = &JComponentHelper::getParams('com_people');
    		    $personConfig->set('allowUserRegistration', true);
    		}
    }
}
