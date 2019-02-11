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
 * Main source file for ARAS Web Service configuration library.
 */

include_once 'parse.php';

define("ARAS_CONFIGURATION_FILE", "/etc/aras/aras.conf");

define("ARAS_CONFIGURATION_MAX_LINE", "2048");
define("ARAS_CONFIGURATION_MAX_DIRECTIVE", "32");
define("ARAS_CONFIGURATION_MAX_ARGUMENT", "1024");

define("ARAS_CONFIGURATION_MODE_DEFAULT_BLOCK_OFF", "0");
define("ARAS_CONFIGURATION_MODE_DEFAULT_BLOCK_ON", "1");

define("ARAS_CONFIGURATION_MODE_SCHEDULE_HARD", "0");
define("ARAS_CONFIGURATION_MODE_SCHEDULE_SOFT", "1");

define("ARAS_CONFIGURATION_MODE_TIME_SIGNAL_OFF", "0");
define("ARAS_CONFIGURATION_MODE_TIME_SIGNAL_HALF", "1");
define("ARAS_CONFIGURATION_MODE_TIME_SIGNAL_HOUR", "2");

define("ARAS_CONFIGURATION_MODE_AUDIO_AUTO", "0");
define("ARAS_CONFIGURATION_MODE_AUDIO_PULSEAUDIO", "1");
define("ARAS_CONFIGURATION_MODE_AUDIO_ALSA", "2");
define("ARAS_CONFIGURATION_MODE_AUDIO_JACK", "3");
define("ARAS_CONFIGURATION_MODE_AUDIO_OSS", "4");
define("ARAS_CONFIGURATION_MODE_AUDIO_OSS4", "5");
define("ARAS_CONFIGURATION_MODE_AUDIO_OPENAL", "6");
define("ARAS_CONFIGURATION_MODE_AUDIO_FILE", "7");

define("ARAS_CONFIGURATION_MODE_VIDEO_AUTO", "0");
define("ARAS_CONFIGURATION_MODE_VIDEO_V4L2", "1");
define("ARAS_CONFIGURATION_MODE_VIDEO_X", "2");
define("ARAS_CONFIGURATION_MODE_VIDEO_XV", "3");
define("ARAS_CONFIGURATION_MODE_VIDEO_FB", "4");
define("ARAS_CONFIGURATION_MODE_VIDEO_GL", "5");
define("ARAS_CONFIGURATION_MODE_VIDEO_FILE", "6");

class aras_configuration {

        /* Configuration files */
        public $configuration_period;
        public $schedule_file;
        public $block_file;
        public $log_file;

        /* Engine configuration */
        public $engine_period;
        public $schedule_mode;
        public $default_block_mode;
        public $default_block;
        public $fade_out_time;
        public $fade_out_slope;
        public $time_signal_mode;
        public $time_signal_advance;
        public $time_signal_block;

        /* Block player configuration */
        public $block_player_name;
        public $block_player_audio_output;
        public $block_player_audio_device;
        public $block_player_volume;
        public $block_player_sample_rate;
        public $block_player_channels;
        public $block_player_video_output;
        public $block_player_video_device;
        public $block_player_video_display;
        public $block_player_display_resolution;

        /* Time signal player configuration */
        public $time_signal_player_name;
        public $time_signal_player_audio_output;
        public $time_signal_player_audio_device;
        public $time_signal_player_volume;
        public $time_signal_player_sample_rate;
        public $time_signal_player_channels;
        public $time_signal_player_video_output;
        public $time_signal_player_video_device;
        public $time_signal_player_video_display;
        public $time_signal_player_display_resolution;

        /* Recorder configuration */
        public $recorder_name;
        public $recorder_input;
        public $recorder_device;
        public $recorder_sample_rate;
        public $recorder_channels;
        public $recorder_quality;

        /* GUI configuration */
        public $gui_period;
};

/**
 * This function sets the configuration_file_period field in a configuration
 * structure.
 *
 * @param   configuration   Pointer to the configuration structure
 * @param   argument        The configuration argument string
 */
function aras_configuration_set_configuration_period(&$configuration, $argument)
{
        $configuration->configuration_period = abs((int)($argument));
}

/**
 * This function sets the schedule_file field in a configuration structure.
 *
 * @param   configuration   Pointer to the configuration structure
 * @param   argument        The configuration argument string
 */
function aras_configuration_set_schedule_file(&$configuration, $argument)
{
        $configuration->schedule_file = $argument;
}

/**
 * This function sets the block_file field in a configuration structure.
 *
 * @param   configuration   Pointer to the configuration structure
 * @param   argument        The configuration argument string
 */
function aras_configuration_set_block_file(&$configuration, $argument)
{
        $configuration->block_file = $argument;
}

/**
 * This function sets the log_file field in a configuration structure.
 *
 * @param   configuration   Pointer to the configuration structure
 * @param   argument        The configuration argument string
 */
function aras_configuration_set_log_file(&$configuration, $argument)
{
        $configuration->log_file = $argument;
}

/**
 * This function sets the schedule_mode field in a configuration structure.
 *
 * @param   configuration   Pointer to the configuration structure
 * @param   argument        The configuration argument string
 */
