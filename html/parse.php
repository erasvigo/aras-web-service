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
 * Main source file for ARAS Web Service parse library.
 */

/**
 * This function receives a pointer to a string and a pointer to a buffer, it
 * looks for the next field in the string, if found, it copies the field to the
 * buffer and returns a pointer to the inmediately subsequent character in the
 * string, if not found, it returns a null pointer.
 *
 * @param   str     The pointer to the input string
 *
 * @return  The pointer to the buffer where the field is copied
 */
function aras_parse_line_configuration($str)
{
        $pos = 0;

        /* Return if an input argument is NULL */
        if (($str === '') || ($buf === ''))
                return '';

        /* Jump over leading blank characters */

        $str = trim($str,"\t ");

        /* Copy the field in the buffer */
        switch ($str[0]) {
        case '#':
                $buf = "";
                return NULL;
                break;
        case '\n':
                $buf = "";
                return NULL;
                break;
        case '\0':
                $buf = "";
                return NULL;
                break;
        case '"':
                $str = ltrim($str, "\"");
                $buf = substr($str, 0, strpos($str, "\""));
                $str = strpbrk($str,"\"");
                return array($buf, ltrim($str, "\""));
                break;
        case '\'':
                $str = ltrim($str, "'");
                $buf = substr($str, 0, strpos($str, "'"));
                $str = strpbrk($str,"'");
                return array($buf, ltrim($str, "'"));
                break;
        case '(':
                $str = ltrim($str, "(");
                $buf = substr($str, 0, strpos($str, ")"));
                $str = strpbrk($str,")");
                return array($buf, ltrim($str, "\)"));
                break;
        default:
                if (strpos($str, strpbrk($str, " \t\n")) == TRUE) {
                        $buf = substr($str, 0, strpos($str, strpbrk($str, " \t\n")));
                        $str = strpbrk($str, " \t\n");
                } else {
                        $buf = $str;
                        $str = "";
                }
                return array($buf, $str);
                break;
        }
}

?>
