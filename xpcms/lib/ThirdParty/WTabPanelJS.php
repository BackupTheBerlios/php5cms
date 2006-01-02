<?php

 /**
 * WTabPanelJS class file
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the BSD License.
 *
 * Copyright(c) 2005 by Verena Ruff.
 *
 * To contact the author write to {@link mailto:ve.ru@triosolutions.at Verena Ruff}
 * The latest version of PRADO can be obtained from:
 * {@link http://prado.sourceforge.net/}
 *
 * @author Verena Ruff <mailto:ve.ru@triosolutions.at>
 * @version $Revision: 1.1 $  $Date: 2006/01/02 16:51:32 $
 * @package prado
 *
 * 0.2.1
 * chaged the Javascript. now the class of the <li> tags are changed
 * instead of <span> inside. Should help with some design issues.
 */

 /**
 * WTabPanelJS class
 *
 * This is a class to make tab panels. It changes the functionality of
 * TTabPanel to use Javascript to change the panels. This has the advantage
 * that no postback is neccessary to change a tab which speeds up the
 * application.
 * The drawback is, since there is no postback, no Prado event is fired when
 * the tab is changed and so there is no possibility to react on Prado side
 * to a change of the tabs. However, with WTabPanelJS::setCustomJavascript
 * one is able to add some specific Javascript code which is run on each change
 * of a tab.
 *
 *
 * The usage of WTabPanelJS is the same as the usage of TTabPanel. But there
 * are three new CSS classes:
 * <li> li.active: the label of the active tab
 * <li> li.inactive: the label of all inactive tabs
 *
 */

class WTabPanelJS extends TTabPanel
{

  public function onLoad( $param )
  {
    // Create all page links
    foreach($this->pages as $page)
    {
      $link = $this->createComponent("TLabel", $page[0].'_label');
      $link->setText($page[1]);
      $this->addBody($link);
      $link->onInit($param);
      $link->onLoad($param);
      $link->initProperties();
    }
  }

  public function onPreRender( $param )
  {
    if ( $this->Request->getParameter( 'tab' ))
    {
      $tab = split( ':', $this->Request->getParameter( 'tab' ));
      $this->setShowPage( $tab[count($tab)-1] );
    }
  }

  /**
  * Only allow TPanel and TLabel components as childs
  * @param mixed the object to be added
  * @return boolean
  */
  public function allowBody( $object )
  {
    if ( ($object instanceof TPanel) || ($object instanceof TLabel) )
    {
      return true;
    }
    return false;
  }


  public function render()
  {
    $content = '';

    $children = $this->getBodies();
    if ($children->length() > 0)
    {
      // Show all tabs
      $content .= $this->getTabHeader();
      foreach($children as $child)
      {
        if($child instanceof TLabel)
        {
          $child->appendJavaScriptEvent( 'onclick', "doPageChange( '".$child->getUniqueId()."' )" );
          $content .= $this->renderTab( $child );
        }
      }
      $content .= $this->getPanelHeader();

      // Render panels
      foreach($children as $child)
      {
        if (($child instanceof TPanel) )
        {
          $content .= $child->render();
        }
      }
      $content .= $this->getPanelFooter();
    }
    $content .= $this->jsHideDIVs();
    return $content;
  }

  /**
  * Render a tab
  * Override this to make your own presentation
  */
  protected function renderTab($link) {
    $content = '<li class="tab">'.$link->render().'</li>'."\n";
    return $content;
  }

  /**
  *  Set some additional Javascript code
  *  which will be run on every tab change
  *  @param string the Javascript code
  */
  public function setCustomJavaScript( $script )
  {
    $this->setViewState( 'CustomJavaScript', $script );
  }

  /**
  *  returns the custom Javascript code
  *  or an empty string if nothing is set
  *  @return string
  */
  public function getCustomJavaScript()
  {
    return $this->getViewState( 'CustomJavaScript', '' );
  }

  private function jsHideDIVs()
  {
    $show = $this->getUniqueId() . ':' . $this->getShowPage() . '_label';
    $form = $this->Page->getForm()->getId();

    $ret  = "<script type=\"text/javascript\">\n";
    $ret .= "var action = document.getElementById('$form').action;\n";
    $ret .= "tabPosition = action.search(/&tab=/);\n";
    $ret .= "if( tabPosition > 0 ) {\n";
    $ret .= "  action = action.substr(0,tabPosition)\n";
    $ret .= "}\n";
    $ret .= "function doPageChange( show ) {\n";
    $ret .= "  hideAll();\n";
    $ret .= "  e = document.getElementById( show );\n";  // setting the class for the tab header
    //$ret .= "  alert( e.parentNode );\n";
    $ret .= "  e.parentNode.className = 'active';\n";
    //$ret .= "  e.className = 'active';\n";
    $ret .= "  show = show.substr( 0, show.length-6 );\n"; // to get rid of _label to get the body
    $ret .= "  id_array = show.split( ':' );\n";
    $ret .= "  id = '';\n";
    $ret .= "  for ( i=0; i<id_array.length-2; i++ ) {\n";
    $ret .= "    id = id + id_array[i] + ':';\n";
    $ret .= "  }\n";
    $ret .= "  id = id + id_array[id_array.length-1];\n";
    $ret .= "  e = document.getElementById( id );\n";
    $ret .= "  e.style.display = 'block';\n";
    $ret .= "  theform = document.getElementById('$form');\n";
    $ret .= "  theform.action = action + '&tab=' + show;\n";
    $ret .= $this->getCustomJavaScript();
    $ret .= "}\n";
    $ret .= "function hideAll() {\n";
    foreach( $this->getBodies() as $child )
    {
      $ret .= "  e = document.getElementById( '".$child->getUniqueId()."' );\n";
      if ( $child instanceof TPanel )
      {
        $ret .= "  e.style.display = 'none';\n";
      }
      elseif ( $child instanceof TLabel )
      {
        $ret .= "  e.parentNode.className = 'inactive';\n";
      }
    }
    $ret .= "}\n";
    $ret .= "doPageChange( '$show' );\n";
    $ret .= "</script>\n";
    return $ret;
  }
}
?>