function aras_configuration_set_schedule_mode(&$configuration, $argument)
{
        if (!strcasecmp($argument, "hard"))
                $configuration->schedule_mode = ARAS_CONFIGURATION_MODE_SCHEDULE_HARD;
        else if (!strcasecmp($argument, "soft"))
                $configuration->schedule_mode = ARAS_CONFIGURATION_MODE_SCHEDULE_SOFT;
        else
                $configuration->schedule_mode = ARAS_CONFIGURATION_MODE_SCHEDULE_HARD;
}

/**
 * This function sets the default_block_mode field in a configuration structure.
 *
 * @param   configuration   Pointer to the configuration structure
 * @param   argument        The configuration argument string
 */
function aras_configuration_set_default_block_mode(&$configuration, $argument)
{
        if (!strcasecmp($argument, "off"))
                $configuration->default_block_mode = ARAS_CONFIGURATION_MODE_DEFAULT_BLOCK_OFF;
        else if (!strcasecmp($argument, "on"))
                $configuration->default_block_mode = ARAS_CONFIGURATION_MODE_DEFAULT_BLOCK_ON;
        else
                $configuration->default_block_mode = ARAS_CONFIGURATION_MODE_DEFAULT_BLOCK_OFF;
}

/**
 * This function sets the default_block field in a configuration structure.
 *
 * @param   configuration   Pointer to the configuration structure
 * @param   argument        The configuration argument string
 */
function aras_configuration_set_default_block(&$configuration, $argument)
{
        $configuration->default_block = $argument;
}

/**
 * This function sets the fade_out_time field in a configuration structure.
 *
 * @param   configuration   Pointer to the configuration structure
 * @param   argument        The configuration argument string
 */
function aras_configuration_set_fade_out_time(&$configuration, $argument)
{
        if ((int)($argument) < 0)
                $configuration->fade_out_time = 0;
        else
                $configuration->fade_out_time = (int)($argument);
}

/**
 * This function sets the fade_out_slope field in a configuration structure.
 *
 * @param   configuration   Pointer to the configuration structure
 * @param   argument        The configuration argument string
 */
function aras_configuration_set_fade_out_slope(&$configuration, $argument)
{
        if ((float)($argument) < 0.0)
                $configuration->fade_out_slope = 0.0;
        else if ((float)($argument) > 1.0)
                $configuration->fade_out_slope = 1.0;
        else
                $configuration->fade_out_slope = (float)($argument);
}

/**
 * This function sets the engine_period field in a configuration structure.
 *
 * @param   configuration   Pointer to the configuration structure
 * @param   argument        The configuration argument string
 */
function aras_configuration_set_engine_period(&$configuration, $argument)
{
        if ((int)($argument) < 0)
                $configuration->engine_period = 0;
        else
                $configuration->engine_period = (int)($argument);
}

/**
 * This function sets the time_signal_mode field in a configuration structure.
 *
 * @param   configuration   Pointer to the configuration structure
 * @param   argument        The configuration argument string
 */
function aras_configuration_set_time_signal_mode(&$configuration, $argument)
{
        if (!strcasecmp($argument, "off"))
                $configuration->time_signal_mode = ARAS_CONFIGURATION_MODE_TIME_SIGNAL_OFF;
        else if (!strcasecmp($argument, "hour"))
                $configuration->time_signal_mode = ARAS_CONFIGURATION_MODE_TIME_SIGNAL_HOUR;
        else if (!strcasecmp($argument, "half"))
                $configuration->time_signal_mode = ARAS_CONFIGURATION_MODE_TIME_SIGNAL_HALF;
        else
                $configuration->time_signal_mode = ARAS_CONFIGURATION_MODE_TIME_SIGNAL_OFF;
}

/**
 * This function sets the time_signal_advance field in a configuration
 * structure.
 *
 * @param   configuration   Pointer to the configuration structure
 * @param   argument        The configuration argument string
 */
function aras_configuration_set_time_signal_advance($configuration, $argument)
{
        if ((int)($argument) < 0)
                $configuration->time_signal_advance = 0;
        else
                $configuration->time_signal_advance = (int)($argument);
}

/**
 * This function sets the time_signal_block field in a configuration structure.
 *
 * @param   configuration   Pointer to the configuration structure
 * @param   argument        The configuration argument string
 */
function aras_configuration_set_time_signal_block(&$configuration, $argument)
{
        $configuration->time_signal_block = $argument;
}

/**
 * This function sets the block_player_name field in a configuration structure.
 *
 * @param   configuration   Pointer to the configuration structure
 * @param   argument        The configuration argument string
 */
function aras_configuration_set_block_player_name(&$configuration, $argument)
{
        $configuration->block_player_name = $argument;
}

/**
 * This function sets the block_player_audio_output field in a configuration
 * structure.
 *
 * @param   configuration   Pointer to the configuration structure
 * @param   argument        The configuration argument string
 */
