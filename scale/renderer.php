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
 * This defines renderer classes for music theory question subtypes related
 * to scales.
 *
 * @package    qtype
 * @subpackage musictheory
 * @copyright  2013 Eric Brisson
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();

require_once(dirname(dirname(__FILE__)) . '/renderer.php');

/**
 * Renders music theory scale writing questions.
 *
 * @copyright  2013 Eric Brisson
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class qtype_musictheory_scale_write_renderer extends qtype_musictheory_renderer {

    public function formulation_and_controls(question_attempt $qa, question_display_options $options) {

        global $PAGE, $OUTPUT;

        $PAGE->requires->yui_module('moodle-qtype_musictheory-musictheoryui', 'M.qtype_musictheory.musictheoryui.init');

        $inputname = $qa->get_qt_field_name('answer');
        $question = $qa->get_question();
        $initialinput = $qa->get_last_qt_var('answer');
        if ($options->rightanswer) {
            $correctresponsearray = $question->get_correct_response();
            $correctresponse = $correctresponsearray['answer'];
        } else {
            $correctresponse = null;
        }

        $moduleparams = array(
            array(
                'inputname'        => $inputname,
                'optionsxml'       => $question->musictheory_optionsxml,
                'readonly'         => $options->readonly,
                'initialinput'     => $initialinput,
                'correctresponse'  => $correctresponse,
                'correctrespstr'   => get_string('correctansweris', 'qtype_musictheory'),
                'additionalparams' => array(
                )
            )
        );

        $qtypemod = 'moodle-qtype_musictheory-musictheoryqtype';
        $rendernamespace = 'M.qtype_musictheory.musictheoryqtype.initQuestionRender';
        $PAGE->requires->yui_module($qtypemod, $rendernamespace, $moduleparams);

        $inputattributes = array(
            'type'  => 'text',
            'name'  => $inputname,
            'value' => $initialinput,
            'id'    => $inputname,
            'size'  => 70
        );

        if ($options->readonly) {
            $inputattributes['readonly'] = 'readonly';
        }

        $questiontext = $question->format_questiontext($qa);
        $input = html_writer::empty_tag('input', $inputattributes);
        $result = html_writer::tag('div', $questiontext, array('class' => 'qtext'));

        $nonjavascriptdivattr = array(
            'id'    => 'musictheory_div_replacedbycanvas_' . $inputname,
            'class' => 'ablock'
        );

        $tonic = $question->musictheory_givennoteletter;
        $acc = $question->musictheory_givennoteaccidental;
        $tonic .= $acc . $question->musictheory_givennoteregister;
        $result .= html_writer::start_tag('div', $nonjavascriptdivattr);
        $result .= '<b>' . get_string('tonic', 'qtype_musictheory') . ' = ' . $tonic . '</b>&nbsp;' . $input;
        if (!$options->readonly) {
            $result .= $OUTPUT->help_icon('scale_write_questionastext', 'qtype_musictheory', '');
        }
        $result .= html_writer::end_tag('div');

        $javascriptdivattr = array(
            'id'    => 'musictheory_div_canvas_' . $inputname,
            'class' => 'ablock',
            'style' => 'display:none'
        );
        $result .= html_writer::start_tag('div', $javascriptdivattr);
        if (!$options->readonly) {
            $result .= $OUTPUT->help_icon('scale_write_questionasui', 'qtype_musictheory', '');
        }
        $result .= html_writer::end_tag('div');

        if ($qa->get_state() == question_state::$invalid) {
            $result .= html_writer::nonempty_tag('div', $question->get_validation_error(array('answer' => $initialinput)),
                                                                                        array('class' => 'validationerror'));
        }

        return $result;
    }

    public function correct_response(question_attempt $qa) {
        $question = $qa->get_question();
        $correctresponsearray = $question->get_correct_response();
        return get_string('correctansweris', 'qtype_musictheory') . ' ' .
                $correctresponsearray['answer'];
    }

}
