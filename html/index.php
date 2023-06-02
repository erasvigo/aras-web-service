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
         * Main source file for ARAS Web Service.
         */

        include 'configuration_library.php';
        include 'block_library.php';
        include 'schedule_library.php';

        $configuration = new aras_configuration;
        $block[] = new aras_block_node;
        $schedule[] = new aras_schedule_node;
        $schedule_sunday[] = new aras_schedule_node;
        $schedule_monday[] = new aras_schedule_node;
        $schedule_tuesday[] = new aras_schedule_node;
        $schedule_wednesday[] = new aras_schedule_node;
        $schedule_thursday[] = new aras_schedule_node;
        $schedule_friday[] = new aras_schedule_node;
        $schedule_saturday[] = new aras_schedule_node;

        $notes = [];
        $errors = [];

       /*
        * Form attending section - Configuration
        */

        if (isset($_POST['update-configuration'])) {

                aras_configuration_load_post($configuration, $_POST);

                /* Backup current block file and write a new one */
                copy(ARAS_CONFIGURATION_FILE, sprintf("%s.%s", ARAS_CONFIGURATION_FILE, "bkp"));
                $notes[] = sprintf("Backup of configuration file created: %s", sprintf("%s.%s", ARAS_CONFIGURATION_FILE, "bkp"));

                /* Open schedule file */
                if (($fp = fopen(ARAS_CONFIGURATION_FILE, "w")) == FALSE)
                        $errors[] = sprintf("Error: Block file cannot be opened");

                fwrite($fp, "#########################################\n");
                fwrite($fp, "# The ARAS Radio Automation System      #\n");
                fwrite($fp, "# Configuration file (ARAS Web Service) #\n");
                fwrite($fp, "#########################################\n\n");

                fwrite($fp, "#########################\n");
                fwrite($fp, "# 1 Configuration files #\n");
                fwrite($fp, "#########################\n\n");

                fwrite($fp, sprintf("%-34s %s\n", "ConfigurationPeriod", $configuration->configuration_period));
                fwrite($fp, sprintf("%-34s \"%s\"\n", "ScheduleFile", $configuration->schedule_file));
                fwrite($fp, sprintf("%-34s \"%s\"\n", "BlockFile", $configuration->block_file));
                fwrite($fp, sprintf("%-34s \"%s\"\n", "LogFile", $configuration->log_file));

                fwrite($fp, "\n#####################\n");
                fwrite($fp, "# 2 Global settings #\n");
                fwrite($fp, "#####################\n\n");

                fwrite($fp, sprintf("%-34s %s\n", "EnginePeriod", $configuration->engine_period));
                fwrite($fp, sprintf("%-34s %s\n", "ScheduleMode", $configuration->schedule_mode));
                fwrite($fp, sprintf("%-34s %s\n", "DefaultBlockMode", $configuration->default_block_mode));
                fwrite($fp, sprintf("%-34s \"%s\"\n", "DefaultBlock", $configuration->default_block));
                fwrite($fp, sprintf("%-34s %s\n", "FadeOutTime", $configuration->fade_out_time));
                fwrite($fp, sprintf("%-34s %s\n", "FadeOutSlope", $configuration->fade_out_slope));
                fwrite($fp, sprintf("%-34s %s\n", "TimeSignalMode", $configuration->time_signal_mode));
                fwrite($fp, sprintf("%-34s \"%s\"\n", "TimeSignalBlock", $configuration->time_signal_block));
                fwrite($fp, sprintf("%-34s %s\n", "TimeSignalAdvance", $configuration->time_signal_advance));

                fwrite($fp, "\n##################\n");
                fwrite($fp, "# 3 Block player #\n");
                fwrite($fp, "##################\n\n");

                fwrite($fp, sprintf("%-34s \"%s\"\n", "BlockPlayerName", $configuration->block_player_name));
                fwrite($fp, sprintf("%-34s %s\n", "BlockPlayerAudioOutput", $configuration->block_player_audio_output));
                fwrite($fp, sprintf("%-34s %s\n", "BlockPlayerAudioDevice", $configuration->block_player_audio_device));
                fwrite($fp, sprintf("%-34s %s\n", "BlockPlayerVolume", $configuration->block_player_volume));
                fwrite($fp, sprintf("%-34s %s\n", "BlockPlayerSampleRate", $configuration->block_player_sample_rate));
                fwrite($fp, sprintf("%-34s %s\n", "BlockPlayerChannels", $configuration->block_player_channels));
                fwrite($fp, sprintf("%-34s %s\n", "BlockPlayerVideoOutput", $configuration->block_player_video_output));
                fwrite($fp, sprintf("%-34s %s\n", "BlockPlayerVideoDevice", $configuration->block_player_video_device));
                fwrite($fp, sprintf("%-34s %s\n", "BlockPlayerVideoDisplay", $configuration->block_player_video_display));
                fwrite($fp, sprintf("%-34s %sx%s\n", "BlockPlayerDisplayResolution", $configuration->block_player_display_resolution[0], $configuration->block_player_display_resolution[1]));

                fwrite($fp, "\n########################\n");
                fwrite($fp, "# 4 Time signal player #\n");
                fwrite($fp, "########################\n\n");

                fwrite($fp, sprintf("%-34s \"%s\"\n", "TimeSignalPlayerName", $configuration->time_signal_player_name));
                fwrite($fp, sprintf("%-34s %s\n", "TimeSignalPlayerAudioOutput", $configuration->time_signal_player_audio_output));
                fwrite($fp, sprintf("%-34s %s\n", "TimeSignalPlayerAudioDevice", $configuration->time_signal_player_audio_device));
                fwrite($fp, sprintf("%-34s %s\n", "TimeSignalPlayerVolume", $configuration->time_signal_player_volume));
                fwrite($fp, sprintf("%-34s %s\n", "TimeSignalPlayerSampleRate", $configuration->time_signal_player_sample_rate));
                fwrite($fp, sprintf("%-34s %s\n", "TimeSignalPlayerChannels", $configuration->time_signal_player_channels));
                fwrite($fp, sprintf("%-34s %s\n", "TimeSignalPlayerVideoOutput", $configuration->time_signal_player_video_output));
                fwrite($fp, sprintf("%-34s %s\n", "TimeSignalPlayerVideoDevice", $configuration->time_signal_player_video_device));
                fwrite($fp, sprintf("%-34s %s\n", "TimeSignalPlayerVideoDisplay", $configuration->time_signal_player_video_display));
                fwrite($fp, sprintf("%-34s %sx%s\n", "TimeSignalPlayerDisplayResolution", $configuration->time_signal_player_display_resolution[0], $configuration->time_signal_player_display_resolution[1]));

                fwrite($fp, "\n##############\n");
                fwrite($fp, "# 5 Recorder #\n");
                fwrite($fp, "##############\n\n");

                fwrite($fp, sprintf("%-34s \"%s\"\n", "RecorderName", $configuration->recorder_name));
                fwrite($fp, sprintf("%-34s %s\n", "RecorderInput", $configuration->recorder_input));
                fwrite($fp, sprintf("%-34s %s\n", "RecorderDevice", $configuration->recorder_device));
                fwrite($fp, sprintf("%-34s %s\n", "RecorderQuality", $configuration->recorder_quality));
                fwrite($fp, sprintf("%-34s %s\n", "RecorderSampleRate", $configuration->recorder_sample_rate));
                fwrite($fp, sprintf("%-34s %s\n", "RecorderChannels", $configuration->recorder_channels));

                fwrite($fp, "\n#########\n");
                fwrite($fp, "# 6 GUI #\n");
                fwrite($fp, "#########\n\n");

                fwrite($fp, sprintf("%-34s %s\n", "GUIPeriod", $configuration->gui_period));

                /* Close schedule file */
                if (fclose($fp) == FALSE)
                        $errors[] = sprintf("Error: Block file cannot be closed");

                $notes[] = sprintf("Updated configuration file: %s", ARAS_CONFIGURATION_FILE);

        } else if (isset($_POST['cancel'])) {
                //$notes[] = sprintf("%s", "No changes done in configuration");
        } else {
                //$notes[] = sprintf("%s", "No changes done in configuration");
        }

