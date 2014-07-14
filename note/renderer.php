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
 * to notes/pitch.
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
		if ($options->rightanswer) {
			$correctresponsearray = $question->get_correct_response();
			$correctresponse = $correctresponsearray['answer'];
		} else {
			$correctresponse = null;
		}

		$correctansstr = ($question->musictheory_considerregister) ? 'correctansweris' : 'correctansweris_morethanone';

		$moduleparams = array(
			array(
				'inputname'			 => $inputname,
				'optionsxml'		 => $question->musictheory_optionsxml,
				'readonly'			 => $options->readonly,
				'initialinput'		 => $initialinput,
				'correctresponse'	 => $correctresponse,
				'correctrespstr'	 => get_string('correctansweris', 'qtype_musictheory'),
				'additionalparams'	 => array(
				)
			)
		);

		$qtypemod = 'moodle-qtype_musictheory-musictheoryqtype';
		$rendernamespace = 'M.qtype_musictheory.musictheoryqtype.initQuestionRender';
		$PAGE->requires->yui_module($qtypemod, $rendernamespace, $moduleparams);

		$inputattributes = array(
			'type'	 => 'hidden',
			'name'	 => $inputname,
			'value'	 => $initialinput,
			'id'	 => $inputname
		);

		if ($options->readonly) {
			$inputattributes['readonly'] = 'readonly';
		}

		$questiontext = $question->format_questiontext($qa);
		$input = html_writer::empty_tag('input', $inputattributes);
		$result = html_writer::tag('div', $questiontext, array('class' => 'qtext'));

		$nonjavascriptdivattr = array(
			'id'	 => 'musictheory_div_replacedbycanvas_' . $inputname,
			'class'	 => 'ablock'
		);

		$result .= html_writer::start_tag('div', $nonjavascriptdivattr);
		$result .= $input;
		$result .= get_string('javascriptrequired', 'qtype_musictheory');
		$result .= html_writer::end_tag('div');

		$javascriptdivattr = array(
			'id'	 => 'musictheory_div_canvas_' . $inputname,
			'class'	 => 'ablock',
			'style'	 => 'display:none'
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

		if ($question->musictheory_includealterations) {
			$accselectid = $qa->get_qt_field_name('musictheory_answer_acc');
		}

		if ($question->musictheory_considerregister) {
			$regselectid = $qa->get_qt_field_name('musictheory_answer_reg');
		}


		$ltr = $question->musictheory_givennoteletter;
		$acc = $question->musictheory_givennoteaccidental;
		$reg = $question->musictheory_givennoteregister;

		$moduleparams = array(
			array(
				'inputname'			 => $ltrselectid,
				'optionsxml'		 => $question->musictheory_optionsxml,
				'readonly'			 => true,
				'initialinput'		 => $ltr . $acc . $reg,
				'correctresponse'	 => null,
				'correctrespstr'	 => get_string('correctansweris', 'qtype_musictheory'),
				'additionalparams'	 => array(
				)
			)
		);
		$qtypemod = 'moodle-qtype_musictheory-musictheoryqtype';
		$rendernamespace = 'M.qtype_musictheory.musictheoryqtype.initQuestionRender';
		$PAGE->requires->yui_module($qtypemod, $rendernamespace, $moduleparams);

		$selectoptionsltr = array(
			''	 => '',
			'C'	 => get_string('noteC', 'qtype_musictheory'),
			'D'	 => get_string('noteD', 'qtype_musictheory'),
			'E'	 => get_string('noteE', 'qtype_musictheory'),
			'F'	 => get_string('noteF', 'qtype_musictheory'),
			'G'	 => get_string('noteG', 'qtype_musictheory'),
			'A'	 => get_string('noteA', 'qtype_musictheory'),
			'B'	 => get_string('noteB', 'qtype_musictheory')
		);

		$ltrselectattributes = array(
			'name'	 => $ltrselectid,
			'id'	 => $ltrselectid
		);

		if ($question->musictheory_includealterations) {
			$selectoptionsacc = array(
				''	 => '',
				'n'	 => get_string('acc_n', 'qtype_musictheory'),
				'#'	 => get_string('acc_sharp', 'qtype_musictheory'),
				'b'	 => get_string('acc_b', 'qtype_musictheory'),
				'x'	 => get_string('acc_x', 'qtype_musictheory'),
				'bb' => get_string('acc_bb', 'qtype_musictheory'),
			);

			$accselectattributes = array(
				'name'	 => $accselectid,
				'id'	 => $accselectid
			);
		}

		if ($question->musictheory_considerregister) {
			$selectoptionsreg = array(
				''	 => '',
				'1'	 => '1',
				'2'	 => '2',
				'3'	 => '3',
				'4'	 => '4',
				'5'	 => '5',
				'6'	 => '6',
			);

			$regselectattributes = array(
				'name'	 => $regselectid,
				'id'	 => $regselectid
			);
		}

		if ($options->readonly) {
			$ltrselectattributes['disabled'] = 'true';
			if ($question->musictheory_includealterations) {
				$accselectattributes['disabled'] = 'true';
			}
			if ($question->musictheory_considerregister) {
				$regselectattributes['disabled'] = 'true';
			}
		}

		$questiontext = $question->format_questiontext($qa);
		$result = html_writer::tag('div', $questiontext, array('class' => 'qtext'));

		$ltrinputname = $qa->get_qt_field_name('musictheory_answer_ltr');
		$nonjavascriptdivattr = array(
			'id'	 => 'musictheory_div_replacedbycanvas_' . $ltrinputname,
			'class'	 => 'ablock'
		);

		$result .= html_writer::start_tag('div', $nonjavascriptdivattr);
		$result .= get_string('javascriptrequired', 'qtype_musictheory');
		$result .= html_writer::end_tag('div');

		$javascriptdivattr = array(
			'id'	 => 'musictheory_div_canvas_' . $ltrselectid,
			'class'	 => 'ablock',
			'style'	 => 'display:none'
		);
		$result .= html_writer::tag('div', '', $javascriptdivattr);

		$currltr = $qa->get_last_qt_var('musictheory_answer_ltr');
		$curracc = $qa->get_last_qt_var('musictheory_answer_acc');
		$currreg = $qa->get_last_qt_var('musictheory_answer_reg');
		$input = html_writer::select($selectoptionsltr, $ltrselectid, $currltr, true, $ltrselectattributes);
		if ($question->musictheory_includealterations) {
			$input .= html_writer::select($selectoptionsacc, $accselectid, $curracc, true, $accselectattributes);
		}
		if ($question->musictheory_considerregister) {
			$input .= html_writer::select($selectoptionsreg, $regselectid, $currreg, true, $regselectattributes);
		}
		$result .= html_writer::start_tag('div', array('class' => 'ablock'));
		$result .= $input;
		$result .= html_writer::end_tag('div');

		if ($qa->get_state() == question_state::$invalid) {
			$currentltr = $qa->get_last_qt_var('musictheory_answer_ltr');
			if ($question->musictheory_includealterations) {
				$currentacc = $qa->get_last_qt_var('musictheory_answer_acc');
			}
			if ($question->musictheory_considerregister) {
				$currentreg = $qa->get_last_qt_var('musictheory_answer_reg');
			}
			$answerarray = array();
			$answerarray['musictheory_answer_ltr'] = $currentltr;

			if ($question->musictheory_includealterations) {
				$answerarray['musictheory_answer_acc'] = $currentacc;
			}
			if ($question->musictheory_considerregister) {
				$answerarray['musictheory_answer_reg'] = $currentreg;
			}
			$result .= html_writer::nonempty_tag('div', $question->get_validation_error($answerarray), array('class' => 'validationerror'));
		}

		return $result;
	}

	public function correct_response(question_attempt $qa) {
		$question = $qa->get_question();
		$correctresponsearray = $question->get_correct_response();
		$ltr = get_string('note' . $correctresponsearray['musictheory_answer_ltr'], 'qtype_musictheory');
		if ($question->musictheory_includealterations) {
			$acckey = str_replace('#', 'sharp', $correctresponsearray['musictheory_answer_acc']);
			$acc = get_string('acc_' . $acckey, 'qtype_musictheory');
		} else {
			$acc = '';
		}
		if ($question->musictheory_considerregister) {
			$reg = $correctresponsearray['musictheory_answer_reg'];
		} else {
			$reg = '';
		}
		$note = $ltr . $acc . $reg;
		return get_string('correctansweris', 'qtype_musictheory') . ' <b>' . $note . '</b>';
	}

}