<?php

/**
 * @file
 * @author  Erasmo Alonso Iglesias <erasmo1982@users.sourceforge.net>
 * @version 1.0
 *
 * @section LICENSE
 *
 * The ARAS Radio Automation System
 * Copyright (C) 2019  Erasmo Alonso Iglesias
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @section DESCRIPTION
 *
 * Main source file for ARAS Web Service block library.
 */

include_once 'parse.php';

define("ARAS_BLOCK_MAX_LINE", "2048");
define("ARAS_BLOCK_MAX_NAME", "256");
define("ARAS_BLOCK_MAX_TYPE", "32");
define("ARAS_BLOCK_MAX_DATA", "1024");

define("ARAS_BLOCK_TYPE_FILE", "0");
define("ARAS_BLOCK_TYPE_PLAYLIST", "1");
define("ARAS_BLOCK_TYPE_RANDOM", "2");
define("ARAS_BLOCK_TYPE_RANDOM_FILE", "3");
define("ARAS_BLOCK_TYPE_INTERLEAVE", "4");

class aras_block_node {
        public $name;
        public $type;
        public $data;
};

/**
 * This function loads in a configuration structure the data contained in a
 * line.
 *
 * @param   block    Pointer to the block array of structures
 * @param   line     The line
 *
 * @return  0 if success, -1 if error
 */
function aras_block_load_line(&$block, $line)
{
        /* Get block name, block type and data */
        if (($res1 = aras_parse_line_configuration($line)) == NULL)
                return -1;
        if (($res2 = aras_parse_line_configuration($res1[1])) == NULL)
                return -1;
        if (($res3 = aras_parse_line_configuration($res2[1])) == NULL)
                return -1;

        if (($res1[0] != NULL) && ($res2[0] != NULL) && ($res3[0] != NULL)) {
                $b->name = $res1[0];

                if (!strcasecmp($res2[0], 'file'))
                        $b->type = ARAS_BLOCK_TYPE_FILE;
                else if (!strcasecmp($res2[0], 'playlist'))
                        $b->type = ARAS_BLOCK_TYPE_PLAYLIST;
                else if (!strcasecmp($res2[0], 'random'))
                        $b->type = ARAS_BLOCK_TYPE_RANDOM;
                else if (!strcasecmp($res2[0], 'randomfile'))
                        $b->type = ARAS_BLOCK_TYPE_RANDOM_FILE;
                else if (!strcasecmp($res2[0], 'interleave'))
                        $b->type = ARAS_BLOCK_TYPE_INTERLEAVE;

                $b->data = $res3[0];
                array_push($block, $b);
        }

        return 0;
}

/**
 * This function loads in a configuration structure the data contained in a
 * file.
 *
 * @param   block    Pointer to the block array of structures
 * @param   file     The file name string
 *
 * @return  0 if success, -1 if error
 */
function aras_block_load_file(&$block, $file)
{
        /* Open configuration file */
        if (($fp = fopen($file, "r")) == NULL)
                return -1;

        /* Get lines from configuration file */
        while (($line = fgets($fp)) != NULL) {
                aras_block_load_line($block, $line);
        }

        /* Close configuration file */
        if (fclose($fp) != 0)
                return -1;

        return 0;
}

function aras_block_write_menu(&$block, $name, $selected)
{
        printf('<select name="%s">', $name);
        printf('<option disabled selected value>Select block</option>');
        for ($k = 0; $k < count($block); $k++) {
                if (!strcasecmp($block[$k]->name, $selected))
                        printf('<option value="%s" selected>', $block[$k]->name);
                else
                        printf('<option value="%s">', $block[$k]->name);

                printf($block[$k]->name);
                printf('</option>');
        }
        printf('</select>');
}

function aras_block_write_type_menu($name, $selected)
{
        printf('<select name="%s">', $name);

        printf('<option disabled selected value>Select block type</option>');

        if ($selected == ARAS_BLOCK_TYPE_FILE)
            printf('<option value="file" selected>');
        else
            printf('<option value="file">');
        printf('File');
        printf('</option>');

        if ($selected == ARAS_BLOCK_TYPE_PLAYLIST)
            printf('<option value="playlist" selected>');
        else
            printf('<option value="playlist">');
        printf('Playlist');
        printf('</option>');

        if ($selected == ARAS_BLOCK_TYPE_RANDOM)
            printf('<option value="random" selected>');
        else
            printf('<option value="random">');
        printf('Random');
        printf('</option>');

        if ($selected == ARAS_BLOCK_TYPE_RANDOM_FILE)
            printf('<option value="randomfile" selected>');
        else
            printf('<option value="randomfile">');
        printf('Random file');
        printf('</option>');

        if ($selected == ARAS_BLOCK_TYPE_INTERLEAVE)
            printf('<option value="interleave" selected>');
        else
            printf('<option value="interleave">');
        printf('Interleave');
        printf('</option>');

        printf('</select>');
}

function aras_block_sort_by_name(&$block)
{
        for ($k = 0; $k < (count($block) - 1); $k++)
                for ($l = $k + 1; $l < count($block); $l++) {
                        if (strcasecmp($block[$k]->name, $block[$l]->name) > 0) {
                                $temp = $block[$k];
                                $block[$k] = $block[$l];
                                $block[$l] = $temp;
                        }
                }
}

