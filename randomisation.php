<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * @package    qtype
 * @subpackage musictheory
 * @copyright  2013 Eric Brisson
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();

/*
 * Static class taking care of generating valid random options
 * for music theory question subtypes.
 *
 * @copyright  2013 Eric Brisson
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class qtype_musictheory_randomiser {

    /**
     * Given an array of options, randomly returns one array value
     *
     * @param array $possibleoptions The options to randomly select from.
     * @return object The randomly selected array value.
     */
    public static function get_random_field($possibleoptions) {
        return $possibleoptions[rand(0, count($possibleoptions) - 1)];
    }

    /**
     * Returns a random key.
     *
     * @param array $possiblemodes The possible modes to choose from.
     * @param boolean $includeemptykeysignatures Indicates whether the keys with
     * empty key signatures should be considered.
     * @return string The randomly selected key.
     */
    public static function get_random_key($possiblemodes, $includeemptykeysignature) {
        $modeid = rand(0, count($possiblemodes) - 1);
        $mode = $possiblemodes[$modeid];
        $possiblekeys = Tonality::getValidKeys($mode);
        if (!$includeemptykeysignature) {
            array_shift($possiblekeys);
        }
        $key = $possiblekeys[rand(0, count($possiblekeys) - 1)];
        $tonic = substr((string) $key->getTonic(), 0, 2);
        $modestr = ($key->isMajor()) ? 'M' : 'm';
        return $tonic . $modestr;
    }

    /**
     * Returns a given note for interval questions.
     *
     * @param string $clef The clef to work with - used to determine the
     * given note's register, to ensure that a randomly chosen interval
     * fits in the staff.
     * @param string $direction The direction to work with - used to determine
     * the given note's register, to ensure that a randomly chosen interval
     * fits in the staff.
     * @return string The randomly selected key.
     */
    public static function get_random_interval_givennote($clef, $direction) {
        $tonic = self::get_random_tonic('M');
        if ($direction == 'above') {
            switch ($clef) {
                case 'treble':
                    $reg = 4;
                    break;
                case 'bass':
                    $reg = 2;
                    break;
                case 'alto':
                case 'tenor':
                    $reg = 3;
                    break;
            }
        } else {
            switch ($clef) {
                case 'treble':
                    $reg = 5;
                    break;
                case 'bass':
                    $reg = 3;
                    break;
                case 'alto':
                case 'tenor':
                    $reg = 4;
                    break;
            }
        }
        $givennote = new Note($tonic->getLetter(), $tonic->getAccidental(), $reg);
        return $givennote;
    }

    /**
     * Returns a random interval.
     *
     * @param array $possiblequalities The possible interval qualities to
     * choose from.
     * @param array $possiblesizes The possible interval sizes to
     * choose from.
     * @return array The randomly selected interval, with two keys,
     * 'quality' and 'size'.
     */
    public static function get_random_interval($possiblequalities, $possiblesizes) {
        $validcombos = array();

        foreach ($possiblequalities as $quality) {
            foreach ($possiblesizes as $size) {
                if (Interval::valid_interval($quality, $size)) {
                    $combo = array(
                        'quality' => $quality,
                        'size'    => $size
                    );
                    array_push($validcombos, $combo);
                }
            }
        }
        return self::get_random_field($validcombos);
    }

    /**
     * Returns a random scale tonic.
     *
     * @param string $mode The mode of the scale.
     * @param string $clef The clef that will be used to display the
     * scale.
     * @return Note The randomly selected tonic.
     */
    public static function get_random_scale_tonic($mode, $clef) {
        switch ($clef) {
            case 'treble':
                $reg = 4;
                break;
            case 'bass':
                $reg = 2;
                break;
            case 'alto':
            case 'tenor':
                $reg = 3;
                break;
        }

        $tonic = self::get_random_tonic($mode);
        $givennote = new Note($tonic->getLetter(), $tonic->getAccidental(), $reg);
        return $givennote;
    }

    /**
     * Given a mode, returns a randomly selected tonic in that mode.
     *
     * @param string $mode The given mode to choose the tonic from.
     * @return Note The randomly selected tonic.
     */
    private static function get_random_tonic($mode) {
        $tonics = Tonality::getValidKeys($mode);
        $rand = rand(0, count($tonics) - 1);
        $tonic = $tonics[$rand]->getTonic();
        return $tonic;
    }

}