?>

<?php

        /*
         * Form attending section - Block
         */

        if (isset($_POST['update-block'])) {

                aras_configuration_load_file($configuration, ARAS_CONFIGURATION_FILE);

                $block = [];
                aras_block_load_post($block, $_POST['block'], $_POST['block_add']);
                aras_block_sort_by_name($block);

                /* Backup current block file and write a new one */
                copy($configuration->block_file, sprintf("%s.%s", $configuration->block_file, "bkp"));
                $notes[] = sprintf("Backup of block file created: %s", sprintf("%s.%s", $configuration->block_file, "bkp"));

                /* Open schedule file */
                if (($fp = fopen($configuration->block_file, "w")) == FALSE)
                        $errors[] = sprintf("Error: Block file cannot be opened");

                fwrite($fp, "####################################\n");
                fwrite($fp, "# The ARAS Radio Automation System #\n");
                fwrite($fp, "# Block file (ARAS Web Service)    #\n");
                fwrite($fp, "####################################\n\n");

                for ($k = 0; $k < count($block); $k++) {
                        fwrite($fp, sprintf("%-24s ", sprintf("\"%s\"", $block[$k]->name)));

                        switch ($block[$k]->type) {
                        case ARAS_BLOCK_TYPE_FILE:
                                fwrite($fp, sprintf("%-16s ", "file"));
                                break;
                        case ARAS_BLOCK_TYPE_PLAYLIST:
                                fwrite($fp, sprintf("%-16s ", "playlist"));
                                break;
                        case ARAS_BLOCK_TYPE_RANDOM:
                                fwrite($fp, sprintf("%-16s ", "random"));
                                break;
                        case ARAS_BLOCK_TYPE_RANDOM_FILE:
                                fwrite($fp, sprintf("%-16s ", "randomfile"));
                                break;
                        case ARAS_BLOCK_TYPE_INTERLEAVE:
                                fwrite($fp, sprintf("%-16s ", "interleave"));
                                break;
                        default:
                                break;
                        }

                        fwrite($fp, sprintf("\"%s\"\n", $block[$k]->data));
                }

                /* Close schedule file */
                if (fclose($fp) == FALSE)
                        $errors[] = sprintf("Error: Block file cannot be closed");

                $notes[] = sprintf("Updated block file: %s\n", $configuration->block_file);


        } else if (isset($_POST['cancel'])) {
                //$notes[] = sprintf("%s", "No changes done in block description");
        } else {
                //$notes[] = sprintf("%s", "No changes done in block description");
        }