function aras_block_write_rows(&$block)
{
        printf('<table class="table_center">');

        printf('<tr>');
        printf('<th>Delete</th>');
        printf('<th>Block name</th>');
        printf('<th>Block type</th>');
        printf('<th colspan="4">Block data</th>');
        printf('</tr>');

        printf('<tr>');
        printf('<td></td>');
        printf('<td><span title="Block name"><input type="text" size="16" name="block_add[name]" value=""></span></td>');
        printf('<td>');
        printf('<span title="Block type">');
        aras_block_write_type_menu(sprintf('block_add[type]', $k), NULL);
        printf('</span>');
        printf('</td>');
        printf('<td colspan="4"><span title="Block data"><input type="text" size="64" name="block_add[data]" value=""></span></td>');
        printf('</tr>');

        if (count($block) > 0) {
                for ($k = 0; $k < count($block); $k++) {
                        printf('<tr>');
                        printf('<td>');
                        printf('<span title="Delete">');
                        printf('<input type="checkbox" name="block[%d][delete]" value="delete">', $k);
                        printf('</span>');
                        printf('</td>');
                        printf('<td>');
                        printf('<span title="%s">', $block[$k]->name);
                        printf('<input type="text" size="24" name="block[%d][name]" value="%s">', $k, $block[$k]->name);
                        printf('</span>');
                        printf('</td>');
                        printf('<td><span title="Block type">');
                        aras_block_write_type_menu(sprintf('block[%d][type]', $k), $block[$k]->type);
                        printf('</span></td>');

                        if ($block[$k]->type != ARAS_BLOCK_TYPE_INTERLEAVE) {
                                printf('<td colspan="4"><span title="%s"><input type="text" size="64" name="block[%d][data]" value="%s"></span></td>', $block[$k]->data, $k, $block[$k]->data);
                        } else {

                                if (($res1 = aras_parse_line_configuration($block[$k]->data)) == NULL)
                                        return -1;
                                if (($res2 = aras_parse_line_configuration($res1[1])) == NULL)
                                        return -1;
                                if (($res3 = aras_parse_line_configuration($res2[1])) == NULL)
                                        return -1;
                                if (($res4 = aras_parse_line_configuration($res3[1])) == NULL)
                                        return -1;

                                printf('<td><span title="First block">');
                                aras_block_write_menu($block, sprintf("block[%d][block_1]", $k), $res1[0]);
                                printf('</span></td>');
                                printf('<td><span title="Second block">');
                                aras_block_write_menu($block, sprintf("block[%d][block_2]", $k), $res2[0]);
                                printf('</span></td>');
                                printf('<td><span title="Number of elements from first block">');
                                printf('<input type="number" min="1" max="1000" step="1" name="block[%d][n_1]" value="%d">', $k, $res3[0]);
                                printf('</span></td>');
                                printf('<td><span title="Number of elements from second block">');
                                printf('<input type="number" min="1" max="1000" step="1" name="block[%d][n_2]" value="%d">', $k, $res4[0]);
                                printf('</td>');
                        }

                        printf('</tr>');
                }
        } else {
                printf('<tr><td colspan="4"><center>No blocks</center></td></tr>');
        }
        printf('</table>');
}

function aras_block_load_post(&$block, $post_array, $post_array_add)
{
        /* Existing block nodes from post array to aras block array */
        for ($k = 0; $k < count($post_array); $k++) {
                if (strcasecmp($post_array[$k]['delete'], 'delete')) {
                        $b = new aras_block_node;
                        $b->name = sprintf("%s", $post_array[$k]['name']);

                        if (!strcasecmp($post_array[$k]['type'], 'file'))
                                $b->type = ARAS_BLOCK_TYPE_FILE;
                        else if (!strcasecmp($post_array[$k]['type'], 'playlist'))
                                $b->type = ARAS_BLOCK_TYPE_PLAYLIST;
                        else if (!strcasecmp($post_array[$k]['type'], 'random'))
                                $b->type = ARAS_BLOCK_TYPE_RANDOM;
                        else if (!strcasecmp($post_array[$k]['type'], 'randomfile'))
                                $b->type = ARAS_BLOCK_TYPE_RANDOM_FILE;
                        else if (!strcasecmp($post_array[$k]['type'], 'interleave'))
                                $b->type = ARAS_BLOCK_TYPE_INTERLEAVE;

                        if ($b->type != ARAS_BLOCK_TYPE_INTERLEAVE)
                                $b->data = sprintf("%s", $post_array[$k]['data']);
                        else
                                $b->data = sprintf("'%s' '%s' %d %d", $post_array[$k]['block_1'], $post_array[$k]['block_2'], $post_array[$k]['n_1'], $post_array[$k]['n_2']);

                        $block[] = $b;
                }
        }

        /* New block node from post array add to aras block array */
        if (($post_array_add['name'] !='') && isset($post_array_add['type']) && ($post_array_add['data'] != '')) {
                $b = new aras_block_node;
                $b->name = sprintf("%s", $post_array_add['name']);

                if (!strcasecmp($post_array_add['type'], 'file'))
                        $b->type = ARAS_BLOCK_TYPE_FILE;
                else if (!strcasecmp($post_array_add['type'], 'playlist'))
                        $b->type = ARAS_BLOCK_TYPE_PLAYLIST;
                else if (!strcasecmp($post_array_add['type'], 'random'))
                        $b->type = ARAS_BLOCK_TYPE_RANDOM;
                else if (!strcasecmp($post_array_add['type'], 'randomfile'))
                        $b->type = ARAS_BLOCK_TYPE_RANDOM_FILE;
                else if (!strcasecmp($post_array_add['type'], 'interleave'))
                        $b->type = ARAS_BLOCK_TYPE_INTERLEAVE;

                $b->data = sprintf("%s", $post_array_add['data']);
                $block[] = $b;
        }
}

?>
