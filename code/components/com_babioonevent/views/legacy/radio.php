<?php
/**
 * RDBS
 * @author Robert Deutz (email contact@rdbs.net / site www.rdbs.de)
 * @version $Id: radio.php 635 2009-08-23 12:57:09Z deutz $
 **/
defined ('_JEXEC') or die ('Restricted access');

if ($this->elm ['error'] == 1) {
	echo '<div class="formelm fail">';
	echo '<p class="unsichtbar">' . JText::_ ( 'COM_BABIOONEVENT_FORMELMERROR' ) . '</p>';
	echo '<a name="error' . $this->errorcounter . '"></a>';
	$this->errorcounter ++;
} else {
	echo '<div class="formelm kategorie">';
}
if (array_key_exists('labletag',$this->elm))
{
	$namedesc = strtoupper ( $this->elm ['labletag'] );
} else {
	$namedesc = strtoupper ( $this->elm ['name'] ) . 'DESC';
}

echo JText::_ ( $namedesc );
echo $this->elm ['mandatory'] ? ' *' : '';
if ($this->elm ['value'] == 0) {
	$this->elm ['value'] = $this->elm['defaultvalue'];
}

echo '<div class="radio">';
foreach ( $this->elm['list'] as $c ) {
	echo '<input type="radio" name="'.$this->elm['name'].'" id="'.$this->elm['name'].'radio' . $c->value . '" value="' . $c->value . '"';
	echo $this->elm['value'] == $c->value ? ' checked="checked"' : '';
	echo ' class="rb"/>';
	echo '<label for="radio' . $c->value . '" class="lrb">' . $c->text . '</label><br />';
}
echo '</div>';

if ($this->elm ['error'] == 1 and $this->errorcounter < $this->errorcount) {
	echo '<a class="unsichtbar" href="#error' . $this->errorcounter . '">' . JText::_ ( 'COM_BABIOONEVENT_JUMPTONEXTERROR' ) . '</a>';
}
echo '<div class="wrap">&nbsp;</div> ';
echo '</div>';