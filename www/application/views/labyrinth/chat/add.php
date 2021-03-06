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
if (isset($templateData['map']) and isset($templateData['question_count'])) { ?>
    <table width="100%" height="100%" cellpadding="6">
        <tr>
            <td valign="top" bgcolor="#bbbbcb">
                <h4><?php echo __('Add Chat'); ?></h4>
                <table width="100%" cellpadding="6">
                    <tr bgcolor="#ffffff">
                        <td align="left">
                            <form id="chatForm" name="chatForm" method="post" action="<?php echo URL::base().'chatManager/saveNewChat/'.$templateData['map']->id.'/'.$templateData['question_count']; ?>">   
                                <div id="DivChatContent">
                                    <div>
                                        <table cellpadding="6" width="80%" align="center">
                                            <tr>
                                                <td><p>Stem:</p></td>
                                                <td colspan="2"><textarea name="cStem" rows="3" cols="42"></textarea></td>
                                            </tr>
                                        </table>
                                        <hr>
                                    </div>
                                    <?php if(isset($templateData['question_count'])) { ?>
                                    <?php for($i = 1; $i <= $templateData['question_count']; $i++) { ?>
                                        <div id="qDiv<?php echo $i; ?>">
                                            <table width="80%" align="center">
                                                <tr>
                                                    <td><p><?php echo $i; ?>:</p></td>
                                                    <td align="right"><p>question:</p><p>response:</p><p>counter:</p></td>
                                                    <td><p><input type="text" name="question<?php echo $i; ?>" size="48" value=""><br><input type="text" name="response<?php echo $i; ?>" size="48" value=""><br><input type="text" name="counter<?php echo $i; ?>" size="10" value="">&nbsp;type +, - or = an integer - e.g. '+1' or '=32'</p></td>
                                                    <td align="left"><p><a href="<?php echo URL::base().'chatManager/removeAddChatQuestion/'.$templateData['map']->id.'/'.$templateData['question_count']; ?>">Remove</a></p></td>
                                                </tr>
                                            </table><hr>
                                        </div>
                                    <?php } ?>
                                    <?php } ?>
                                </div>
                                <table cellpadding="6" width="80%">
                                    <tr>
                                        <td align="center">
                                            <p>
                                                <a href="<?php if(isset($templateData['question_count'])) { echo URL::base().'chatManager/addChatQuestion/'.$templateData['map']->id.'/'.($templateData['question_count'] + 1); }
                                                else { echo URL::base().'chatManager/addChatQuestion/'.$templateData['map']->id.'/3'; }?>">Click here to add an additional Question / Response pair</a></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center">
                                            <p>Track score with existing counter: 
                                                <?php if(isset($templateData['counters']) and count($templateData['counters']) > 0) { ?>
                                                <select name="scount">
                                                    <option value="0">no counter</option>
                                                    <?php foreach($templateData['counters'] as $counter) { ?>
                                                        <option value="<?php echo $counter->id; ?>"><?php echo $counter->name; ?> [<?php echo $counter->id; ?>]</option>
                                                    <?php } ?>
                                                </select>
                                                <?php } ?>
                                                </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center">
                                            <input type="submit" name="Submit" value="<?php echo __('submit'); ?>">
                                        </td>
                                    </tr>
                                </table>
                            </form>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
<?php } ?>