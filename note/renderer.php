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
 * to key signatures.
 *
 * @package    qtype
 * @subpackage musictheory
 * @copyright  2014 Eric Brisson
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();

require_once(dirname(dirname(__FILE__)) . '/renderer.php');

/**
 * Renders music theory note writing questions.
 *
 * @copyright  2014 Eric Brisson
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class qtype_musictheory_note_write_renderer extends qtype_musictheory_renderer {

    public function formulation_and_controls(question_attempt $qa,
            question_display_options $options) {

        global $PAGE, $OUTPUT;

        $PAGE->requires->yui_module('moodle-qtype_musictheory-musictheoryui', 'M.qtype_musictheory.musictheoryui.init');

        $inputname = $qa->get_qt_field_name('answer');
        $question = $qa->get_question();
        $initialinput = $qa->get_last_qt_var('answer');
        $correctresponsearray = $question->get_correct_response();
        $correctresponse = $correctresponsearray['answer'];

        $correctansstr = ($question->musictheory_considerregister) ? 'correctansweris' : 'correctansweris_morethanone';
        $moduleparams = array(
            $inputname,
            $question->musictheory_optionsxml,
            $options->readonly,
            $initialinput,
            $correctresponse,
            get_string($correctansstr, 'qtype_musictheory')
        );
        $qtypemod = 'moodle-qtype_musictheory-musictheoryqtype';
        $rendernamespace = 'M.qtype_musictheory.musictheoryqtype.initQuestionRender';
        $PAGE->requires->yui_module($qtypemod, $rendernamespace, $moduleparams);

        $inputattributes = array(
            'type'  => 'text',
            'name'  => $inputname,
            'value' => $initialinput,
            'id'    => $inputname,
            'size'  => 4
        );

        if ($options->readonly) {
            $inputattributes['readonly'] = 'readonly';
        }

        $questiontext = $question->format_questiontext($qa);
        $input = html_writer::empty_tag('hidden', $inputattributes);
        $result = html_writer::tag('div', $questiontext, array('class' => 'qtext'));

        $nonjavascriptdivattr = array(
            'id'    => 'musictheory_div_replacedbycanvas_' . $inputname,
            'class' => 'ablock'
        );

        $result .= html_writer::start_tag('div', $nonjavascriptdivattr);
        $result .= $input;
        $result .= html_writer::end_tag('div');

        $javascriptdivattr = array(
            'id'    => 'musictheory_div_canvas_' . $inputname,
            'class' => 'ablock',
            'style' => 'display:none'
        );
        $result .= html_writer::start_tag('div', $javascriptdivattr);
        if (!$options->readonly) {
            $result .= $OUTPUT->help_icon('note_write_questionasui', 'qtype_musictheory', '');
        }
        $result .= html_writer::end_tag('div');

        if ($qa->get_state() == question_state::$invalid) {
            $result .= html_writer::nonempty_tag('div', $question->get_validation_error(array('answer' => $initialinput)), array('class' => 'validationerror'));
        }

        return $result;
    }

    public function correct_response(question_attempt $qa) {
        $question = $qa->get_question();
        $correctresponsearray = $question->get_correct_response();
        $correctansstr = ($question->musictheory_considerregister) ? 'correctansweris' : 'correctansweris_morethanone';
        return get_string($correctansstr, 'qtype_musictheory') . ' ' .
                $correctresponsearray['answer'];
    }

}

/**
 * Renders music theory note identification questions.
 *
 * @copyright  2014 Eric Brisson
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class qtype_musictheory_note_identify_renderer extends qtype_musictheory_renderer {

    public function formulation_and_controls(question_attempt $qa,
            question_display_options $options) {


        global $PAGE;

        $PAGE->requires->yui_module('moodle-qtype_musictheory-musictheoryui', 'M.qtype_musictheory.musictheoryui.init');

        $question = $qa->get_question();

        $ltrselectid = $qa->get_qt_field_name('musictheory_answer_ltr');
        $accselectid = $qa->get_qt_field_name('musictheory_answer_acc');
        if ($question->musictheory_considerregister) {
            $regselectid = $qa->get_qt_field_name('musictheory_answer_reg');
        }


        $ltr = $question->musictheory_givennoteletter;
        $acc = $question->musictheory_givennoteaccidental;
        $reg = $question->musictheory_givennoteregister;

        $moduleparams = array(
            $ltrselectid,
            $question->musictheory_optionsxml,
            true,
            $ltr . $acc . $reg,
            null,
            get_string('correctansweris', 'qtype_musictheory'),
            true
        );
        $qtypemod = 'moodle-qtype_musictheory-musictheoryqtype';
        $rendernamespace = 'M.qtype_musictheory.musictheoryqtype.initQuestionRender';
        $PAGE->requires->yui_module($qtypemod, $rendernamespace, $moduleparams);

        $selectoptionsltr = array(
            ''  => '',
            'C' => get_string('noteC', 'qtype_musictheory'),
            'D' => get_string('noteD', 'qtype_musictheory'),
            'E' => get_string('noteE', 'qtype_musictheory'),
            'F' => get_string('noteF', 'qtype_musictheory'),
            'G' => get_string('noteG', 'qtype_musictheory'),
            'A' => get_string('noteA', 'qtype_musictheory'),
            'B' => get_string('noteB', 'qtype_musictheory')
        );

        $ltrselectattributes = array(
            'name' => $ltrselectid,
            'id'   => $ltrselectid
        );

        $selectoptionsacc = array(
            ''   => '',
            'n'  => get_string('acc_n', 'qtype_musictheory'),
            '#'  => get_string('acc_sharp', 'qtype_musictheory'),
            'b'  => get_string('acc_b', 'qtype_musictheory'),
            'x'  => get_string('acc_x', 'qtype_musictheory'),
            'bb' => get_string('acc_bb', 'qtype_musictheory'),
        );

        $accselectattributes = array(
            'name' => $accselectid,
            'id'   => $accselectid
        );

        if ($question->musictheory_considerregister) {
            $selectoptionsreg = array(
                ''  => '',
                '2' => '2',
                '3' => '3',
                '4' => '4',
                '5' => '5',
                '6' => '6',
            );

            $regselectattributes = array(
                'name' => $regselectid,
                'id'   => $regselectid
            );
        }

        if ($options->readonly) {
            $ltrselectattributes['disabled'] = 'true';
            $accselectattributes['disabled'] = 'true';
            if ($question->musictheory_considerregister) {
                $regselectattributes['disabled'] = 'true';
            }
        }

        $questiontext = $question->format_questiontext($qa);
        $result = html_writer::tag('div', $questiontext, array('class' => 'qtext'));

        $javascriptdivattr = array(
            'id'    => 'musictheory_div_canvas_' . $ltrselectid,
            'class' => 'ablock',
            'style' => 'display:none'
        );
        $result .= html_writer::tag('div', '', $javascriptdivattr);

        $currltr = $qa->get_last_qt_var('musictheory_answer_ltr');
        $curracc = $qa->get_last_qt_var('musictheory_answer_acc');
        $currreg = $qa->get_last_qt_var('musictheory_answer_reg');
        $input = html_writer::select($selectoptionsltr, $ltrselectid, $currltr, true, $ltrselectattributes);
        $input .= html_writer::select($selectoptionsacc, $accselectid, $curracc, true, $accselectattributes);
        if ($question->musictheory_considerregister) {
            $input .= html_writer::select($selectoptionsreg, $regselectid, $currreg, true, $regselectattributes);
        }
        $result .= html_writer::start_tag('div', array('class' => 'ablock'));
        $result .= $input;
        $result .= html_writer::end_tag('div');

        if ($qa->get_state() == question_state::$invalid) {
            $currentltr = $qa->get_last_qt_var('musictheory_answer_ltr');
            $currentacc = $qa->get_last_qt_var('musictheory_answer_acc');
            if ($question->musictheory_considerregister) {
                $currentreg = $qa->get_last_qt_var('musictheory_answer_reg');
            }
            if ($question->musictheory_considerregister) {
                $answerarray = array(
                    'musictheory_answer_ltr' => $currentltr,
                    'musictheory_answer_acc' => $currentacc,
                    'musictheory_answer_reg' => $currentreg
                );
            } else {
                $answerarray = array(
                    'musictheory_answer_ltr' => $currentltr,
                    'musictheory_answer_acc' => $currentacc
                );
            }
            $result .= html_writer::nonempty_tag('div', $question->get_validation_error($answerarray), array('class' => 'validationerror'));
        }

        return $result;
    }

    public function correct_response(question_attempt $qa) {
        $question = $qa->get_question();
        $correctresponsearray = $question->get_correct_response();
        $keymode = str_replace('#', 'sharp', $correctresponsearray['answer']);
        $correctresponse = get_string($keymode, 'qtype_musictheory');
        return get_string('correctansweris', 'qtype_musictheory') . ' <b>' . $correctresponse . '</b>';
    }

}