function aras_configuration_set_block_player_audio_output(&$configuration, $argument)
{

        if (!strcasecmp($argument, "auto"))
                $configuration->block_player_audio_output = ARAS_CONFIGURATION_MODE_AUDIO_AUTO;
        else if (!strcasecmp($argument, "pulseaudio"))
                $configuration->block_player_audio_output = ARAS_CONFIGURATION_MODE_AUDIO_PULSEAUDIO;
        else if (!strcasecmp($argument, "alsa"))
                $configuration->block_player_audio_output = ARAS_CONFIGURATION_MODE_AUDIO_ALSA;
        else if (!strcasecmp($argument, "jack"))
                $configuration->block_player_audio_output = ARAS_CONFIGURATION_MODE_AUDIO_JACK;
        else if (!strcasecmp($argument, "oss"))
                $configuration->block_player_audio_output = ARAS_CONFIGURATION_MODE_AUDIO_OSS;
        else if (!strcasecmp($argument, "oss4"))
                $configuration->block_player_audio_output = ARAS_CONFIGURATION_MODE_AUDIO_OSS4;
        else if (!strcasecmp($argument, "openal"))
                $configuration->block_player_audio_output = ARAS_CONFIGURATION_MODE_AUDIO_OPENAL;
        else if (!strcasecmp($argument, "file"))
                $configuration->block_player_audio_output = ARAS_CONFIGURATION_MODE_AUDIO_FILE;
        else
                $configuration->block_player_audio_output = ARAS_CONFIGURATION_MODE_AUDIO_AUTO;
}

/**
 * This function sets the block_player_audio_device field in a configuration
 * structure.
 *
 * @param   configuration   Pointer to the configuration structure
 * @param   argument        The configuration argument string
 */
function aras_configuration_set_block_player_audio_device(&$configuration, $argument)
{
        $configuration->block_player_audio_device = $argument;
}

/**
 * This function sets the block_player_video_output field in a configuration
 * structure.
 *
 * @param   configuration   Pointer to the configuration structure
 * @param   argument        The configuration argument string
 */
function aras_configuration_set_block_player_video_output(&$configuration, $argument)
{
        if (!strcasecmp($argument, "auto"))
                $configuration->block_player_video_output = ARAS_CONFIGURATION_MODE_VIDEO_AUTO;
        else if (!strcasecmp($argument, "v4l2"))
                $configuration->block_player_video_output = ARAS_CONFIGURATION_MODE_VIDEO_V4L2;
        else if (!strcasecmp($argument, "x"))
                $configuration->block_player_video_output = ARAS_CONFIGURATION_MODE_VIDEO_X;
        else if (!strcasecmp($argument, "xv"))
                $configuration->block_player_video_output = ARAS_CONFIGURATION_MODE_VIDEO_XV;
        else if (!strcasecmp($argument, "fb"))
                $configuration->block_player_video_output = ARAS_CONFIGURATION_MODE_VIDEO_FB;
        else if (!strcasecmp($argument, "gl"))
                $configuration->block_player_video_output = ARAS_CONFIGURATION_MODE_VIDEO_GL;
        else if (!strcasecmp($argument, "file"))
                $configuration->block_player_video_output = ARAS_CONFIGURATION_MODE_VIDEO_FILE;
        else
                $configuration->block_player_video_output = ARAS_CONFIGURATION_MODE_VIDEO_AUTO;
}

/**
 * This function sets the block_player_video_device field in a configuration
 * structure.
 *
 * @param   configuration   Pointer to the configuration structure
 * @param   argument        The configuration argument string
 */
function aras_configuration_set_block_player_video_device(&$configuration, $argument)
{
        $configuration->block_player_video_device = $argument;
}

/**
 * This function sets the block_player_video_display field in a configuration
 * structure.
 *
 * @param   configuration   Pointer to the configuration structure
 * @param   argument        The configuration argument string
 */
function aras_configuration_set_block_player_video_display(&$configuration, $argument)
{
        $configuration->block_player_video_display = $argument;
}

/**
 * This function sets the block_player_volume field in a configuration
 * structure.
 *
 * @param   configuration   Pointer to the configuration structure
 * @param   argument        The configuration argument string
 */
function aras_configuration_set_block_player_volume(&$configuration, $argument)
{
        if ((float)($argument) < 0.0)
                $configuration->block_player_volume = 0.0;
        else if ((float)($argument) > 1.0)
                $configuration->block_player_volume = 1.0;
        else
                $configuration->block_player_volume = (float)($argument);
}

/**
 * This function sets the block_player_sample_rate field in a configuration
 * structure.
 *
 * @param   configuration   Pointer to the configuration structure
 * @param   argument        The configuration argument string
 */
function aras_configuration_set_block_player_sample_rate(&$configuration, $argument)
{
        if ((int)($argument) < 0)
                $configuration->block_player_sample_rate = 0;
        else
                $configuration->block_player_sample_rate = (int)($argument);
}

/**
 * This function sets the block_player_channels field in a configuration
 * structure.
 *
 * @param   configuration   Pointer to the configuration structure
 * @param   argument        To the configuration argument string
 */
function aras_configuration_set_block_player_channels(&$configuration, $argument)
{
        if ((int)($argument) < 0)
                $configuration->block_player_channels = 0;
        else
                $configuration->block_player_channels = (int)($argument);
}

/**
 * This function sets the block_player_display_resolution field in a
 * configuration structure.
 *
 * @param   configuration   Pointer to the configuration structure
 * @param   argument        The configuration argument string
 */
function aras_configuration_set_block_player_display_resolution(&$configuration, $argument)
{
        sscanf($argument, "%dx%d", $width, $height);
        $configuration->block_player_display_resolution[0] = $width;
        $configuration->block_player_display_resolution[1] = $height;
}

/**
 * This function sets the time_signal_player_name field in a configuration
 * structure.
 *
 * @param   configuration   Pointer to the configuration structure
 * @param   argument        The configuration argument string
 */
function aras_configuration_set_time_signal_player_name(&$configuration, $argument)
{
        $configuration->time_signal_player_name = $argument;
}