?>

<?php

       /*
        * Form attending section - Schedule
        */

        if (isset($_POST['update-schedule'])) {

                aras_configuration_load_file($configuration, ARAS_CONFIGURATION_FILE);

                $schedule_sunday = [];
                aras_schedule_load_post($schedule_sunday, $_POST['schedule_sunday'], $_POST['schedule_sunday_add'], 'sunday');
                aras_schedule_sort_by_time($schedule_sunday);

                $schedule_monday = [];
                aras_schedule_load_post($schedule_monday, $_POST['schedule_monday'], $_POST['schedule_monday_add'], 'monday');
                aras_schedule_sort_by_time($schedule_monday);

                $schedule_tuesday = [];
                aras_schedule_load_post($schedule_tuesday, $_POST['schedule_tuesday'], $_POST['schedule_tuesday_add'], 'tuesday');
                aras_schedule_sort_by_time($schedule_tuesday);

                $schedule_wednesday = [];
                aras_schedule_load_post($schedule_wednesday, $_POST['schedule_wednesday'], $_POST['schedule_wednesday_add'], 'wednesday');
                aras_schedule_sort_by_time($schedule_wednesday);

                $schedule_thursday = [];
                aras_schedule_load_post($schedule_thursday, $_POST['schedule_thursday'], $_POST['schedule_thursday_add'], 'thursday');
                aras_schedule_sort_by_time($schedule_thursday);

                $schedule_friday = [];
                aras_schedule_load_post($schedule_friday, $_POST['schedule_friday'], $_POST['schedule_friday_add'], 'friday');
                aras_schedule_sort_by_time($schedule_friday);

                $schedule_saturday = [];
                aras_schedule_load_post($schedule_saturday, $_POST['schedule_saturday'], $_POST['schedule_saturday_add'], 'saturday');
                aras_schedule_sort_by_time($schedule_saturday);

                /* Backup current schedule file and write a new one */
                copy($configuration->schedule_file, sprintf("%s.%s", $configuration->schedule_file, "bkp"));
                $notes[] = sprintf("Backup of schedule file created: %s", sprintf("%s.%s", $configuration->schedule_file, "bkp"));

                /* Open schedule file */
                if (($fp = fopen($configuration->schedule_file, "w")) == FALSE)
                        $errors[] = sprintf("Error: Schedule file cannot be opened");

                fwrite($fp, "####################################\n");
                fwrite($fp, "# The ARAS Radio Automation System #\n");
                fwrite($fp, "# Schedule file (ARAS Web Service) #\n");
                fwrite($fp, "####################################\n\n");

                fwrite($fp, "\n");
                fwrite($fp, "##########\n");
                fwrite($fp, "# Sunday #\n");
                fwrite($fp, "##########\n\n");
                for ($k = 0; $k < count($schedule_sunday); $k++)
                        fwrite($fp, sprintf("%-9s %-8s \"%s\"\n", 'sunday' , $schedule_sunday[$k]->time, $schedule_sunday[$k]->block));

                fwrite($fp, "\n");
                fwrite($fp, "##########\n");
                fwrite($fp, "# Monday #\n");
                fwrite($fp, "##########\n\n");
                for ($k = 0; $k < count($schedule_monday); $k++)
                        fwrite($fp, sprintf("%-9s %-8s \"%s\"\n", 'monday' , $schedule_monday[$k]->time, $schedule_monday[$k]->block));

                fwrite($fp, "\n");
                fwrite($fp, "###########\n");
                fwrite($fp, "# Tuesday #\n");
                fwrite($fp, "###########\n\n");
                for ($k = 0; $k < count($schedule_tuesday); $k++)
                        fwrite($fp, sprintf("%-9s %-8s \"%s\"\n", 'tuesday' , $schedule_tuesday[$k]->time, $schedule_tuesday[$k]->block));

                fwrite($fp, "\n");
                fwrite($fp, "#############\n");
                fwrite($fp, "# Wednesday #\n");
                fwrite($fp, "#############\n\n");
                for ($k = 0; $k < count($schedule_wednesday); $k++)
                        fwrite($fp, sprintf("%-9s %-8s \"%s\"\n", 'wednesday' , $schedule_wednesday[$k]->time, $schedule_wednesday[$k]->block));

                fwrite($fp, "\n");
                fwrite($fp, "############\n");
                fwrite($fp, "# Thursday #\n");
                fwrite($fp, "############\n\n");
                for ($k = 0; $k < count($schedule_thursday); $k++)
                        fwrite($fp, sprintf("%-9s %-8s \"%s\"\n", 'thursday' , $schedule_thursday[$k]->time, $schedule_thursday[$k]->block));

                fwrite($fp, "\n");
                fwrite($fp, "##########\n");
                fwrite($fp, "# Friday #\n");
                fwrite($fp, "##########\n\n");
                for ($k = 0; $k < count($schedule_friday); $k++)
                        fwrite($fp, sprintf("%-9s %-8s \"%s\"\n", 'friday' , $schedule_friday[$k]->time, $schedule_friday[$k]->block));

                fwrite($fp, "\n");
                fwrite($fp, "############\n");
                fwrite($fp, "# Saturday #\n");
                fwrite($fp, "############\n\n");
                for ($k = 0; $k < count($schedule_saturday); $k++)
                        fwrite($fp, sprintf("%-9s %-8s \"%s\"\n", 'saturday' , $schedule_saturday[$k]->time, $schedule_saturday[$k]->block));

                /* Close schedule file */
                if (fclose($fp) == FALSE)
                        $errors[] = sprintf("Error: Schedule file cannot be closed");

                $notes[] = sprintf("Updated schedule file: %s\n", $configuration->schedule_file);

        } else if (isset($_POST['cancel'])) {
                //$notes[] = sprintf("%s", "No changes done in schedule");
        } else {
                //$notes[] = sprintf("%s", "No changes done in schedule");
        }

