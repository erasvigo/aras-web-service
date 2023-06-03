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
 * Main source file for ARAS Web Service schedule library.
 */

include_once 'parse.php';
include_once 'block_library.php';

define("ARAS_SCHEDULE_MAX_LINE", "2048");
define("ARAS_SCHEDULE_MAX_DAY", "16");
define("ARAS_SCHEDULE_MAX_TIME", "16");
define("ARAS_SCHEDULE_MAX_BLOCK_NAME", "1024");

class aras_schedule_node {
        public $day;
        public $time;
        public $block;
};

/**
 * This function loads in a schedule structure the data contained in a
 * line.
 *
 * @param   schedule    Pointer to the block array of structures
 * @param   line        Pointer to the line
 *
 * @return  0 if success, -1 if error
 */
function aras_schedule_load_line(&$schedule, $line)
{
        /* Create schedule node */
        $s = new aras_block_node();

        /* Get block name, block type and data */
        if (($res1 = aras_parse_line_configuration($line)) == NULL)
                return -1;
        if (($res2 = aras_parse_line_configuration($res1[1])) == NULL)
                return -1;
        if (($res3 = aras_parse_line_configuration($res2[1])) == NULL)
                return -1;

        if (($res1[0] != NULL) && ($res2[0] != NULL) && ($res3[0] != NULL)) {
                $s->day = $res1[0];
                $s->time = $res2[0];
                $s->block = $res3[0];
                array_push($schedule, $s);
        }

        return 0;
}

/**
 * This function loads in a configuration structure the data contained in a
 * file.
 *
 * @param   configuration   Pointer to the configuration structure
 * @param   file            Pointer to the file name string
 *
 * @return  0 if success, -1 if error
 */
function aras_schedule_load_file(&$schedule, $file)
{
        /* Open configuration file */
        if (($fp = fopen($file, "r")) == NULL)
                return -1;

        /* Get lines from configuration file */
        while (($line = fgets($fp)) != NULL) {
                aras_schedule_load_line($schedule, $line);
        }

        /* Close configuration file */
        if (fclose($fp) != 0)
                return -1;

        return 0;
}

function aras_schedule_get_day(&$schedule, &$schedule_day, $day)
{
        for ($k = 0; $k < count($schedule); $k++)
                if (!strcasecmp($schedule[$k]->day, $day ))
                        $schedule_day[] = $schedule[$k];
}

function aras_schedule_sort_by_time(&$schedule)
{
        for ($k = 0; $k < (count($schedule) - 1); $k++)
                for ($l = $k + 1; $l < count($schedule); $l++) {
                        sscanf($schedule[$k]->time, "%d:%d:%d", $h, $m, $s);
                        $t1 = 3600*$h + 60*$m + $s;
                        sscanf($schedule[$l]->time, "%d:%d:%d", $h, $m, $s);
                        $t2 = 3600*$h + 60*$m + $s;
                        if ($t1 > $t2) {
                                $temp = $schedule[$k];
                                $schedule[$k] = $schedule[$l];
                                $schedule[$l] = $temp;
                        }
                }
}

function aras_schedule_write_rows(&$schedule, $name)
{
        $block[] = new aras_block_node();
        $block = [];
        aras_block_load_file($block, "/etc/aras/aras.block");
        aras_block_sort_by_name($block);

        printf('<table class="table_center">');

        printf('<tr>');
        printf('<th>Delete</th>');
        printf('<th>Time</th>');
        printf('<th>Block</th>');
        printf('</tr>');

        printf('<tr>');
        printf('<td>');
        printf('');
        printf('</td>');
        printf('<td>');
        printf('<span title="Time">');
        printf('<p><input type="time" step="1" size="6" name="%s_add[time]" value="%s"</p>', $name, NULL);
        printf('</span>');
        printf('</td>');
        printf('<td>');
        printf('<span title="Select block">');
        aras_block_write_menu($block, sprintf("%s_add[block]", $name), NULL);
        printf('</span>');
        printf('</td>');
        printf('</tr>');
    
        if (count($schedule) > 0) {
                for ($k = 0; $k < count($schedule); $k++) {
                        printf('<tr>');
                        printf('<td>');
                        printf('<span title="Delete">');
                        printf('<input type="checkbox" name="%s[%d][delete]" value="delete">', $name, $k);
                        printf('</span>');
                        printf('</td>');
                        printf('<td>');
                        printf('<span title="Time">');
                        printf('<input type="time" step="1" size="6" name="%s[%d][time]" value="%s"', $name, $k, $schedule[$k]->time);
                        printf('</span>');
                        printf('</td>');
                        printf('<td>');
                        printf('<span title="Select block">');
                        aras_block_write_menu($block, sprintf("%s[%d][block]", $name, $k), $schedule[$k]->block);
                        printf('</span>');
                        printf('</td>');
                        printf('</tr>');
                }
        } else {
                printf('<tr><td colspan="3"><center>No events</center></td></tr>');
        }
        printf('</table>');
}

function aras_schedule_load_post(&$schedule, $post_array, $post_array_add, $day)
{
        /* Existing schedule nodes from post array to aras schedule array */
        for ($k = 0; $k < count($post_array); $k++) {
                if (strcasecmp($post_array[$k]['delete'], 'delete')) {
                        $s = new aras_schedule_node();
                        $s->day = sprintf("%s", $day);
                        $s->time = sprintf("%s", $post_array[$k]['time']);
                        $s->block = sprintf("%s", $post_array[$k]['block']);
                        $schedule[] = $s;
                }
        }

        /* New schedule node from post array add to aras schedule array */
        if (($post_array_add['time'] !='') && ($post_array_add['block'] != '')) {
                $s = new aras_schedule_node();
                $s->day = sprintf("%s", $day);
                $s->time = sprintf("%s", $post_array_add['time']);
                $s->block = sprintf("%s", $post_array_add['block']);
                $schedule[] = $s;
        }
}

?>