/**
 * This function sets the time_signal_player_audio_output field in a
 * configuration structure.
 *
 * @param   configuration   Pointer to the configuration structure
 * @param   argument        The configuration argument string
 */
function aras_configuration_set_time_signal_player_audio_output(&$configuration, $argument)
{
        if (!strcasecmp($argument, "auto"))
                $configuration->time_signal_player_audio_output = ARAS_CONFIGURATION_MODE_AUDIO_AUTO;
        else if (!strcasecmp($argument, "pulseaudio"))
                $configuration->time_signal_player_audio_output = ARAS_CONFIGURATION_MODE_AUDIO_PULSEAUDIO;
        else if (!strcasecmp($argument, "alsa"))
                $configuration->time_signal_player_audio_output = ARAS_CONFIGURATION_MODE_AUDIO_ALSA;
        else if (!strcasecmp($argument, "jack"))
                $configuration->time_signal_player_audio_output = ARAS_CONFIGURATION_MODE_AUDIO_JACK;
        else if (!strcasecmp($argument, "oss"))
                $configuration->time_signal_player_audio_output = ARAS_CONFIGURATION_MODE_AUDIO_OSS;
        else if (!strcasecmp($argument, "oss4"))
                $configuration->time_signal_player_audio_output = ARAS_CONFIGURATION_MODE_AUDIO_OSS4;
        else if (!strcasecmp($argument, "openal"))
                $configuration->time_signal_player_audio_output = ARAS_CONFIGURATION_MODE_AUDIO_OPENAL;
        else if (!strcasecmp($argument, "file"))
                $configuration->time_signal_player_audio_output = ARAS_CONFIGURATION_MODE_AUDIO_FILE;
        else
                $configuration->time_signal_player_audio_output = ARAS_CONFIGURATION_MODE_AUDIO_AUTO;
}

/**
 * This function sets the time_signal_player_audio_device field in a
 * configuration structure.
 *
 * @param   configuration   Pointer to the configuration structure
 * @param   argument        The configuration argument string
 */
function aras_configuration_set_time_signal_player_audio_device(&$configuration, $argument)
{
        $configuration->time_signal_player_audio_device = $argument;
}

/**
 * This function sets the time_signal_player_video_output field in a
 * configuration structure.
 *
 * @param   configuration   Pointer to the configuration structure
 * @param   argument        The configuration argument string
 */
function aras_configuration_set_time_signal_player_video_output(&$configuration, $argument)
{
        if (!strcasecmp($argument, "auto"))
                $configuration->time_signal_player_video_output = ARAS_CONFIGURATION_MODE_VIDEO_AUTO;
        else if (!strcasecmp($argument, "v4l2"))
                $configuration->time_signal_player_video_output = ARAS_CONFIGURATION_MODE_VIDEO_V4L2;
        else if (!strcasecmp($argument, "x"))
                $configuration->time_signal_player_video_output = ARAS_CONFIGURATION_MODE_VIDEO_X;
        else if (!strcasecmp($argument, "xv"))
                $configuration->time_signal_player_video_output = ARAS_CONFIGURATION_MODE_VIDEO_XV;
        else if (!strcasecmp($argument, "fb"))
                $configuration->time_signal_player_video_output = ARAS_CONFIGURATION_MODE_VIDEO_FB;
        else if (!strcasecmp($argument, "gl"))
                $configuration->time_signal_player_video_output = ARAS_CONFIGURATION_MODE_VIDEO_GL;
        else if (!strcasecmp($argument, "file"))
                $configuration->time_signal_player_video_output = ARAS_CONFIGURATION_MODE_VIDEO_FILE;
        else
                $configuration->time_signal_player_video_output = ARAS_CONFIGURATION_MODE_AUDIO_AUTO;
}

/**
 * This function sets the time_signal_player_video_device field in a configuration
 * structure.
 *
 * @param   configuration   Pointer to the configuration structure
 * @param   argument        The configuration argument string
 */
function aras_configuration_set_time_signal_player_video_device(&$configuration, $argument)
{
        $configuration->time_signal_player_video_device = $argument;
}

/**
 * This function sets the time_signal_player_video_display field in a configuration
 * structure.
 *
 * @param   configuration   Pointer to the configuration structure
 * @param   argument        The configuration argument string
 */
function aras_configuration_set_time_signal_player_video_display(&$configuration, $argument)
{
        $configuration->time_signal_player_video_display = $argument;
}

/**
 * This function sets the time_signal_player_volume field in a configuration
 * structure.
 *
 * @param   configuration   Pointer to the configuration structure
 * @param   argument        The configuration argument string
 */
function aras_configuration_set_time_signal_player_volume(&$configuration, $argument)
{
        if ((float)($argument) < 0.0)
                $configuration->time_signal_player_volume = 0.0;
        else if ((float)($argument) > 1.0)
                $configuration->time_signal_player_volume = 1.0;
        else
                $configuration->time_signal_player_volume = (float)($argument);
}

/**
 * This function sets the time_signal_player_sample_rate field in a
 * configuration structure.
 *
 * @param   configuration   Pointer to the configuration structure
 * @param   argument        The configuration argument string
 */
function aras_configuration_set_time_signal_player_sample_rate(&$configuration, $argument)
{
        if ((int)($argument) < 0)
                $configuration->time_signal_player_sample_rate = 0;
        else
                $configuration->time_signal_player_sample_rate = (int)($argument);
}

