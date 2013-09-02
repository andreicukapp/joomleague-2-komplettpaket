<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
jimport('joomla.html.pane');
jimport('joomla.filesystem.file');

require_once(JPATH_COMPONENT.DS.'models'.DS.'sportstypes.php');
require_once(JPATH_COMPONENT.DS.'models'.DS.'leagues.php');
 
/**
 *  View
 */
//class joomleagueViewcpanel extends JView
class joomleagueViewcpanel extends JLGView
{
	/**
	 *  view display method
	 * @return void
	 */
	function display($tpl = null) 
	{
		// Get data from the model
		$items = $this->get('Items');
		$pagination = $this->get('Pagination');
        $model	= $this->getModel();
        
		jimport('joomla.html.pane');
		$pane	=& JPane::getInstance('sliders');
		$this->assignRef( 'pane'		, $pane );
        $this->assignRef( 'version', $model->getVersion() );
        $this->assignRef( 'githubrequest', $model->getGithubRequests() );
 
		// Check for errors.
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		// Assign data to the view
		$this->items = $items;
		$this->pagination = $pagination;
 
		// Set the toolbar
		$this->addToolBar();
 
		// Display the template
		parent::display($tpl);
 
		// Set the document
		$this->setDocument();
	}
 
	/**
	 * Setting the toolbar
	 */
	protected function addToolBar() 
	{
		//$canDo = sportsmanagementHelper::getActions();
		
        JToolBarHelper::title(JText::_('COM_JOOMLEAGUE_MANAGER'), 'joomleague');
		
        /*
        if ($canDo->get('core.create')) 
		{
			JToolBarHelper::addNew('sportsmanagement.add', 'JTOOLBAR_NEW');
		}
		if ($canDo->get('core.edit')) 
		{
			JToolBarHelper::editList('sportsmanagement.edit', 'JTOOLBAR_EDIT');
		}
		if ($canDo->get('core.delete')) 
		{
			JToolBarHelper::deleteList('', 'sportsmanagements.delete', 'JTOOLBAR_DELETE');
		}
        */
		
        //if ($canDo->get('core.admin')) 
		//{
			JToolBarHelper::divider();
			JToolBarHelper::preferences('com_joomleague');
		//}
	}
	/**
	 * Method to set up the document properties
	 *
	 * @return void
	 */
	protected function setDocument() 
	{
		$document = JFactory::getDocument();
		$document->setTitle(JText::_('COM_JOOMLEAGUE_ADMINISTRATION'));
	}
	
	public function addIcon( $image , $url , $text , $newWindow = false )
	{
		$lang		=& JFactory::getLanguage();
		$newWindow	= ( $newWindow ) ? ' target="_blank"' : '';
?>
		<div style="float:<?php echo ($lang->isRTL()) ? 'right' : 'left'; ?>;">
			<div class="icon">
				<a href="<?php echo $url; ?>"<?php echo $newWindow; ?>>
					<?php echo JHTML::_('image', 'administrator/components/com_joomleague/assets/icons/' . $image , NULL, NULL ); ?>
					<span><?php echo $text; ?></span></a>
			</div>
		</div>
<?php
	}
	
}