?>

<?php

        /*
         * Form presentation section - Configuration
         */

        aras_configuration_load_file($configuration, ARAS_CONFIGURATION_FILE);
?>


<?php

        /*
         * Form presentation section - Block
         */

        $block = [];
        aras_block_load_file($block, $configuration->block_file);
        aras_block_sort_by_name($block);

?>

<?php

        /*
         * Form presentation section - Schedule
         */

        $schedule = [];
        aras_schedule_load_file($schedule, $configuration->schedule_file);

        $schedule_sunday = [];
        aras_schedule_get_day($schedule, $schedule_sunday, "sunday");
        aras_schedule_sort_by_time($schedule_sunday);

        $schedule_monday = [];
        aras_schedule_get_day($schedule, $schedule_monday, "monday");
        aras_schedule_sort_by_time($schedule_monday);

        $schedule_tuesday = [];
        aras_schedule_get_day($schedule, $schedule_tuesday, "tuesday");
        aras_schedule_sort_by_time($schedule_tuesday);

        $schedule_wednesday = [];
        aras_schedule_get_day($schedule, $schedule_wednesday, "wednesday");
        aras_schedule_sort_by_time($schedule_wednesday);

        $schedule_thursday = [];
        aras_schedule_get_day($schedule, $schedule_thursday, "thursday");
        aras_schedule_sort_by_time($schedule_thursday);

        $schedule_friday = [];
        aras_schedule_get_day($schedule, $schedule_friday, "friday");
        aras_schedule_sort_by_time($schedule_friday);

        $schedule_saturday = [];
        aras_schedule_get_day($schedule, $schedule_saturday, "saturday");
        aras_schedule_sort_by_time($schedule_saturday);