/**
 * This function sets the time_signal_player_channels field in a configuration
 * structure.
 *
 * @param   configuration   Pointer to the configuration structure
 * @param   argument        The configuration argument string
 */
function aras_configuration_set_time_signal_player_channels(&$configuration, $argument)
{
        if ((int)($argument) < 0)
                $configuration->time_signal_player_channels = 0;
        else
                $configuration->time_signal_player_channels = (int)($argument);
}

/**
 * This function sets the time_signal_player_display_resolution field in a
 * configuration structure.
 *
 * @param   configuration   Pointer to the configuration structure
 * @param   argument        The configuration argument string
 */
function aras_configuration_set_time_signal_player_display_resolution(&$configuration, $argument)
{
        sscanf($argument, "%dx%d", $width, $height);
        $configuration->time_signal_player_display_resolution[0] = $width;
        $configuration->time_signal_player_display_resolution[1] = $height;
}

/**
 * This function sets the recoder_name field in a configuration structure.
 *
 * @param   configuration   Pointer to the configuration structure
 * @param   argument        The configuration argument string
 */
function aras_configuration_set_recorder_name(&$configuration, $argument)
{
        $configuration->recorder_name = $argument;
}

/**
 * This function sets the recorder_input field in a configuration structure.
 *
 * @param   configuration   Pointer to the configuration structure
 * @param   argument        The configuration argument string
 */
function aras_configuration_set_recorder_input(&$configuration, $argument)
{
        if (!strcasecmp($argument, "auto"))
                $configuration->recorder_input = ARAS_CONFIGURATION_MODE_AUDIO_AUTO;
        else if (!strcasecmp($argument, "pulseaudio"))
                $configuration->recorder_input = ARAS_CONFIGURATION_MODE_AUDIO_PULSEAUDIO;
        else if (!strcasecmp($argument, "alsa"))
                $configuration->recorder_input = ARAS_CONFIGURATION_MODE_AUDIO_ALSA;
        else if (!strcasecmp($argument, "jack"))
                $configuration->recorder_input = ARAS_CONFIGURATION_MODE_AUDIO_JACK;
        else if (!strcasecmp($argument, "oss"))
                $configuration->recorder_input = ARAS_CONFIGURATION_MODE_AUDIO_OSS;
        else if (!strcasecmp($argument, "oss4"))
                $configuration->recorder_input = ARAS_CONFIGURATION_MODE_AUDIO_OSS4;
        else if (!strcasecmp($argument, "file"))
                $configuration->recorder_input = ARAS_CONFIGURATION_MODE_AUDIO_FILE;
        else
                $configuration->recorder_input = ARAS_CONFIGURATION_MODE_AUDIO_AUTO;
}

/**
 * This function sets the recorder_device field in a configuration structure.
 *
 * @param   configuration   Pointer to the configuration structure
 * @param   argument        The configuration argument string
 */
function aras_configuration_set_recorder_device(&$configuration, $argument)
{
        $configuration->recorder_device = $argument;
}

/**
 * This function sets the recorder_sample_rate field in a configuration
 * structure.
 *
 * @param   configuration   Pointer to the configuration structure
 * @param   argument        The configuration argument string
 */
function aras_configuration_set_recorder_sample_rate(&$configuration, $argument)
{
        if ((int)($argument) < 0)
                $configuration->recorder_sample_rate = 0;
        else
                $configuration->recorder_sample_rate = (int)($argument);
}

/**
 * This function sets the recorder_channels field in a configuration structure.
 *
 * @param   configuration   Pointer to the configuration structure
 * @param   argument        The configuration argument string
 */
function aras_configuration_set_recorder_channels(&$configuration, $argument)
{
        if ((int)($argument) < 0)
                $configuration->recorder_channels = 0;
        else
                $configuration->recorder_channels = (int)($argument);
}

/**
 * This function sets the recorder_quality field in a configuration structure.
 *
 * @param   configuration   Pointer to the configuration structure
 * @param   argument        The configuration argument string
 */
function aras_configuration_set_recorder_quality(&$configuration, $argument)
{
        if ((float)($argument) < -0.1)
                $configuration->recorder_quality = -0.1;
        else if ((float)($argument) > 1.0)
                $configuration->recorder_quality = 1.0;
        else
                $configuration->recorder_quality = (float)($argument);
}

/**
 * This function sets the gui_period field in a configuration structure.
 *
 * @param   configuration   Pointer to the configuration structure
 * @param   argument        The configuration argument string
 */
function aras_configuration_set_gui_period(&$configuration, $argument)
{
        if ((float)($argument) < 0)
                $configuration->gui_period = 0;
        else
                $configuration->gui_period = (float)($argument);
}

/**
 * This function loads in a configuration structure the data contained in a set
 * of strings.
 *
 * @param   configuration   Pointer to the configuration structure
 * @param   directive       The directive string
 * @param   argument        The argument string
 *
 * @return  0 if success, -1 if error
 */
