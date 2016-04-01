<?php
/**
 * @package      Prism
 * @subpackage   Controllers
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2016 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

namespace Prism\Controller\Form;

use Prism\Controller\Form;
use Joomla\Utilities\ArrayHelper;

defined('JPATH_PLATFORM') or die;

/**
 * This class contains common methods and properties
 * used in work with forms on the front-end.
 *
 * @package      Prism
 * @subpackage   Controllers
 */
class Frontend extends Form
{
    /**
     * This method prepare a link where the user will be redirected
     * after action he has been done.
     *
     * @param array $options
     *
     * # Example:
     * array(
     *        "view",
     *        "layout"
     *        "id",
     *        "url_var",
     *        "force_direction" // This is a link that will be used instead generated by the system.
     * );
     *
     * @return string
     */
    protected function prepareRedirectLink($options = array())
    {
        // Return predefined link
        $forceDirection = ArrayHelper::getValue($options, 'force_direction');
        if (null !== $forceDirection) {
            return $forceDirection;
        }

        // Generate a return link
        $view   = ArrayHelper::getValue($options, 'view');
        $layout = ArrayHelper::getValue($options, 'layout');
        $itemId = ArrayHelper::getValue($options, 'id', 0, 'uint');
        $urlVar = ArrayHelper::getValue($options, 'url_var', 'id');

        // Remove standard parameters
        unset($options['view'], $options['task'], $options['id'], $options['url_var']);

        // Prepare additional parameters
        $extraParams = $this->prepareExtraParameters($options);

        // Generate return link
        $link = $this->defaultLink . '&view=' . $view . $this->getRedirectToViewAppend($layout, $itemId, $urlVar) . $extraParams;

        return $link;
    }

    /**
     * Gets the URL arguments to append to an item redirect.
     *
     * @param   string  $layout The layout that will be loaded
     * @param   integer $itemId The primary key id for the item.
     * @param   string  $urlVar The name of the URL variable for the id.
     *
     * @return  string  The arguments to append to the redirect URL.
     *
     * @since   12.2
     */
    protected function getRedirectToViewAppend($layout = null, $itemId = null, $urlVar = 'id')
    {
        $app = \JFactory::getApplication();
        /** @var @app JApplicationSite */

        $tmpl   = $app->input->get('tmpl');
        $append = '';

        // Setup redirect info.
        if ($tmpl) {
            $append .= '&tmpl=' . $tmpl;
        }

        if ($layout) {
            $append .= '&layout=' . $layout;
        }

        if ($itemId) {
            $append .= '&' . $urlVar . '=' . $itemId;
        }

        return $append;
    }
}
