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
if (isset($templateData['node']) && isset($templateData['map'])) { ?>
    <table width="100%" height="100%" cellpadding='6'>
        <tr>
            <td valign="top" bgcolor="#bbbbcb">
                <h4><?php echo __('edit links of node'); ?>&nbsp; <a href="#"><?php echo $templateData['node']->id; ?>: <?php echo $templateData['node']->title; ?></a> </h4>
                <table width="100%" cellpadding="6">
                    <tr bgcolor="#ffffff">
                        <td align="left">
                            <?php if(isset($templateData['linkTypes']) and count($templateData['linkTypes']) > 0) { ?>
                            <form id="form0" name="form00" method="post" action="<?php echo URL::base().'linkManager/updateLinkType/'.$templateData['map']->id.'/'.$templateData['node']->id; ?>">
                                <p>
                                    <?php foreach($templateData['linkTypes'] as $linkType) { ?>
                                        <input type="radio" name="linktype" value="<?php echo $linkType->id; ?>" <?php if($linkType->id == $templateData['node']->link_type_id) echo 'checked=""'; ?>><?php echo $linkType->name; ?> - 
                                    <?php } ?>
                                    <input type="submit" name="Submit" value="update"></p>
                            </form>
                            <hr>
                            <?php } ?>
                            <p><strong><?php echo __('linked to'); ?>:</strong></p>
                            <?php if($templateData['node']->link_type->name == 'ordered' or $templateData['node']->link_type->name == 'random select one *') { ?>
                            <form method="post" action="<?php echo URL::base().'linkManager/updateOrder/'.$templateData['map']->id.'/'.$templateData['node']->id; ?>">
                            <?php } ?>
                            <table>
                                <?php if(count($templateData['node']->links) > 0) { ?>
                                    <?php foreach($templateData['node']->links as $link) { ?>
                                        <tr>
                                            <td valign="top"><p><?php echo $link->node_2->title; ?> (<?php echo $link->node_2->id; ?>)</p></td>
                                            <td valign="top"><p>
                                                    <a href="<?php echo URL::base().'linkManager/editLink/'.$templateData['map']->id.'/'.$templateData['node']->id.'/'.$link->id; ?>">[<?php echo __('edit link'); ?>]</a>
                                                </p>
                                            </td>
                                            <td valign="top">
                                                <p><a href="<?php echo URL::base().'linkManager/deleteLink/'.$templateData['map']->id.'/'.$templateData['node']->id.'/'.$link->id; ?>">[<?php echo __('delete link'); ?>]</a></p>
                                            </td>
                                            <td valign="top"><p></p></td>
                                            <?php if($templateData['node']->link_type->name == 'ordered') { ?>
                                                <td valign="top">
                                                    <select name="order_<?php echo $link->id; ?>">
                                                        <?php for($i = 0; $i < count($templateData['node']->links); $i++) { ?>
                                                            <option value="<?php echo $i+1; ?>" <?php if($link->order == ($i+1)) echo 'selected=""'; ?>><?php echo $i+1; ?></option>
                                                        <?php } ?>
                                                    </select></td>
                                            <?php } else if($templateData['node']->link_type->name == 'random select one *') { ?>
                                                <td valign="top">
                                                    <p><input type="text" size="5" name="weight_<?php echo $link->id; ?>" value="<?php echo $link->probability; ?>">&nbsp;<?php echo __('weighting'); ?></p>
                                                </td>
                                            <?php } ?> 
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                            </table>
                            <?php if($templateData['node']->link_type->name == 'ordered' or $templateData['node']->link_type->name == 'random select one *') { ?>
                            <input type="submit" name="Submit" value="update"></form>
                            <?php } ?>
                            <?php if(isset($templateData['linkStylies'])) { ?>
                            <hr>
                            <form id="form2" name="formx" method="post" action="<?php echo URL::base().'linkManager/updateLinkStyle/'.$templateData['map']->id.'/'.$templateData['node']->id; ?>">
                                <p><strong><?php echo __('link presentation style'); ?></strong></p>
                                <?php if(count($templateData['linkStylies']) > 0) { ?> 
                                <p>
                                    <?php foreach($templateData['linkStylies'] as $style) { ?>
                                        <input type="radio" name="linkstyle" value="<?php echo $style->id; ?>" <?php if($style->id == $templateData['node']->link_style_id) echo 'checked=""'; ?>><?php echo $style->name; ?> | 
                                    <?php } ?>
                                    <input type="submit" name="Submit" value="<?php echo __('update'); ?>"></p>
                                <?php } ?>
                            </form>
                            <?php } ?>
                            <hr>
                            <?php if(isset($templateData['editLink'])) { ?>
                            <form id="form3" name="form1" method="post" action="<?php echo URL::base().'linkManager/updateLink/'.$templateData['map']->id.'/'.$templateData['node']->id.'/'.$templateData['editLink']->id; ?>">
                            <?php } else { ?>
                            <form id="form3" name="form1" method="post" action="<?php echo URL::base().'linkManager/addLink/'.$templateData['map']->id.'/'.$templateData['node']->id; ?>">
                            <?php } ?>    
                                <p><strong><?php echo __('add link'); ?></strong></p>

                                <table width="100%">
                                    <tr><td><p><?php echo __('node'); ?></p></td>
                                        <td>
                                            <?php if(isset($templateData['link_nodes']) and count($templateData['link_nodes']) > 0) { ?>
                                            <select name="linkmnodeid">
                                                <?php foreach($templateData['link_nodes'] as $node) { ?>
                                                    <option value="<?php echo $node->id; ?>"><?php echo $node->id; ?>: <?php echo $node->title; ?></option>
                                                <?php } ?>
                                            </select>
                                            <?php } else if(isset($templateData['editLink'])) { ?>
                                                <p><strong><?php echo __('edit link'); ?> : <?php echo $templateData['editLink']->node_2->title; ?> [<?php echo $templateData['editLink']->node_2->id; ?>]</strong></p>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <tr><td><p><?php echo __('link image'); ?></p></td><td>
                                            <?php if(isset($templateData['images']) and count($templateData['images']) > 0) { ?>
                                            <select name="linkImage">
                                                <option value="0" <?php if(isset($templateData['editLink']) and $templateData['editLink']->image_id == NULL) echo 'selected=""'; ?>>no image</option>
                                                <?php foreach($templateData['images'] as $image) { ?>
                                                    <option value="<?php echo $image->id; ?>" <?php if(isset($templateData['editLink']) and $image->id == $templateData['editLink']->image_id) echo 'selected=""'; ?>><?php echo $image->name; ?> (<?php echo $image->id; ?>)</option>
                                                <?php } ?>
                                            </select>
                                            <?php } else { ?>
                                            <select name="linkImage">
                                                <option value="0" select="">no image</option>
                                            </select>
                                            <?php } ?>
                                            </td></tr>
                                    <tr><td><p><?php echo __('link label'); ?></p></td><td><input type="text" name="linkLabel" size="40" value="<?php if(isset($templateData['editLink'])) echo $templateData['editLink']->text; ?>"></td></tr>
                                    <tr><td><p>direction</p></td><td><p><input type="radio" name="linkDirection" value="1" checked=""><?php echo __('one way'); ?>: <input type="radio" name="linkDirection" value="2"><?php echo __('both ways'); ?></p></td></tr>
                                    <tr><td><p></p></td><td><input type="submit" name="Submit" value="<?php echo __('update'); ?>"></td></tr>
                                </table>
                            </form>
                            <br>
                        </td></tr>
                </table>
            </td>
        </tr>
    </table>
<?php } ?>