function aras_configuration_load_data(&$configuration, $directive, $argument)
{
        if (!strcasecmp($directive, "ConfigurationPeriod"))
                aras_configuration_set_configuration_period($configuration, $argument);
        else if (!strcasecmp($directive, "ScheduleFile"))
                aras_configuration_set_schedule_file($configuration, $argument);
        else if (!strcasecmp($directive, "BlockFile"))
                aras_configuration_set_block_file($configuration, $argument);
        else if (!strcasecmp($directive, "LogFile"))
                aras_configuration_set_log_file($configuration, $argument);
        else if (!strcasecmp($directive, "EnginePeriod"))
                aras_configuration_set_engine_period($configuration, $argument);
        else if (!strcasecmp($directive, "ScheduleMode"))
                aras_configuration_set_schedule_mode($configuration, $argument);
        else if (!strcasecmp($directive, "DefaultBlockMode"))
                aras_configuration_set_default_block_mode($configuration, $argument);
        else if (!strcasecmp($directive, "DefaultBlock"))
                aras_configuration_set_default_block($configuration, $argument);
        else if (!strcasecmp($directive, "FadeOutTime"))
                aras_configuration_set_fade_out_time($configuration, $argument);
        else if (!strcasecmp($directive, "FadeOutSlope"))
                aras_configuration_set_fade_out_slope($configuration, $argument);
        else if (!strcasecmp($directive, "TimeSignalMode"))
                aras_configuration_set_time_signal_mode($configuration, $argument);
        else if (!strcasecmp($directive, "TimeSignalAdvance"))
                aras_configuration_set_time_signal_advance($configuration, $argument);
        else if (!strcasecmp($directive, "TimeSignalBlock"))
                aras_configuration_set_time_signal_block($configuration, $argument);
        else if (!strcasecmp($directive, "BlockPlayerName"))
                aras_configuration_set_block_player_name($configuration, $argument);
        else if (!strcasecmp($directive, "BlockPlayerAudioOutput"))
                aras_configuration_set_block_player_audio_output($configuration, $argument);
        else if (!strcasecmp($directive, "BlockPlayerAudioDevice"))
                aras_configuration_set_block_player_audio_device($configuration, $argument);
        else if (!strcasecmp($directive, "BlockPlayerVolume"))
                aras_configuration_set_block_player_volume($configuration, $argument);
        else if (!strcasecmp($directive, "BlockPlayerSampleRate"))
                aras_configuration_set_block_player_sample_rate($configuration, $argument);
        else if (!strcasecmp($directive, "BlockPlayerChannels"))
                aras_configuration_set_block_player_channels($configuration, $argument);
        else if (!strcasecmp($directive, "BlockPlayerVideoOutput"))
                aras_configuration_set_block_player_video_output($configuration, $argument);
        else if (!strcasecmp($directive, "BlockPlayerVideoDevice"))
                aras_configuration_set_block_player_video_device($configuration, $argument);
        else if (!strcasecmp($directive, "BlockPlayerVideoDisplay"))
                aras_configuration_set_block_player_video_display($configuration, $argument);
        else if (!strcasecmp($directive, "BlockPlayerDisplayResolution"))
                aras_configuration_set_block_player_display_resolution($configuration, $argument);
        else if (!strcasecmp($directive, "TimeSignalPlayerName"))
                aras_configuration_set_time_signal_player_name($configuration, $argument);
        else if (!strcasecmp($directive, "TimeSignalPlayerAudioOutput"))
                aras_configuration_set_time_signal_player_audio_output($configuration, $argument);
        else if (!strcasecmp($directive, "TimeSignalPlayerAudioDevice"))
                aras_configuration_set_time_signal_player_audio_device($configuration, $argument);
        else if (!strcasecmp($directive, "TimeSignalPlayerVolume"))
                aras_configuration_set_time_signal_player_volume($configuration, $argument);
        else if (!strcasecmp($directive, "TimeSignalPlayerSampleRate"))
                aras_configuration_set_time_signal_player_sample_rate($configuration, $argument);
        else if (!strcasecmp($directive, "TimeSignalPlayerChannels"))
                aras_configuration_set_time_signal_player_channels($configuration, $argument);
        else if (!strcasecmp($directive, "TimeSignalPlayerVideoOutput"))
                aras_configuration_set_time_signal_player_video_output($configuration, $argument);
        else if (!strcasecmp($directive, "TimeSignalPlayerVideoDevice"))
                aras_configuration_set_time_signal_player_video_device($configuration, $argument);
        else if (!strcasecmp($directive, "TimeSignalPlayerVideoDisplay"))
                aras_configuration_set_time_signal_player_video_display($configuration, $argument);
        else if (!strcasecmp($directive, "TimeSignalPlayerDisplayResolution"))
                aras_configuration_set_time_signal_player_display_resolution($configuration, $argument);
        else if (!strcasecmp($directive, "RecorderName"))
                aras_configuration_set_recorder_name($configuration, $argument);
        else if (!strcasecmp($directive, "RecorderInput"))
                aras_configuration_set_recorder_input($configuration, $argument);
        else if (!strcasecmp($directive, "RecorderDevice"))
                aras_configuration_set_recorder_device($configuration, $argument);
        else if (!strcasecmp($directive, "RecorderSampleRate"))
                aras_configuration_set_recorder_sample_rate($configuration, $argument);
        else if (!strcasecmp($directive, "RecorderChannels"))
                aras_configuration_set_recorder_channels($configuration, $argument);
        else if (!strcasecmp($directive, "RecorderQuality"))
                aras_configuration_set_recorder_quality($configuration, $argument);
        else if (!strcasecmp($directive, "GUIPeriod"))
                aras_configuration_set_gui_period($configuration, $argument);
        else
                return -1;

        return 0;
}

