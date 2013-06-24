<?php
/** 
 * @author: WAW (wawancell@gmail.com)
 * @version: 1.0
 * Copyright (C) 2012 by WAW.
 * 
 * @description: Widget for showing flash message with auto hide using JQuery effect.
 * @setup: - copy this widget under protected/component.
 * 		   - call this widget in layout/main.php to display the message for all view.
 *         - example usage in controller: Yii::app()->user->setFlash(<type>,<message>);
 *		   - <type> : success, error, notice
 *		   - <message> : output text to displayed.
 *
 * 	This program is distributed in the hope that it will be useful,
 * 	but WITHOUT ANY WARRANTY; without even the implied warranty of
 * 	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * 	GNU Lesser General Public License for more details.
 */
 
class Flashes extends CWidget {
 
    public function run() {
		
		Yii::app()->clientScript->registerScript(
		   'myHideEffect',
		   '$(".flashes").animate({opacity: 0.9}, 3500).fadeOut("2000");',
		   CClientScript::POS_READY
		);

		$flashMessages = Yii::app()->user->getFlashes();
		if ($flashMessages) {
			echo '<div class="flashes" style="text-align:center; padding:5px 20px 0px 20px">';
			foreach($flashMessages as $key => $message) {
				echo '<div class="flash-' . $key . ' shadow">' . $message . "</div>\n";
			}
			echo '</div>';
		}	
    }
}
?>