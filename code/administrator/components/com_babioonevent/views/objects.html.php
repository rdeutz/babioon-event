<?php
/**
 * babioon event
 * @package    BABIOON_EVENT
 * @author     Robert Deutz <rdeutz@gmail.com>
 * @copyright  2012 Robert Deutz Business Solution
 * @license    GNU General Public License version 2 or later
 **/

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * View class for a list of Objects.
 *
 * @package  BABIOON_EVENT
 * @since    2.0
 */
class BabioonEventViewObjects extends JView
{
	protected $items;

	protected $pagination;

	protected $state;

	/**
	 * Method to display the view.
	 *
	 * @param   string  $tpl  A template file to load. [optional]
	 *
	 * @return  mixed  A string if successful, otherwise a JError object.
	 */
	public function display($tpl = null)
	{
		// Initialise variables.
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
		$this->state		= $this->get('State');

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode("\n", $errors));

			return false;
		}

		$this->addToolbar();
		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @return void
	 */
	protected function addToolbar()
	{
		$name       = $this->getName();
		$tag        = strtoupper($name);
		$singular    = BabioonEventHelper::toSingular($name);
		$doc = JFactory::getDocument();

		if (file_exists(JPATH_BASE . '/media/babioon/images/icon-48-babioon-' . $name . '.png'))
		{
			$doc->addStyleDeclaration('.icon-48-babioon-' . $name . ' {background-image: url(../media/babioon/images/icon-48-babioon-' . $name . '.png);}');
			$image = 'babioon-' . $name . '.png';
		}
		else
		{
			$doc->addStyleDeclaration('.icon-48-babioon {background-image: url(../media/babioon/images/icon-48-babioon.png);}');
			$image = 'babioon.png';
		}

		$user = JFactory::getUser();
		$canDo = BabioonEventHelper::getActions($singular);
		JToolBarHelper::title(JText::_('COM_BABIOONEVENT_' . $tag), $image);

		// Use singular
		JToolBarHelper::addNew($singular . '.add');
		JToolBarHelper::editList($singular . '.edit');

		if ($canDo->get('core.edit.state'))
		{
			if ($this->state->get('filter.state') != 2)
			{
				JToolBarHelper::divider();
				JToolBarHelper::publish($singular . '.publish', 'JTOOLBAR_PUBLISH', true);
				JToolBarHelper::unpublish($singular . '.unpublish', 'JTOOLBAR_UNPUBLISH', true);
			}

			if ($this->state->get('filter.state') != -1)
			{
				JToolBarHelper::divider();

				if ($this->state->get('filter.state') != 2)
				{
					JToolBarHelper::archiveList($singular . '.archive');
				}
				elseif ($this->state->get('filter.state') == 2)
				{
					JToolBarHelper::unarchiveList($singular . '.publish');
				}
			}
		}

		if ($canDo->get('core.edit.state'))
		{
			JToolBarHelper::checkin($singular . '.checkin');
		}

		if ($this->state->get('filter.state') == -2 && $canDo->get('core.delete'))
		{
			JToolBarHelper::deleteList('', $singular . '.delete', 'JTOOLBAR_EMPTY_TRASH');
			JToolBarHelper::divider();
		}
		elseif ($canDo->get('core.edit.state'))
		{
			JToolBarHelper::trash($singular . '.trash');
			JToolBarHelper::divider();
		}

		if ($canDo->get('core.admin'))
		{
			JToolBarHelper::preferences('com_babioonevent');
		}
	}
}