?>

<!DOCTYPE html>
<html>
<head>
        <title>ARAS Web Service</title>
        <link rel="stylesheet" type="text/css" href="aras.css" media="screen" />

</head>
<body>

        <div class="sidebar">
                <a class="active">ARAS Web Service</a>
                <a href="#top">Home</a>
                <a href="#configuration">Configuration</a>
                <a href="#block">Block editor</a>
                <a href="#schedule">Schedule editor</a>
        </div>

        <div class="content">
                <a name="top"></a>
                <h2>ARAS Web Service</h2>

                <?php
                        for ($k = 0; $k < count($errors); $k++)
                                printf("<table class=\"error\" ><tr><td>%s</td></tr></table>\n", $errors[$k]);

                        for ($k = 0; $k < count($notes); $k++)
                                printf("<table class=\"note\" ><tr><td>%s</td></tr></table>\n", $notes[$k]);
                ?>

                <a name="configuration"></a><h3>Configuration</h3>

                <form method="post" action="index.php#configuration">
                <p><input class="button" type="submit" name="update-configuration" value="Update"><input class="button" type="submit" name="cancel" value="Cancel"></p>
                <table class="table_left">
                        <tr>
                                <td>Configuration period (ms)</td>
                                <td>
                                        <span title="The configuration refresh period in miliseconds">
                                        <input type="number" min="100" max="10000" step="10" name="configuration_period" value="<?php printf($configuration->configuration_period); ?>">
                                        </span>
                                </td>
                        </tr>
                        <tr>
                                <td>Schedule file</td>
                                <td>
                                        <span title="Local path for the schedule file, by default is /etc/aras/aras.schedule">
                                        <input type="text" name="schedule_file" value="<?php printf($configuration->schedule_file); ?>" name="schedule_file">
                                        </span>
                                </td>
                        </tr>
                        <tr>
                                <td>Block description file</td>
                                <td>
                                        <span title="Local path for the block description file, by default is /etc/aras/aras.block">
                                        <input type="text" name="block_file" value="<?php printf($configuration->block_file); ?>" name="block_file">
                                        </span>
                                </td>
                        </tr>
                        <tr>
                                <td>Log file</td>
                                <td>
                                        <span title="Local path for the log file, by default is /var/log/aras/aras.log">
                                        <input type="text" name="log_file" value="<?php printf($configuration->log_file); ?>" name="log_file">
                                        </span>
                                </td>
                        </tr>
                        <tr>
                                <td>Engine period (ms)</td>
                                <td><span title="The engine tick period in miliseconds"><input type="number" min="1" max="1000" step="1" value="<?php printf($configuration->engine_period); ?>" name="engine_period"></span></td>
                        </tr>
                        <tr>
                                <td>Engine mode</td>
                                <td><span title="The schedule mode: Hard (blocks are finished when a new block arrives), Soft (blocks are played to the end)">
                                        <?php
                                                aras_configuration_write_engine_menu("schedule_mode", $configuration->schedule_mode);
                                        ?>
                                </span></td>
                        </tr>
                        <tr>
                                <td>Default block mode</td>
                                <td><span title="Default block mode: Off, On">
                                    <?php
                                            aras_configuration_write_default_block_mode_menu("default_block_mode", $configuration->default_block_mode);
                                    ?>
                                </span></td>
                        </tr>
                        <tr>
                                <td>Default block</td>
                                <td><span title="The name of the default block, played by default before other block arrives">
                                        <?php
                                                aras_block_write_menu($block, "default_block", $configuration->default_block);
                                        ?>
                                </span></td>
                        </tr>
                        <tr>
                                <td>Fade out time (ms)</td>
                                <td><span title="The face out time in miliseconds"><input type="number" min="100" max="10000" step="100" value="<?php printf($configuration->fade_out_time); ?>" name="fade_out_time"></span></td>
                        </tr>
                        <tr>
                                <td>Fade out slope</td>
                                <td><span title="The face out slope"><input type="number" min="0.1" max="0.9" step="0.01" value="<?php printf($configuration->fade_out_slope); ?>" name="fade_out_slope"></span></td>
                        </tr>
                        <tr>
                        <td>Time signal mode</td>
                                <td><span title="Time signal mode: Off, Hour, Half">
                                        <?php
                                                aras_configuration_write_time_signal_mode_menu("time_signal_mode", $configuration->time_signal_mode);
                                        ?>
                                </span></td>
                        </tr>
                        <tr>
                                <td>Time signal block</td>
                                <td><span title="The name of the time signal block, played each hour or half hour according to the Time signal mode configuration">
                                        <?php
                                                aras_block_write_menu($block, "time_signal_block", $configuration->time_signal_block);
                                        ?>
                                </span></td>
                        </tr>
                        <tr>
                                <td>Time signal advance (ms)</td>
                                <td><span title="The time signal advance time in miliseconds"><input type="number" min="100" max="10000" step="100" value="<?php printf($configuration->time_signal_advance); ?>" name="time_signal_advance"></span></td>
                        </tr>
                        <tr>
                                <td>Block player name</td>
                                <td><span title="The name of the block player"><input type="text" value="<?php printf($configuration->block_player_name); ?>" name="block_player_name"></span></td>
                        </tr>
                        <tr>
                        <td>Block player audio output</td>
                                <td><span title="Block player audio output">
                                        <?php
                                                aras_configuration_write_audio_menu("block_player_audio_output", $configuration->block_player_audio_output);
                                        ?>
                                </span></td>
                        </tr>
                        <tr>
                                <td>Block player audio device</td>
                                <td><span title="Block player audio device according to block player audio output"><input type="text" value="<?php printf($configuration->block_player_audio_device); ?>" name="block_player_audio_device"></span></td>
                        </tr>
                        <tr>
                                <td>Block player volume</td>
                                <td><span title="The block player volume"><input type="number" min="0.0" max="1.0" step="0.01" value="<?php printf($configuration->block_player_volume); ?>" name="block_player_volume"></span></td>
                        </tr>
                        <tr>
                                <td>Block player sample rate</td>
                                <td><span title="Block player sample rate"><input type="number" min="0" max="5644800" step="1" value="<?php printf($configuration->block_player_sample_rate); ?>" name="block_player_sample_rate"></span></td>
                        </tr>
                        <tr>
                                <td>Block player channels</td>
                                <td><span title="Block player channels"><input type="number" min="0" max="32" step="1" value="<?php printf($configuration->block_player_channels); ?>" name="block_player_channels"></span></td>
                        </tr>
                        <tr>
                        <td>Block player video output</td>
                                <td><span title="Block player video output">
                                        <?php
                                                aras_configuration_write_video_menu("block_player_video_output", $configuration->block_player_video_output);
                                        ?>
                                </span></td>
                        </tr>
                        <tr>
                                <td>Block player video device</td>
                                <td><span title="Block player video device according to block player video output"><input type="text" value="<?php printf($configuration->block_player_video_device); ?>" name="block_player_video_device"></span></td>
                        </tr>
                        <tr>
                                <td>Block player video display</td>
                                <td><span title="Block player video display according to block player video output"><input type="text" value="<?php printf($configuration->block_player_video_display); ?>" name="block_player_video_display"></span></td>
                        </tr>
                        <tr>
                                <td>Block player display resolution</td>
                                <td><span title="Block player display resolution (width)"><input type="text" value="<?php printf($configuration->block_player_display_resolution[0]); ?>" name="block_player_display_resolution[0]" size="8"></span>
                                <span title="Block player display resolution (height)"><input type="text" value="<?php printf($configuration->block_player_display_resolution[1]); ?>" name="block_player_display_resolution[1]" size="8"></span></td>
                        </tr>
                        <tr>
                                <td>Time signal player name</td>
                                <td><span title="The name of the time_signal player"><input type="text" value="<?php printf($configuration->time_signal_player_name); ?>" name="time_signal_player_name"></span></td>
                        </tr>
                        <tr>
                        <td>Time signal player audio output</td>
                                <td><span title="Time signal player audio output">
                                        <?php
                                                aras_configuration_write_audio_menu("time_signal_player_audio_output", $configuration->time_signal_player_audio_output);
                                        ?>
                                </span></td>
                        </tr>
                        <tr>
                                <td>Time signal player audio device</td>
                                <td><span title="Time signal player audio device according to time signal player audio output"><input type="text" value="<?php printf($configuration->time_signal_player_audio_device); ?>" name="time_signal_player_audio_device"></span></td>
                        </tr>
                        <tr>
                                <td>Time signal player volume</td>
                                <td><span title="The time signal player volume"><input type="number" min="0.0" max="1.0" step="0.01" value="<?php printf($configuration->time_signal_player_volume); ?>" name="time_signal_player_volume"></span></td>
                        </tr>
                        <tr>
                                <td>Time signal player sample rate</td>
                                <td><span title="Time signal player sample rate"><input type="number" min="0" max="5644800" step="1" value="<?php printf($configuration->time_signal_player_sample_rate); ?>" name="time_signal_player_sample_rate"></span></td>
                        </tr>
                        <tr>
                                <td>Time signal player channels</td>
                                <td><span title="Time signal player channels"><input type="number" min="0" max="32" step="1" value="<?php printf($configuration->time_signal_player_channels); ?>" name="time_signal_player_channels"></span></td>
                        </tr>
                        <tr>
                        <td>Time signal player video output</td>
                                <td><span title="Time signal player video output">
                                        <?php
                                                aras_configuration_write_video_menu("time_signal_player_video_output", $configuration->time_signal_player_video_output);
                                        ?>
                                </span></td>
                        </tr>
                        <tr>
                                <td>Time signal player video device</td>
                                <td><span title="Time signal player video device according to block player video output"><input type="text" value="<?php printf($configuration->time_signal_player_video_device); ?>" name="time_signal_player_video_device"></span></td>
                        </tr>
                        <tr>
                                <td>Time signal player video display</td>
                                <td><span title="Time signal player video display according to block player video output"><input type="text" value="<?php printf($configuration->time_signal_player_video_display); ?>" name="time_signal_player_video_display"></span></td>
                        </tr>
                        <tr>
                                <td>Time signal player display resolution</td>
                                <td><span title="Time signal player display resolution (width)"><input type="text" value="<?php printf($configuration->time_signal_player_display_resolution[0]); ?>" name="time_signal_player_display_resolution[0]" size="8"></span>
                                <span title="Time signal player display resolution (height)"><input type="text" value="<?php printf($configuration->time_signal_player_display_resolution[1]); ?>" name="time_signal_player_display_resolution[1]" size="8"></span></td>
                        </tr>
                        <tr>
                                <td>Recorder name</td>
                                <td><span title="Recorder name"><input type="text" value="<?php printf($configuration->recorder_name); ?>" name="recorder_name"></span></td>
                        </tr>
                        <tr>
                        <td>Recorder input</td>
                                <td><span title="Recorder input">
                                        <?php
                                                aras_configuration_write_audio_menu("recorder_input", $configuration->recorder_input);
                                        ?>
                                </span></td>
                        </tr>
                        <tr>
                                <td>Recorder device</td>
                                <td><span title="Recorder device according to recorder audio input"><input type="text" value="<?php printf($configuration->recorder_device); ?>" name="recorder_device"></span></td>
                        </tr>
                        <tr>
                                <td>Recorder quality</td>
                                <td><span title="Recorder quality"><input type="number" min="-0.1" max="1.0" step="0.1" value="<?php printf($configuration->recorder_quality); ?>" name="recorder_quality"></span></td>
                        </tr>
                        <tr>
                                <td>Recorder sample rate</td>
                                <td><span title="Recorder sample rate"><input type="number" min="0" max="5644800" step="1" value="<?php printf($configuration->recorder_sample_rate); ?>" name="recorder_sample_rate"></span></td>
                        </tr>
                        <tr>
                                <td>Recorder channels</td>
                                <td><span title="Recorder channels"><input type="number" min="0" max="32" step="1" value="<?php printf($configuration->recorder_channels); ?>" name="recorder_channels"></span></td>
                        </tr>
                        <tr>
                                <td>GUI period (ms)</td>
                                <td><span title="The GUI refresh period in miliseconds"><input type="number" min="10" max="1000" step="10" value="<?php printf($configuration->gui_period); ?>" name="gui_period"></span></td>
                        </tr>
                </table>
                <p><a href="#top">top</a> | <a href="#configuration">configuration</a></p>
                </form>


                <a name="block"></a><h3>Block editor</h3>

                <table class="table_left">
                        <tr style="background-color:#0000ff"><th>Block type</th><th>Block data</th></tr>
                        <tr><td>File</td><td>URI or path for local media file</td></tr>
                        <tr><td>Playlist</td><td>Path for local m3u playlist, containing URIs or local files</td></tr>
                        <tr><td>Random</td><td>Path for local direcotry</td></tr>
                        <tr><td>Random file</td><td>Path for local directory</td></tr>
                        <tr><td>Interleave</td><td>Two blocks and their multiplicities. Use simple quotation marks as delimiters for block names. For example: 'block 1' 'block 2' 1 3</td></tr>
                </table>

                <form method="post" action="index.php#block">
                        <p><input class="button" type="submit" name="update-block" value="Update"><input class="button" type="submit" name="cancel" value="Cancel"></p>
                        <?php
                        aras_block_write_rows($block);
                        ?>
                </form>
                <p><a href="#top">top</a> | <a href="#block">block editor</a></p>

                <a name="schedule"></a><h3>Schedule editor</h3>

                <form method="post" action="index.php#schedule">

                        <p><input class="button" type="submit" name="update-schedule" value="Update"><input class="button" type="submit" name="cancel" value="Cancel"></p>

                        <table class="table_hidden"><tr><td class="header">Sunday</td><tr><td>
                        <?php aras_schedule_write_rows($schedule_sunday, "schedule_sunday"); ?>
                        </td></tr></table><table class="table_hidden"><tr><td class="header">Monday</td><tr><td>
                        <?php aras_schedule_write_rows($schedule_monday, "schedule_monday"); ?>
                        </td></tr></table><table class="table_hidden"><tr><td class="header">Tuesday</td><tr><td>
                        <?php aras_schedule_write_rows($schedule_tuesday, "schedule_tuesday"); ?>
                        </td></tr></table><table class="table_hidden"><tr><td class="header">Wednesday</td><tr><td>
                        <?php aras_schedule_write_rows($schedule_wednesday, "schedule_wednesday"); ?>
                        </td></tr></table><table class="table_hidden"><tr><td class="header">Thursday</td><tr><td>
                        <?php aras_schedule_write_rows($schedule_thursday, "schedule_thursday"); ?>
                        </td></tr></table><table class="table_hidden"><tr><td class="header">Friday</td><tr><td>
                        <?php aras_schedule_write_rows($schedule_friday, "schedule_friday"); ?>
                        </td></tr></table><table class="table_hidden"><tr><td class="header">Saturday</td><tr><td>
                        <?php aras_schedule_write_rows($schedule_saturday, "schedule_saturday"); ?>
                        </td></tr></table>
                </form>
                <p><a href="#top">top</a> | <a href="#schedule">schedule editor</a></p>

                </div>

        </body>
</html>