/**
 * This function loads in a configuration structure the data contained in a
 * line.
 *
 * @param   configuration   Pointer to the configuration structure
 * @param   line            The line string
 *
 * @return  0 if success, -1 if error
 */
function aras_configuration_load_line(&$configuration, $line)
{

        /* Get directive and argument */
        if (($res1 = aras_parse_line_configuration($line)) == NULL)
                return -1;
        if (($res2 = aras_parse_line_configuration($res1[1])) == NULL)
                return -1;

        aras_configuration_load_data($configuration, $res1[0], $res2[0]);

        return 0;
}

/**
 * This function loads in a configuration structure the data contained in a
 * file.
 *
 * @param   configuration   Pointer to the configuration structure
 * @param   file            The file name string
 *
 * @return  0 if success, -1 if error
 */
function aras_configuration_load_file(&$configuration, $file)
{
        /* Open configuration file */
        if (($fp = fopen($file, "r")) == NULL)
                return -1;

        /* Get lines from configuration file */
        while (($line = fgets($fp)) != NULL) {
                aras_configuration_load_line($configuration, $line);
        }

        /* Close configuration file */
        if (fclose($fp) != 0)
                return -1;

        return 0;
}

function aras_configuration_write_engine_menu($name, $selected)
{
        printf('<select name="%s">', $name);

        printf('<option disabled selected value>Select engine mode</option>');

        if ($selected == ARAS_CONFIGURATION_MODE_SCHEDULE_HARD)
                printf('<option value="hard" selected>');
        else
                printf('<option value="hard">');
        printf('Hard');
        printf('</option>');

        if ($selected == ARAS_CONFIGURATION_MODE_SCHEDULE_SOFT)
                printf('<option value="soft" selected>');
        else
                printf('<option value="soft">');
        printf('Soft');
        printf('</option>');

        printf('</select>');
}

function aras_configuration_write_default_block_mode_menu($name, $selected)
{
        printf('<select name="%s">', $name);

        printf('<option disabled selected value>Select default block mode</option>');

        if ($selected == ARAS_CONFIGURATION_MODE_DEFAULT_BLOCK_OFF)
                printf('<option value="off" selected>');
        else
                printf('<option value="off">');
        printf('Off');
        printf('</option>');

        if ($selected == ARAS_CONFIGURATION_MODE_DEFAULT_BLOCK_ON)
                printf('<option value="on" selected>');
        else
                printf('<option value="on">');
        printf('On');
        printf('</option>');

        printf('</select>');
}

function aras_configuration_write_time_signal_mode_menu($name, $selected)
{
        printf('<select name="%s">', $name);
    
        printf('<option disabled selected value>Select time signal mode</option>');
    
        if ($selected == ARAS_CONFIGURATION_MODE_TIME_SIGNAL_OFF)
                printf('<option value="off" selected>');
        else
                printf('<option value="off">');
        printf('Off');
        printf('</option>');
    
        if ($selected == ARAS_CONFIGURATION_MODE_TIME_SIGNAL_HOUR)
                printf('<option value="hour" selected>');
        else
                printf('<option value="hour">');
        printf('Hour');
        printf('</option>');

        if ($selected == ARAS_CONFIGURATION_MODE_TIME_SIGNAL_HALF)
                printf('<option value="half" selected>');
        else
                printf('<option value="half">');
        printf('Half');
        printf('</option>');
    
        printf('</select>');
}

function aras_configuration_write_audio_menu($name, $selected)
{
        printf('<select name="%s">', $name);
    
        printf('<option disabled selected value>Select audio output</option>');
    
        if ($selected == ARAS_CONFIGURATION_MODE_AUDIO_AUTO)
                printf('<option value="auto" selected>');
        else
                printf('<option value="auto">');
        printf('Auto');
        printf('</option>');
    
        if ($selected == ARAS_CONFIGURATION_MODE_AUDIO_PULSEAUDIO)
                printf('<option value="pulseaudio" selected>');
        else
                printf('<option value="pulseaudio">');
        printf('Pulseaudio');
        printf('</option>');

        if ($selected == ARAS_CONFIGURATION_MODE_AUDIO_ALSA)
                printf('<option value="alsa" selected>');
        else
                printf('<option value="alsa">');
        printf('ALSA');
        printf('</option>');
    
        if ($selected == ARAS_CONFIGURATION_MODE_AUDIO_JACK)
                printf('<option value="jack" selected>');
        else
                printf('<option value="jack">');
        printf('JACK Audio Connection Kit');
        printf('</option>');
    
        if ($selected == ARAS_CONFIGURATION_MODE_AUDIO_OSS)
                printf('<option value="oss" selected>');
        else
                printf('<option value="oss">');
        printf('OSS');
        printf('</option>');
    
        if ($selected == ARAS_CONFIGURATION_MODE_AUDIO_OSS4)
                printf('<option value="oss4" selected>');
        else
                printf('<option value="oss4">');
        printf('OSSv4');
        printf('</option>');
    
        if ($selected == ARAS_CONFIGURATION_MODE_AUDIO_OPENAL)
                printf('<option value="openal" selected>');
        else
                printf('<option value="openal">');
        printf('OpenAL');
        printf('</option>');
                
        if ($selected == ARAS_CONFIGURATION_MODE_AUDIO_FILE)
                printf('<option value="file" selected>');
        else
                printf('<option value="file">');
        printf('File device');
        printf('</option>');

        printf('</select>');
}

