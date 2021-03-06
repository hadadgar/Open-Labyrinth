<?php
/**
 * Open Labyrinth [ http://www.openlabyrinth.ca ]
 *
 * Open Labyrinth is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Open Labyrinth is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Open Labyrinth.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @copyright Copyright 2012 Open Labyrinth. All Rights Reserved.
 *
 */
if(isset($templateData['collection'])) { ?>
<table width="100%" height="100%" cellpadding='6'>
    <tr>
        <td valign="top" bgcolor="#bbbbcb">
            <h4><?php echo __('edit Collection'); ?></h4>
            <p><a href="<?php echo URL::base(); ?>collectionManager">Collections</a></p>
            <table width="100%" cellpadding="6">
                <tr bgcolor="#ffffff"><td>
                        <table>
                            <form method="POST" action="<?php echo URL::base(); ?>collectionManager/updateName/<?php echo $templateData['collection']->id; ?>">
                            <tr><td>
                                    <p><?php echo __('colection name'); ?></p></td>
                                <td><input type="text" name="colname" value="<?php echo $templateData['collection']->name; ?>">
                                    <input type="submit" value="submit">
                                </td></tr>
                            </form>
                            <tr><td colspan="2"><p><strong>Labyrinths in Collection</strong></p>
                                    <?php if(count($templateData['collection']->maps) > 0) { ?>
                                    <?php foreach($templateData['collection']->maps as $mp) { ?>
                                    <p>
                                        <a href="<?php echo URL::base(); ?>labyrinthManager/editMap/<?php echo $mp->map->id; ?>"><?php echo $mp->map->name; ?></a> 
                                        - [<a href="<?php echo URL::base(); ?>collectionManager/deleteMap/<?php echo $templateData['collection']->id; ?>/<?php echo $mp->map->id; ?>"><?php echo __('delete'); ?></a>]</p>
                                    <?php } ?>
                                    <?php } ?>
                                    <p></p><form method="POST" action="<?php echo URL::base(); ?>collectionManager/addMap/<?php echo $templateData['collection']->id; ?>">
                                        <select name="mapid">
                                            <?php if(isset($templateData['maps']) and count($templateData['maps']) > 0) { ?>
                                            <?php foreach($templateData['maps'] as $map) { ?>
                                            <option value="<?php echo $map->id; ?>"><?php echo $map->name; ?></option>
                                            <?php } ?>
                                            <?php } ?>
                                           </select>
                                        <input type="submit" value="<?php echo __('submit'); ?>">
                                    </form><p></p>
                                </td></tr>
                        </table>
                    </td></tr>
            </table>
        </td>
    </tr>
</table>
<?php } ?>