function aras_configuration_write_video_menu($name, $selected)
{
        printf('<select name="%s">', $name);

        printf('<option disabled selected value>Select video output</option>');

        if ($selected == ARAS_CONFIGURATION_MODE_VIDEO_AUTO)
                printf('<option value="auto" selected>');
        else
                printf('<option value="auto">');
        printf('Auto');
        printf('</option>');

        if ($selected == ARAS_CONFIGURATION_MODE_VIDEO_V4L2)
                printf('<option value="v4l2" selected>');
        else
                printf('<option value="v4l2">');
        printf('V4L2');
        printf('</option>');

        if ($selected == ARAS_CONFIGURATION_MODE_VIDEO_X)
                printf('<option value="x" selected>');
        else
                printf('<option value="x">');
        printf('X');
        printf('</option>');

        if ($selected == ARAS_CONFIGURATION_MODE_VIDEO_XV)
                printf('<option value="xv" selected>');
        else
                printf('<option value="xv">');
        printf('Xv extension');
        printf('</option>');

        if ($selected == ARAS_CONFIGURATION_MODE_VIDEO_FB)
                printf('<option value="fb" selected>');
        else
                printf('<option value="fb">');
        printf('Linux framebuffer');
        printf('</option>');

        if ($selected == ARAS_CONFIGURATION_MODE_VIDEO_GL)
                printf('<option value="gl" selected>');
        else
                printf('<option value="gl">');
        printf('OpenGL');
        printf('</option>');

        if ($selected == ARAS_CONFIGURATION_MODE_VIDEO_FILE)
                printf('<option value="file" selected>');
        else
                printf('<option value="file">');
        printf('File device');
        printf('</option>');

        printf('</select>');
}

function aras_configuration_load_post(&$configuration, $post_array)
{
        $configuration->configuration_period = $post_array['configuration_period'];
        $configuration->schedule_file = $post_array['schedule_file'];
        $configuration->block_file = $post_array['block_file'];
        $configuration->log_file = $post_array['log_file'];

        $configuration->engine_period = $post_array['engine_period'];
        $configuration->schedule_mode = strtolower($post_array['schedule_mode']);

        $configuration->default_block_mode = strtolower($post_array['default_block_mode']);
        $configuration->default_block = $post_array['default_block'];

        $configuration->fade_out_time = strtolower($post_array['fade_out_time']);
        $configuration->fade_out_slope = strtolower($post_array['fade_out_slope']);

        $configuration->time_signal_mode = strtolower($post_array['time_signal_mode']);
        $configuration->time_signal_block = $post_array['time_signal_block'];
        $configuration->time_signal_advance = strtolower($post_array['time_signal_advance']);

        $configuration->block_player_name = $post_array['block_player_name'];
        $configuration->block_player_audio_output = strtolower($post_array['block_player_audio_output']); /* Audio output in plain text */

        $configuration->block_player_audio_device = strtolower($post_array['block_player_audio_device']);
        $configuration->block_player_volume = strtolower($post_array['block_player_volume']);
        $configuration->block_player_sample_rate = strtolower($post_array['block_player_sample_rate']);
        $configuration->block_player_channels = strtolower($post_array['block_player_channels']);

        $configuration->block_player_video_output = strtolower($post_array['block_player_video_output']); /* Video output in plain text */
        $configuration->block_player_video_device = strtolower($post_array['block_player_video_device']);
        $configuration->block_player_video_display = strtolower($post_array['block_player_video_display']);
        $configuration->block_player_display_resolution[0] = $post_array['block_player_display_resolution'][0];
        $configuration->block_player_display_resolution[1] = $post_array['block_player_display_resolution'][1];

        $configuration->time_signal_player_name = $post_array['time_signal_player_name'];
        $configuration->time_signal_player_audio_output = strtolower($post_array['time_signal_player_audio_output']); /* Audio output in plain text */
        $configuration->time_signal_player_audio_device = strtolower($post_array['time_signal_player_audio_device']);
        $configuration->time_signal_player_volume = strtolower($post_array['time_signal_player_volume']);
        $configuration->time_signal_player_sample_rate = strtolower($post_array['time_signal_player_sample_rate']);
        $configuration->time_signal_player_channels = strtolower($post_array['time_signal_player_channels']);

        $configuration->time_signal_player_video_output = strtolower($post_array['time_signal_player_video_output']);  /* Video output in plain text */
        $configuration->time_signal_player_video_device = strtolower($post_array['time_signal_player_video_device']);
        $configuration->time_signal_player_video_display = strtolower($post_array['time_signal_player_video_display']);
        $configuration->time_signal_player_display_resolution[0] = $post_array['time_signal_player_display_resolution'][0];
        $configuration->time_signal_player_display_resolution[1] = $post_array['time_signal_player_display_resolution'][1];

        $configuration->recorder_name = strtolower($post_array['recorder_name']);
        $configuration->recorder_input = strtolower($post_array['recorder_input']);
        $configuration->recorder_device = strtolower($post_array['recorder_device']);
        $configuration->recorder_quality = strtolower($post_array['recorder_quality']);
        $configuration->recorder_sample_rate = strtolower($post_array['recorder_sample_rate']);
        $configuration->recorder_channels = strtolower($post_array['recorder_channels']);

        $configuration->gui_period = strtolower($post_array['gui_period']);
}

?>
