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

require_once(__DIR__ . '/question.php');

/**
 * Musictheory question editing form definition.
 *
 * @copyright  2013 Eric Brisson
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class qtype_musictheory_edit_form extends question_edit_form {

	/**
	 * Build the form definition.
	 *
	 * Overridden to remove required field validation for question text.
	 */
	protected function definition() {
		global $COURSE, $CFG, $DB, $PAGE;

		$qtype = $this->qtype();
		$langfile = "qtype_$qtype";

		$mform = $this->_form;

		// Standard fields at the start of the form.
		$mform->addElement('header', 'generalheader', get_string("general", 'form'));

		if (!isset($this->question->id)) {
			if (!empty($this->question->formoptions->mustbeusable)) {
				$contexts = $this->contexts->having_add_and_use();
			} else {
				$contexts = $this->contexts->having_cap('moodle/question:add');
			}

			// Adding question.
			$mform->addElement('questioncategory', 'category', get_string('category', 'question'), array('contexts' => $contexts));
		} else if (!($this->question->formoptions->canmove ||
				$this->question->formoptions->cansaveasnew)) {
			// Editing question with no permission to move from category.
			$mform->addElement('questioncategory', 'category', get_string('category', 'question'), array('contexts' => array($this->categorycontext)));
		} else {
			// Editing question with permission to move from category or save as new q.
			$currentgrp = array();
			$currentgrp[0] = $mform->createElement('questioncategory', 'category', get_string('categorycurrent', 'question'), array('contexts' => array($this->categorycontext)));
			if ($this->question->formoptions->canedit ||
					$this->question->formoptions->cansaveasnew) {
				// Not move only form.
				$currentgrp[1] = $mform->createElement('checkbox', 'usecurrentcat', '', get_string('categorycurrentuse', 'question'));
				$mform->setDefault('usecurrentcat', 1);
			}
			$currentgrp[0]->freeze();
			$currentgrp[0]->setPersistantFreeze(false);
			$mform->addGroup($currentgrp, 'currentgrp', get_string('categorycurrent', 'question'), null, false);

			$mform->addElement('questioncategory', 'categorymoveto', get_string('categorymoveto', 'question'), array('contexts' => array($this->categorycontext)));
			if ($this->question->formoptions->canedit ||
					$this->question->formoptions->cansaveasnew) {
				// Not move only form.
				$mform->disabledIf('categorymoveto', 'usecurrentcat', 'checked');
			}
		}

		$mform->addElement('text', 'name', get_string('questionname', 'question'), array('size'		 => 50, 'maxlength'	 => 255));
		$mform->setType('name', PARAM_TEXT);
		$mform->addRule('name', null, 'required', null, 'client');

		$mform->addElement('editor', 'questiontext', get_string('questiontext', 'question'), array('rows' => 15), $this->editoroptions);
		$mform->setType('questiontext', PARAM_RAW);

		//Override
		//$mform->addRule('questiontext', null, 'required', null, 'client');

		$mform->addElement('text', 'defaultmark', get_string('defaultmark', 'question'), array('size' => 7));
		$mform->setType('defaultmark', PARAM_FLOAT);
		$mform->setDefault('defaultmark', 1);
		$mform->addRule('defaultmark', null, 'required', null, 'client');

		$mform->addElement('editor', 'generalfeedback', get_string('generalfeedback', 'question'), array('rows' => 10), $this->editoroptions);
		$mform->setType('generalfeedback', PARAM_RAW);
		$mform->addHelpButton('generalfeedback', 'generalfeedback', 'question');

		// Any questiontype specific fields.
		$this->definition_inner($mform);

		if (!empty($CFG->usetags)) {
			$mform->addElement('header', 'tagsheader', get_string('tags'));
			$mform->addElement('tags', 'tags', get_string('tags'));
		}

		if (!empty($this->question->id)) {
			$mform->addElement('header', 'createdmodifiedheader', get_string('createdmodifiedheader', 'question'));
			$a = new stdClass();
			if (!empty($this->question->createdby)) {
				$a->time = userdate($this->question->timecreated);
				$a->user = fullname($DB->get_record(
								'user', array('id' => $this->question->createdby)));
			} else {
				$a->time = get_string('unknown', 'question');
				$a->user = get_string('unknown', 'question');
			}
			$mform->addElement('static', 'created', get_string('created', 'question'), get_string('byandon', 'question', $a));
			if (!empty($this->question->modifiedby)) {
				$a = new stdClass();
				$a->time = userdate($this->question->timemodified);
				$a->user = fullname($DB->get_record(
								'user', array('id' => $this->question->modifiedby)));
				$mform->addElement('static', 'modified', get_string('modified', 'question'), get_string('byandon', 'question', $a));
			}
		}

		$this->add_hidden_fields();

		$mform->addElement('hidden', 'qtype');
		$mform->setType('qtype', PARAM_ALPHA);

		$mform->addElement('hidden', 'makecopy');
		$mform->setType('makecopy', PARAM_INT);

		$buttonarray = array();
		$buttonarray[] = $mform->createElement('submit', 'updatebutton', get_string('savechangesandcontinueediting', 'question'));
		if ($this->can_preview()) {
			$previewlink = $PAGE->get_renderer('core_question')->question_preview_link(
					$this->question->id, $this->context, true);
			$buttonarray[] = $mform->createElement('static', 'previewlink', '', $previewlink);
		}

		$mform->addGroup($buttonarray, 'updatebuttonar', '', array(' '), false);
		$mform->closeHeaderBefore('updatebuttonar');

		$this->add_action_buttons(true, get_string('savechanges'));

		if ((!empty($this->question->id)) && (!($this->question->formoptions->canedit ||
				$this->question->formoptions->cansaveasnew))) {
			$mform->hardFreezeAllVisibleExcept(array('categorymoveto', 'buttonar', 'currentgrp'));
		}
	}

	protected function definition_inner($mform) {

		global $PAGE;

		$PAGE->requires->yui_module('moodle-qtype_musictheory-musictheoryqtype', 'M.qtype_musictheory.musictheoryqtype.initEditForm');

		$mform->addElement('header', 'hdrquestionoptions', get_string('questionoptions', 'qtype_musictheory'));

		$mform->setExpanded('hdrquestionoptions');

		if (!isset($this->question->options)) {
			$selectoptionsqtype = array(
				'note-write'						 => get_string('qtype_note-write', 'qtype_musictheory'),
				'note-write-random'					 => get_string('qtype_note-write-random', 'qtype_musictheory'),
				'note-identify'						 => get_string('qtype_note-identify', 'qtype_musictheory'),
				'note-identify-random'				 => get_string('qtype_note-identify-random', 'qtype_musictheory'),
				'keyboard-input'					 => get_string('qtype_keyboard-input', 'qtype_musictheory'),
				'keysignature-write'				 => get_string('qtype_keysignature-write', 'qtype_musictheory'),
				'keysignature-write-random'			 => get_string('qtype_keysignature-write-random', 'qtype_musictheory'),
				'keysignature-identify'				 => get_string('qtype_keysignature-identify', 'qtype_musictheory'),
				'keysignature-identify-random'		 => get_string('qtype_keysignature-identify-random', 'qtype_musictheory'),
				'interval-write'					 => get_string('qtype_interval-write', 'qtype_musictheory'),
				'interval-write-random'				 => get_string('qtype_interval-write-random', 'qtype_musictheory'),
				'interval-identify'					 => get_string('qtype_interval-identify', 'qtype_musictheory'),
				'interval-identify-random'			 => get_string('qtype_interval-identify-random', 'qtype_musictheory'),
				'scale-write'						 => get_string('qtype_scale-write', 'qtype_musictheory'),
				'scale-write-random'				 => get_string('qtype_scale-write-random', 'qtype_musictheory'),
				'chordquality-write'				 => get_string('qtype_chordquality-write', 'qtype_musictheory'),
				'chordquality-write-random'			 => get_string('qtype_chordquality-write-random', 'qtype_musictheory'),
				'chordquality-identify'				 => get_string('qtype_chordquality-identify', 'qtype_musictheory'),
				'chordquality-identify-random'		 => get_string('qtype_chordquality-identify-random', 'qtype_musictheory'),
				'harmonicfunction-write'			 => get_string('qtype_harmonicfunction-write', 'qtype_musictheory'),
				'harmonicfunction-write-random'		 => get_string('qtype_harmonicfunction-write-random', 'qtype_musictheory'),
				'harmonicfunction-identify'			 => get_string('qtype_harmonicfunction-identify', 'qtype_musictheory'),
				'harmonicfunction-identify-random'	 => get_string('qtype_harmonicfunction-identify-random', 'qtype_musictheory'),
			);

			$musicqtypeselect = $mform->createElement('select', 'musictheory_musicqtype', '', $selectoptionsqtype);

			$btnmusicqtype = 'musictheory_updatemusicqtype';
			$btnqtypestring = get_string('updatemusicqtype', 'qtype_musictheory');
			$mform->registerNoSubmitButton($btnmusicqtype);
			$btnupdateqtype = $mform->createElement('submit', $btnmusicqtype, $btnqtypestring);

			$musicqtypearray = array();
			$musicqtypearray[] = & $musicqtypeselect;
			$musicqtypearray[] = & $btnupdateqtype;
			$typelabel = get_string('musicqtype', 'qtype_musictheory');
			$mform->addGroup($musicqtypearray, 'musictheory_musicqtypeelementgroup', $typelabel, array(' '), false);
			$mform->addRule('musictheory_musicqtypeelementgroup', null, 'required', null, 'client');
		} else {
			// Disable the music question type option during an existing question edit, to avoid
			// existing question attempts behaving unexpectedly.
			$text = get_string('qtype_' . $this->question->options->musictheory_musicqtype, 'qtype_musictheory');
			$label = get_string('musicqtype', 'qtype_musictheory');
			$mform->addElement('static', 'staticelement_musicqtype', $label, $text);
			$musicqtype = $this->question->options->musictheory_musicqtype;
			$mform->addElement('hidden', 'musictheory_musicqtype', $musicqtype, 'qtype_musictheory');
			$mform->setType('musictheory_musicqtype', PARAM_TEXT);
		}

		$currentmusicqtype = optional_param('musictheory_musicqtype', '', PARAM_TEXT);
		if ($currentmusicqtype == '') {
			if (isset($this->question->options->musictheory_musicqtype)) {
				$currentmusicqtype = $this->question->options->musictheory_musicqtype;
			} else {
				$currentmusicqtype = 'note-write';
			}
		}

		$qu = null;
		if (!isset($this->options->question)) {
			$st = new qtype_musictheory_strategy_all_or_nothing();
			$class = 'qtype_musictheory_' . str_replace('-', '_', $currentmusicqtype);
			$qu = new $class($st);
		} else {
			$qu = $this->options->question;
		}
		$supportedgradingstrategies = $qu->get_supported_grading_strategies();
		$selectoptionsgradingstrategy = array();
		foreach ($supportedgradingstrategies as $strategyid) {
			$selectoptionsgradingstrategy[$strategyid] = get_string($strategyid, 'qtype_musictheory');
		}

		$strlbl = get_string('musictheory_gradingstrategy', 'qtype_musictheory');
		$mform->addElement('select', 'musictheory_gradingstrategy', $strlbl, $selectoptionsgradingstrategy);
		$mform->addRule('musictheory_gradingstrategy', null, 'required', null, 'client');
		if (count($selectoptionsgradingstrategy) > 1) {
			$helplbl = 'musictheory_gradingstrategy_' . $currentmusicqtype;
			if (strpos($helplbl, '-random')) {
				$helplbl = substr($helplbl, 0, strlen($helplbl) - 7);
			}
			$mform->addHelpButton('musictheory_gradingstrategy', $helplbl, 'qtype_musictheory');
		} else {
			$mform->addHelpButton('musictheory_gradingstrategy', 'musictheory_gradingstrategy', 'qtype_musictheory');
		}

		switch ($currentmusicqtype) {
			case 'note-write':
				$this->add_note_write_options($mform);
				break;
			case 'note-identify':
				$this->add_note_identification_options($mform);
				break;
			case 'note-write-random':
			case 'note-identify-random':
				$this->add_note_write_random_options($mform);
				break;
			case 'keyboard-input':
				$this->add_keyboard_input_options($mform);
				break;
			case 'keysignature-write':
				$this->add_keysignature_write_options($mform);
				break;
			case 'keysignature-write-random':
			case 'keysignature-identify-random':
				$this->add_keysignature_write_identify_random_options($mform);
				break;
			case 'keysignature-identify':
				$this->add_keysignature_identify_options($mform);
				break;
			case 'interval-write':
				$this->add_interval_write_options($mform);
				break;
			case 'interval-write-random':
				$this->add_interval_write_random_options($mform);
				break;
			case 'interval-identify-random':
				$this->add_interval_identify_random_options($mform);
				break;
			case 'interval-identify':
				$this->add_interval_identify_options($mform);
				break;
			case 'scale-write':
				$this->add_scale_write_options($mform);
				break;
			case 'scale-write-random':
				$this->add_scale_write_random_options($mform);
				break;
			case 'chordquality-write':
				$this->add_chordquality_write_options($mform);
				break;
			case 'chordquality-identify':
				$this->add_chordquality_identify_options($mform);
				break;
			case 'chordquality-write-random':
			case 'chordquality-identify-random':
				$this->add_chordquality_write_identify_random_options($mform);
				break;
			case 'harmonicfunction-write':
				$this->add_harmonicfunction_write_options($mform);
				break;
			case 'harmonicfunction-write-random':
			case 'harmonicfunction-identify-random':
				$this->add_harmonicfunction_write_identify_random_options($mform);
				break;
			case 'harmonicfunction-identify':
				$this->add_harmonicfunction_identify_options($mform);
				break;
			default:
				$this->add_keysignature_write_options($mform);
				break;
		}

		$this->add_interactive_settings(true, true);
	}

	/**
	 * Adds form options for the note writing subtype.
	 *
	 * @param object $mform the form being built.
	 */
	private function add_note_write_options($mform) {
		$this->add_clef_option($mform, 'musictheory_clef', false, 'clef', true);
		$this->add_includealterations_option($mform);
		$this->add_considerregister_option($mform);
		$this->add_note_option($mform, 'givennote', get_string('notelbl', 'qtype_musictheory'), true, true);
		$mform->disabledIf('musictheory_givennoteaccidental', 'musictheory_includealterations', 'notchecked');
		$mform->disabledIf('musictheory_givennoteregister', 'musictheory_considerregister', 'notchecked');
	}

	/**
	 * Adds form options for the note identification subtype.
	 *
	 * @param object $mform the form being built.
	 */
	private function add_note_identification_options($mform) {
		$this->add_clef_option($mform, 'musictheory_clef', false, 'clef', true);
		$this->add_includealterations_option($mform);
		$this->add_considerregister_option($mform);
		$this->add_note_option($mform, 'givennote', get_string('notelbl', 'qtype_musictheory'), true, true);
		$mform->disabledIf('musictheory_givennoteaccidental', 'musictheory_includealterations', 'notchecked');
	}

	/**
	 * Adds form options for the random note writing subtype.
	 *
	 * @param object $mform the form being built.
	 */
	private function add_note_write_random_options($mform) {
		$this->add_clef_option($mform, 'musictheory_clef_random', true, 'clef-random', true);
		$this->add_includealterations_option($mform);
		$this->add_considerregister_option($mform);
	}

	/**
	 * Adds form options for the keyboard input subtype.
	 *
	 * @param object $mform the form being built.
	 */
	private function add_keyboard_input_options($mform) {
		$lbl = get_string('includestaticnote', 'qtype_musictheory');
		$mform->addElement('advcheckbox', 'musictheory_includestaticnote', $lbl);
		$mform->addRule('musictheory_includestaticnote', null, 'required', null, 'client');
		$this->add_note_option($mform, 'staticnote', get_string('givennoteelementgroup', 'qtype_musictheory'), false, true, true, array(0, 8));
		$mform->disabledIf('musictheory_staticnoteelementgroup', 'musictheory_includestaticnote', 'notchecked');

		$this->add_considerregister_option($mform);
		$this->add_note_option($mform, 'givennote', get_string('answerlbl', 'qtype_musictheory'), true, true, true, array(0, 8));
		$mform->disabledIf('musictheory_givennoteregister', 'musictheory_considerregister', 'notchecked');
	}

	/**
	 * Adds form options for the key signature writing subtype.
	 *
	 * @param object $mform the form being built.
	 */
	private function add_keysignature_write_options($mform) {
		$this->add_clef_option($mform, 'musictheory_clef', false, 'clef');
		$this->add_key_option($mform, false);
	}

	/**
	 * Adds form options for the random key signature writing subtype.
	 *
	 * @param object $mform the form being built.
	 */
	private function add_keysignature_write_identify_random_options($mform) {
		$this->add_clef_option($mform, 'musictheory_clef_random', true, 'clef-random');
		$this->add_mode_option($mform, 'musictheory_mode_random', true, 'mode-random');
	}

	/**
	 * Adds form options for the key signature identification subtype.
	 *
	 * @param object $mform the form being built.
	 */
	private function add_keysignature_identify_options($mform) {
		$this->add_clef_option($mform, 'musictheory_clef', false, 'clef');
		$this->add_key_option($mform, true);
	}

	/**
	 * Adds form options for the interval writing subtype.
	 *
	 * @param object $mform the form being built.
	 */
	private function add_interval_write_options($mform) {
		$this->add_clef_option($mform, 'musictheory_clef', false, 'clef');
		$this->add_direction_option($mform, 'musictheory_direction', false, 'direction');
		$this->add_note_option($mform, 'givennote', get_string('givennoteelementgroup', 'qtype_musictheory'), true, true);
		$questionfields = array(
			'size'		 => 'musictheory_size',
			'quality'	 => 'musictheory_quality'
		);
		$labelkey = 'musictheory_intervalelementgroup';
		$this->add_quality_size_option($mform, $questionfields, false, $labelkey);
	}

	/**
	 * Adds form options for the random interval writing subtype.
	 *
	 * @param object $mform the form being built.
	 */
	private function add_interval_write_random_options($mform) {
		$this->add_clef_option($mform, 'musictheory_clef_random', true, 'clef-random');
		$this->add_direction_option($mform, 'musictheory_direction_random', true, 'direction');
		$questionfields = array(
			'size'		 => 'musictheory_size_random',
			'quality'	 => 'musictheory_quality_random'
		);
		$labelkey = 'musictheory_intervalelementgroup_random';
		$this->add_quality_size_option($mform, $questionfields, true, $labelkey);
	}

	/**
	 * Adds form options for the interval identification subtype.
	 *
	 * @param object $mform the form being built.
	 */
	private function add_interval_identify_options($mform) {
		$this->add_clef_option($mform, 'musictheory_clef', false, 'clef');
		$this->add_direction_option($mform, 'musictheory_direction', false, 'direction');
		$this->add_note_option($mform, 'givennote', get_string('givennoteelementgroup', 'qtype_musictheory'), true, true);
		$questionfields = array(
			'size'		 => 'musictheory_size',
			'quality'	 => 'musictheory_quality'
		);
		$labelkey = 'musictheory_intervalelementgroup';
		$this->add_quality_size_option($mform, $questionfields, false, $labelkey);
	}

	/**
	 * Adds form options for the random interval identification subtype.
	 *
	 * @param object $mform the form being built.
	 */
	private function add_interval_identify_random_options($mform) {
		$this->add_clef_option($mform, 'musictheory_clef_random', true, 'clef-random');
		$questionfields = array(
			'size'		 => 'musictheory_size_random',
			'quality'	 => 'musictheory_quality_random'
		);
		$labelkey = 'musictheory_intervalelementgroup_random';
		$this->add_quality_size_option($mform, $questionfields, true, $labelkey);
	}

	/**
	 * Adds form options for the scale writing subtype.
	 *
	 * @param object $mform the form being built.
	 */
	private function add_scale_write_options($mform) {
		$this->add_clef_option($mform, 'musictheory_clef', false, 'clef');
		$this->add_note_option($mform, 'givennote', get_string('tonic', 'qtype_musictheory'), true, false);
		$this->add_includekeysignature_option($mform);
		$this->add_scaletype_option($mform, 'musictheory_scaletype', false, 'scaletype');
	}

	/**
	 * Adds form options for the random scale writing subtype.
	 *
	 * @param object $mform the form being built.
	 */
	private function add_scale_write_random_options($mform) {
		$this->add_includekeysignature_option($mform);
		$this->add_clef_option($mform, 'musictheory_clef_random', true, 'clef-random');
		$this->add_scaletype_option($mform, 'musictheory_scaletype_random', true, 'scaletype-random');
	}

	/**
	 * Adds form options for the chord quality writing subtype.
	 *
	 * @param object $mform the form being built.
	 */
	private function add_chordquality_write_options($mform) {
		$this->add_clef_option($mform, 'musictheory_clef', false, 'clef');
		$this->add_note_option($mform, 'givennote', get_string('chordroot', 'qtype_musictheory'), true, false, false);
		$this->add_chordquality_option($mform, 'musictheory_chordquality', false, 'chordquality');
	}

	/**
	 * Adds form options for the chord quality identification subtype.
	 *
	 * @param object $mform the form being built.
	 */
	private function add_chordquality_identify_options($mform) {
		$this->add_clef_option($mform, 'musictheory_clef', false, 'clef');
		$this->add_note_option($mform, 'givennote', get_string('chordroot', 'qtype_musictheory'), true, false, true);
		$this->add_chordquality_option($mform, 'musictheory_chordquality', false, 'chordquality');
	}

	/**
	 * Adds form options for the random chord quality writing subtype.
	 *
	 * @param object $mform the form being built.
	 */
	private function add_chordquality_write_identify_random_options($mform) {
		$this->add_clef_option($mform, 'musictheory_clef_random', true, 'clef-random');
		$this->add_chordquality_option($mform, 'musictheory_chordquality_random', true, 'chordquality-random');
	}

	/**
	 * Adds form options for the harmonic function writing subtype.
	 *
	 * @param object $mform the form being built.
	 */
	private function add_harmonicfunction_write_options($mform) {
		$this->add_clef_option($mform, 'musictheory_clef', false, 'clef');
		$this->add_key_option($mform, true);
		$this->add_includekeysignature_option($mform);
		$this->add_harmonicfunction_option($mform, get_string('lbl_harmonicfunction', 'qtype_musictheory'));
	}

	/**
	 * Adds form options for the random harmonic function writing/ID subtype.
	 *
	 * @param object $mform the form being built.
	 */
	private function add_harmonicfunction_write_identify_random_options($mform) {
		$this->add_clef_option($mform, 'musictheory_clef_random', true, 'clef-random');
		$this->add_mode_option($mform, 'musictheory_mode_random', true, 'mode-random');
		$this->add_includekeysignature_option($mform);
		$this->add_harmonicfunctiontype_option($mform, 'musictheory_harmonicfunctiontype_random', true, 'harmonicfunctiontype-random');
	}

	/**
	 * Adds form options for the harmonic function identification subtype.
	 *
	 * @param object $mform the form being built.
	 */
	private function add_harmonicfunction_identify_options($mform) {
		$this->add_harmonicfunction_write_options($mform);
		$this->add_harmonicfunctiontype_option($mform, 'musictheory_hfidentifyresponsetypes', true, 'hfidentifyresponsetypes');
	}

	/**
	 * Adds a checkbox to the form indicating whether the register should
	 * be taken into account in a note question.
	 *
	 * @param object $mform The form being built.
	 */
	private function add_considerregister_option($mform) {
		$lbl = get_string('considerregister', 'qtype_musictheory');
		$mform->addElement('advcheckbox', 'musictheory_considerregister', $lbl);
		$mform->addHelpButton('musictheory_considerregister', 'considerregister', 'qtype_musictheory');
		$mform->addRule('musictheory_considerregister', null, 'required', null, 'client');
	}

	/**
	 * Adds a checkbox to the form indicating whether the note alterations should
	 * be taken into account in a note question.
	 *
	 * @param object $mform The form being built.
	 */
	private function add_includealterations_option($mform) {
		$lbl = get_string('includealterations', 'qtype_musictheory');
		$mform->addElement('advcheckbox', 'musictheory_includealterations', $lbl);
		$mform->addHelpButton('musictheory_includealterations', 'includealterations', 'qtype_musictheory');
		$mform->addRule('musictheory_includealterations', null, 'required', null, 'client');
	}

	/**
	 * Adds a clef option to the form.
	 *
	 * @param object $mform The form being built.
	 * @param string $questionfield The field name for clef in the question
	 * object.
	 * @param boolean $multiselect Indicates whether a multiselect element should
	 * be added.
	 * @param string $labelkey The key to use for the option label.
	 * @param boolean $includegrandstaff Indicates whether a grand staff option
	 * should be included in the list of clef options.
	 */
	private function add_clef_option($mform, $questionfield, $multiselect,
			$labelkey, $includegrandstaff = false) {

		$selectoptionsclef = array(
			'treble' => get_string('treble', 'qtype_musictheory'),
			'bass'	 => get_string('bass', 'qtype_musictheory'),
			'alto'	 => get_string('alto', 'qtype_musictheory'),
			'tenor'	 => get_string('tenor', 'qtype_musictheory'),
		);
		if ($includegrandstaff) {
			$selectoptionsclef['grandstaff'] = get_string('grandstaff', 'qtype_musictheory');
			$optionsize = 5;
		} else {
			$optionsize = 4;
		}

		if ($multiselect) {
			$selectattr = array('multiple'	 => 'multiple', 'size'		 => $optionsize);
		} else {
			$selectattr = array();
		}
		$lbl = get_string($labelkey, 'qtype_musictheory');
		$mform->addElement('select', $questionfield, $lbl, $selectoptionsclef, $selectattr);
		$mform->addRule($questionfield, null, 'required', null, 'client');
	}

	/**
	 * Adds a key option the form.
	 *
	 * @param object $mform The form being built.
	 * @param boolean $includeemptykeysignatures Indicates whether the options
	 * should include keys that have empty key signatures.
	 */
	private function add_key_option($mform, $includeemptykeysignatures) {

		if ($includeemptykeysignatures) {
			$selectoptionskey = array(
				'CnM' => get_string('CnM', 'qtype_musictheory'),
			);
		} else {
			$selectoptionskey = array();
		}

		$selectoptionskey += array(
			'GnM'	 => get_string('GnM', 'qtype_musictheory'),
			'DnM'	 => get_string('DnM', 'qtype_musictheory'),
			'AnM'	 => get_string('AnM', 'qtype_musictheory'),
			'EnM'	 => get_string('EnM', 'qtype_musictheory'),
			'BnM'	 => get_string('BnM', 'qtype_musictheory'),
			'F#M'	 => get_string('FsharpM', 'qtype_musictheory'),
			'C#M'	 => get_string('CsharpM', 'qtype_musictheory'),
			'FnM'	 => get_string('FnM', 'qtype_musictheory'),
			'BbM'	 => get_string('BbM', 'qtype_musictheory'),
			'EbM'	 => get_string('EbM', 'qtype_musictheory'),
			'AbM'	 => get_string('AbM', 'qtype_musictheory'),
			'DbM'	 => get_string('DbM', 'qtype_musictheory'),
			'GbM'	 => get_string('GbM', 'qtype_musictheory'),
			'CbM'	 => get_string('CbM', 'qtype_musictheory')
		);

		if ($includeemptykeysignatures) {
			$selectoptionskey += array(
				'Anm' => get_string('Anm', 'qtype_musictheory'),
			);
		}

		$selectoptionskey += array(
			'Enm'	 => get_string('Enm', 'qtype_musictheory'),
			'Bnm'	 => get_string('Bnm', 'qtype_musictheory'),
			'F#m'	 => get_string('Fsharpm', 'qtype_musictheory'),
			'C#m'	 => get_string('Csharpm', 'qtype_musictheory'),
			'G#m'	 => get_string('Gsharpm', 'qtype_musictheory'),
			'D#m'	 => get_string('Dsharpm', 'qtype_musictheory'),
			'A#m'	 => get_string('Asharpm', 'qtype_musictheory'),
			'Dnm'	 => get_string('Dnm', 'qtype_musictheory'),
			'Gnm'	 => get_string('Gnm', 'qtype_musictheory'),
			'Cnm'	 => get_string('Cnm', 'qtype_musictheory'),
			'Fnm'	 => get_string('Fnm', 'qtype_musictheory'),
			'Bbm'	 => get_string('Bbm', 'qtype_musictheory'),
			'Ebm'	 => get_string('Ebm', 'qtype_musictheory'),
			'Abm'	 => get_string('Abm', 'qtype_musictheory'),
		);

		$lbl = get_string('keymode', 'qtype_musictheory');
		$mform->addElement('select', 'musictheory_keymode', $lbl, $selectoptionskey);
		$mform->addRule('musictheory_keymode', null, 'required', null, 'client');
	}

	/**
	 * Adds a mode option to the form.
	 *
	 * @param object $mform The form being built.
	 * @param string $questionfield The field name for mode in the question
	 * object.
	 * @param boolean $multiselect Indicates whether a multiselect element should
	 * be added.
	 * @param string $labelkey The key to use for the option label.
	 */
	private function add_mode_option($mform, $questionfield, $multiselect,
			$labelkey) {

		$selectoptionsclef = array(
			'M'	 => get_string('major', 'qtype_musictheory'),
			'm'	 => get_string('minor', 'qtype_musictheory'),
		);

		if ($multiselect) {
			$selectattr = array('multiple'	 => 'multiple', 'size'		 => 2);
		} else {
			$selectattr = array();
		}

		$lbl = get_string($labelkey, 'qtype_musictheory');
		$mform->addElement('select', $questionfield, $lbl, $selectoptionsclef, $selectattr);
		$mform->addRule($questionfield, null, 'required', null, 'client');
	}

	/**
	 * Adds a checkbox to the form indicating whether the key signature
	 * should be displayed.
	 *
	 * @param object $mform The form being built.
	 */
	private function add_includekeysignature_option($mform) {
		$lbl = get_string('displaykeysignature', 'qtype_musictheory');
		$mform->addElement('advcheckbox', 'musictheory_displaykeysignature', $lbl);
		$mform->addRule('musictheory_displaykeysignature', null, 'required', null, 'client');
	}

	/**
	 * Adds a direction option (i.e. above or below a given note).
	 *
	 * @param object $mform The form being built.
	 * @param string $questionfield The field name for direction in the question
	 * object.
	 * @param boolean $multiselect Indicates whether a multiselect element should
	 * be added.
	 * @param string $labelkey The key to use for the option label.
	 */
	private function add_direction_option($mform, $questionfield, $multiselect,
			$labelkey) {
		$selectoptionsdirection = array(
			'above'	 => get_string('dirasc', 'qtype_musictheory'),
			'below'	 => get_string('dirdesc', 'qtype_musictheory')
		);

		if ($multiselect) {
			$selectattr = array('multiple'	 => 'multiple', 'size'		 => 2);
		} else {
			$selectattr = array();
		}

		$lbl = get_string($labelkey, 'qtype_musictheory');
		$mform->addElement('select', $questionfield, $lbl, $selectoptionsdirection, $selectattr);
		$mform->addRule($questionfield, null, 'required', null, 'client');
	}

	/**
	 * Adds a give note option to the form.
	 *
	 * @param object $mform The form being built.
	 * @param string $label The string ti display as option label.
	 * @param boolean $includedoubleaccidentals Indicates whether the accidental
	 * portion should include double-sharps and double-flats.
	 * @param boolean $includeregister Indicates whether the note option
	 * should include the register.
	 * @param array $reglimits Provides the register boundaries (lowest, highest)
	 * that should be displayed in the register portion.
	 */
	private function add_note_option($mform, $elemname, $label, $required,
			$includedoubleaccidentals, $includeregister = true, $reglimits =
	array(2, 6)) {
		$selectoptionsletter = array(
			'A'	 => get_string('noteA', 'qtype_musictheory'),
			'B'	 => get_string('noteB', 'qtype_musictheory'),
			'C'	 => get_string('noteC', 'qtype_musictheory'),
			'D'	 => get_string('noteD', 'qtype_musictheory'),
			'E'	 => get_string('noteE', 'qtype_musictheory'),
			'F'	 => get_string('noteF', 'qtype_musictheory'),
			'G'	 => get_string('noteG', 'qtype_musictheory'),
		);

		$givennoteletter =
				$mform->createElement('select', 'musictheory_' . $elemname . 'letter', '', $selectoptionsletter);

		$selectoptionsaccidental = array(
			'n'	 => '&#9838;',
			'#'	 => '&#9839;',
			'b'	 => '&#9837;',
		);

		if ($includedoubleaccidentals) {
			$selectoptionsaccidental += array('x'	 => 'x',
				'bb' => '&#9837;&#9837;',
			);
		}

		$givennoteaccidental =
				$mform->createElement('select', 'musictheory_' . $elemname . 'accidental', '', $selectoptionsaccidental);

		$givennotearray = array();
		$givennotearray [] = & $givennoteletter;
		$givennotearray[] = & $givennoteaccidental;
		if ($includeregister) {
			for ($i = $reglimits[0]; $i <= $reglimits[1]; $i++) {
				$selectoptionsregister[$i] = $i;
			}
			$givennoteregister =
					$mform->createElement('select', 'musictheory_' . $elemname . 'register', '', $selectoptionsregister);
			$givennotearray[] = & $givennoteregister;
		}

		$mform->addGroup($givennotearray, 'musictheory_' . $elemname . 'elementgroup', $label, array(' '), false);
		if ($required) {
			$mform->addRule('musictheory_' . $elemname . 'elementgroup', null, 'required', null, 'client');
		}
	}

	/**
	 * Adds an interval quality and size option to the form.
	 *
	 * @param object $mform The form being built.
	 * @param array $questionfields The field names for quality and size in the
	 * question object.
	 * @param boolean $multiselect Indicates whether a multiselect element should
	 * be added.
	 * @param string $labelkey The key to use for the option label.
	 */
	private function add_quality_size_option($mform, $questionfields, $multiselect,
			$labelkey) {
		$selectoptionsquality = array(
			'D'	 => get_string('qualityD', 'qtype_musictheory'),
			'm'	 => get_string('qualitym', 'qtype_musictheory'),
			'M'	 => get_string('qualityM', 'qtype_musictheory'),
			'P'	 => get_string('qualityP', 'qtype_musictheory'),
			'A'	 => get_string('qualityA', 'qtype_musictheory')
		);

		if ($multiselect) {
			$qualselectattr = array('multiple'	 => 'multiple', 'size'		 => 5);
		} else {
			$qualselectattr = array();
		}

		$selectoptionssize = array(
			'2'	 => get_string('size2', 'qtype_musictheory'),
			'3'	 => get_string('size3', 'qtype_musictheory'),
			'4'	 => get_string('size4', 'qtype_musictheory'),
			'5'	 => get_string('size5', 'qtype_musictheory'),
			'6'	 => get_string('size6', 'qtype_musictheory'),
			'7'	 => get_string('size7', 'qtype_musictheory'),
			'8'	 => get_string('size8', 'qtype_musictheory'),
			'9'	 => get_string('size9', 'qtype_musictheory'),
			'10' => get_string('size10', 'qtype_musictheory'),
			'11' => get_string('size11', 'qtype_musictheory'),
			'12' => get_string('size12', 'qtype_musictheory'),
			'13' => get_string('size13', 'qtype_musictheory'),
		);

		if ($multiselect) {
			$sizeselectattr = array('multiple'	 => 'multiple', 'size'		 => 12);
		} else {
			$sizeselectattr = array();
		}

		if (strpos($questionfields['size'], 'random') === false) {
			$elemquality =
					$mform->createElement('select', $questionfields['quality'], '', $selectoptionsquality, $qualselectattr);
			$elemsize =
					$mform->createElement('select', $questionfields['size'], '', $selectoptionssize, $sizeselectattr);
			$intervalarray = array();
			$intervalarray[] = & $elemquality;
			$intervalarray[] = & $elemsize;
			$mform->addGroup($intervalarray, $labelkey, get_string($labelkey, 'qtype_musictheory'), array(' '), false);
			$mform->addRule($labelkey, null, 'required', null, 'client');
		} else {
			$lblq = get_string('quality-random', 'qtype_musictheory');
			$elemquality =
					$mform->createElement('select', $questionfields['quality'], $lblq, $selectoptionsquality, $qualselectattr);
			$lbls = get_string('size-random', 'qtype_musictheory');
			$elemsize =
					$mform->createElement('select', $questionfields['size'], $lbls, $selectoptionssize, $sizeselectattr);
			$mform->addElement($elemquality);
			$mform->addRule($questionfields['quality'], null, 'required', null, 'client');
			$mform->addElement($elemsize);
			$mform->addRule($questionfields['size'], null, 'required', null, 'client');
		}
	}

	/**
	 * Adds a scale type option to the form
	 *
	 * @param object $mform The form being built.
	 * @param string $questionfield The field name for scale type in the question
	 * object.
	 * @param boolean $multiselect Indicates whether a multiselect element should
	 * be added.
	 * @param string $labelkey The key to use for the option label.
	 */
	private function add_scaletype_option($mform, $questionfield, $multiselect,
			$labelkey) {
		$selectoptionsscaletype = array(
			'major'		 => get_string('scaletype_major', 'qtype_musictheory'),
			'natural'	 => get_string('scaletype_natural', 'qtype_musictheory'),
			'harmonic'	 => get_string('scaletype_harmonic', 'qtype_musictheory'),
			'melodic'	 => get_string('scaletype_melodic', 'qtype_musictheory'),
		);

		if ($multiselect) {
			$selectattr = array('multiple'
				=> 'multiple', 'size'		 => 4);
		} else {
			$selectattr = array();
		}

		$lbl = get_string($labelkey, 'qtype_musictheory');
		$mform->addElement('select', $questionfield, $lbl, $selectoptionsscaletype, $selectattr);
		$mform->addRule($questionfield, null, 'required', null, 'client');
	}

	/**
	 * Adds a chord quality option to the form
	 *
	 * @param object $mform The form being built.
	 * @param string $questionfield The field name for chord quality type in the question
	 * object.
	 * @param boolean $multiselect Indicates whether a multiselect element should
	 * be added.
	 * @param string $labelkey The key to use for the option label.
	 */
	private function add_chordquality_option($mform, $questionfield, $multiselect,
			$labelkey) {
		$selectoptionsquality = array(
			'major'		 => get_string('major', 'qtype_musictheory'),
			'minor'		 => get_string('minor', 'qtype_musictheory'),
			'augmented'	 => get_string('augmented', 'qtype_musictheory'),
			'diminished' => get_string('diminished', 'qtype_musictheory'),
		);

		if ($multiselect) {
			$selectattr = array('multiple'
				=> 'multiple', 'size'		 => 4);
		} else {
			$selectattr = array();
		}

		$lbl = get_string($labelkey, 'qtype_musictheory');
		$mform->addElement('select', $questionfield, $lbl, $selectoptionsquality, $selectattr);
		$mform->addRule($questionfield, null, 'required', null, 'client');
	}

	/**
	 * Adds a harmonicfunction option to the form.
	 *
	 * @param object $mform The form being built.
	 * @param string $label The string to display as option label.
	 */
	private function add_harmonicfunction_option($mform, $label) {
		$selectoptionshfprimary = array(
			'I'		 => 'I',
			'i'		 => 'i',
			'ii'	 => 'ii',
			'iio'	 => 'iio',
			'ii-o'	 => 'ii&#248;',
			'N'		 => 'N',
			'iii'	 => 'iii',
			'niii'	 => '&#9838;iii',
			'biii'	 => '&#9837;iii',
			'bbiii'	 => '&#9837;&#9837;iii',
			'#iii'	 => '&#9839;iii',
			'xiii'	 => '&#9839;iii',
			'III'	 => 'III',
			'III+'	 => 'III+',
			'nIII'	 => '&#9838;III',
			'bIII'	 => '&#9837;III',
			'bbIII'	 => '&#9837;&#9837;III',
			'#III'	 => '&#9839;III',
			'xIII'	 => 'xIII',
			'IV'	 => 'IV',
			'iv'	 => 'iv',
			'V'		 => 'V',
			'v'		 => 'v',
			'vi'	 => 'vi',
			'nvi'	 => '&#9838;vi',
			'bvi'	 => '&#9837;vi',
			'bbvi'	 => '&#9837;&#9837;vi',
			'#vi'	 => '&#9839;vi',
			'xvi'	 => 'xvi',
			'VI'	 => 'VI',
			'nVI'	 => '&#9838;VI',
			'bVI'	 => '&#9837;VI',
			'bbVI'	 => '&#9837;&#9837;VI',
			'#VI'	 => '&#9839;VI',
			'xVI'	 => 'xVI',
			'vio'	 => 'vio',
			'vi-o'	 => 'vi&#248;',
			'viio'	 => 'viio',
			'vii-o'	 => 'vii&#248;',
			'VII'	 => 'VII',
			'Gr'	 => get_string('aug6thgr', 'qtype_musictheory'),
			'Fr'	 => get_string('aug6thfr', 'qtype_musictheory'),
			'It'	 => get_string('aug6thit', 'qtype_musictheory'),
		);

		$hfprimary =
				$mform->createElement('select', 'musictheory_hfprimary', '', $selectoptionshfprimary);

		$selectoptionshfinvext = array(
			'r'	 => get_string('rootposition', 'qtype_musictheory'),
			'6'	 => '6',
			'64' => '64',
			'7'	 => '7',
			'65' => '65',
			'43' => '43',
			'42' => '42',
			'9'	 => '9',
			'11' => '11',
			'13' => '13',
		);

		$hfinvext =
				$mform->createElement('select', 'musictheory_hfinvext', '', $selectoptionshfinvext);

		$selectoptionshfsecondary = array(
			'none'	 => get_string('nosectonic', 'qtype_musictheory'),
			'/ii'	 => '/ii',
			'/iii'	 => '/iii',
			'/III'	 => '/III',
			'/IV'	 => '/IV',
			'/iv'	 => '/iv',
			'/V'	 => '/V',
			'/VI'	 => '/VI',
			'/vi'	 => '/vi',
			'/VII'	 => '/VII'
		);
		$hfsecondary =
				$mform->createElement('select', 'musictheory_hfsecondary', '', $selectoptionshfsecondary);
		$hfarray = array();
		$hfarray [] = & $hfprimary;
		$hfarray[] = & $hfinvext;
		$hfarray[] = & $hfsecondary;
		$mform->addGroup($hfarray, 'musictheory_hfelementgroup', $label, array(' '), false);
		$mform->addRule('musictheory_hfelementgroup', null, 'required', null, 'client');
	}

	/**
	 * Adds a harmonic function type option to the form
	 *
	 * @param object $mform The form being built.
	 * @param string $questionfield The field name for harmonic function type in the
	 * question object.
	 * @param boolean $multiselect Indicates whether a multiselect element should
	 * be added.
	 * @param string $labelkey The key to use for the option label.
	 */
	private function add_harmonicfunctiontype_option($mform, $questionfield,
			$multiselect, $labelkey) {
		$selectoptionsscaletype = array(
			'diatonictriad'			 => get_string('hftype_diatonictriad', 'qtype_musictheory'),
			'dom7th'				 => get_string('hftype_dom7th', 'qtype_musictheory'),
			'nondom7th'				 => get_string('hftype_nondom7th', 'qtype_musictheory'),
			'leadingtone7thhalfdim'	 => get_string('hftype_leadingtone7thhalfdim', 'qtype_musictheory'),
			'leadingtone7thfullydim' => get_string('hftype_leadingtone7thfullydim', 'qtype_musictheory'),
			'secdomtriad'			 => get_string('hftype_secdomtriad', 'qtype_musictheory'),
			'secdom7th'				 => get_string('hftype_secdom7th', 'qtype_musictheory'),
			'secnondomtriad'		 => get_string('hftype_secnondomtriad', 'qtype_musictheory'),
			'secnondom7th'			 => get_string('hftype_secnondom7th', 'qtype_musictheory'),
			'seclttriad'			 => get_string('hftype_seclttriad', 'qtype_musictheory'),
			'seclthalfdim'			 => get_string('hftype_seclthalfdim', 'qtype_musictheory'),
			'secltfullydim'			 => get_string('hftype_secltfullydim', 'qtype_musictheory'),
			'neapolitan'			 => get_string('hftype_neapolitan', 'qtype_musictheory'),
			'aug6th'				 => get_string('hftype_aug6th', 'qtype_musictheory')
		);

		if ($multiselect) {
			$selectattr = array('multiple'
				=> 'multiple', 'size'		 => 16);
		} else {
			$selectattr = array();
		}

		$lbl = get_string($labelkey, 'qtype_musictheory');
		$mform->addElement('select', $questionfield, $lbl, $selectoptionsscaletype, $selectattr);
		$mform->addRule($questionfield, null, 'required', null, 'client');
	}

	public function validation($data, $files) {
		$errors = parent::validation($data, $files);
		if (count($errors) > 0) {
			return $errors;
		}
		$errors += qtype_musictheory_validation::validate_form_options($data);
		return $errors;
	}

	protected function data_preprocessing($question) {
		$question = parent::data_preprocessing
						($question);
		question_bank::get_qtype($question->qtype
		)->initialise_options_from_xml($question);
		question_bank::get_qtype($question->qtype)->initialise_random_options_from_xml($question);
		$question = $this->data_preprocessing_answers($question);
		$question = $this->data_preprocessing_hints($question);

		return $question;
	}

	public function qtype() {

		return 'musictheory';
	}

}

/**
 * Static helper class for music theory subtype form validation.
 *
 * @copyright  2013 Eric Brisson
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class qtype_musictheory_validation {

	/**
	 * Validates music theory edit form options.
	 *
	 * Router the data to a subtype-specific validation function.
	 *
	 * @param array $data The form data.
	 * @return array The validation errors.
	 */
	public static function validate_form_options($data) {
		switch ($data['musictheory_musicqtype']) {
			case 'note-write':
			case 'note-identify':
				return self::validate_note_options($data);
			case 'keyboard-input':
				return self::validate_keyboard_input_options($data);
			case 'interval-write':
			case 'interval-identify':
				return self::validate_interval_write_options($data);
			case 'interval-write-random':
			case 'interval-identify-random':
				return self::validate_interval_write_random_options($data);
			case 'scale-write':
				return self::validate_scale_write_options($data);
			case 'chordquality-write':
				return self::validate_chordquality_options($data);
			case 'harmonicfunction-write':
			case 'harmonicfunction-identify':
				return self::validate_harmonicfunction_options($data);
		}
		return array();
	}

	/**
	 * Validates interval writing form options.
	 *
	 * It makes sure that a given interval exists and that it can be built
	 * on the requested given note. It also checks that the interval would
	 * fit in the staff in the requested clef.
	 *
	 * @param array $data The form data.
	 * @return array The validation errors.
	 */
	public static function validate_note_options($data) {
		$errors = array();

		$ltr = $data['musictheory_givennoteletter'];
		$acc = $data['musictheory_givennoteaccidental'];
		$reg = $data['musictheory_givennoteregister'];
		$note = new Note($ltr, $acc, $reg);

		if ($data['musictheory_clef'] === 'grandstaff') {
			$staff1 = new Staff('treble');
			$staff2 = new Staff('bass');
			if (!$staff1->noteFitsInStaff($note, 4) && !$staff2->noteFitsInStaff($note, 4)) {
				$errors['musictheory_givennoteelementgroup'] =
						get_string('validation_noteoutsidestaff', 'qtype_musictheory');
			}
		} else {
			$staff = new Staff($data['musictheory_clef']);
			if (!$staff->noteFitsInStaff($note, 4)) {
				$errors['musictheory_givennoteelementgroup'] =
						get_string('validation_noteoutsidestaff', 'qtype_musictheory');
			}
		}

		return $errors;
	}

	/**
	 * Validates keyboard input form options.
	 *
	 * It makes sure that the provided keys are within the keyboard boundaries.
	 *
	 * @param array $data The form data.
	 * @return array The validation errors.
	 */
	public static function validate_keyboard_input_options($data) {
		$errors = array();

		if ($data['musictheory_considerregister'] !== "1") {
			return $errors;
		}

		$ltr = $data['musictheory_givennoteletter'];
		$acc = $data['musictheory_givennoteaccidental'];
		$reg = $data['musictheory_givennoteregister'];

		$answernote = new Note($ltr, $acc, $reg);

		$ltr = $data['musictheory_staticnoteletter'];
		$acc = $data['musictheory_staticnoteaccidental'];
		$reg = $data['musictheory_staticnoteregister'];

		$staticnote = new Note($ltr, $acc, $reg);

		$notes = array($answernote, $staticnote);
		for ($i = 0; $i < count($notes); $i++) {
			$pcreg = $notes[$i]->getPitchClassKeyboardRegister();
			$pitchclass = $pcreg['pitchclass'];
			$register = $pcreg['register'];

			if ($register === 8 && $pitchclass > 0 ||
					$register === 0 && $pitchclass < 9) {
				$errors['musictheory_givennoteelementgroup'] =
						get_string('validation_noteoutsidekeyboard', 'qtype_musictheory');
			}
		}

		return $errors;
	}

	/**
	 * Validates interval writing form options.
	 *
	 * It makes sure that a given interval exists and that it can be built
	 * on the requested given note. It also checks that the interval would
	 * fit in the staff in the requested clef.
	 *
	 * @param array $data The form data.
	 * @return array The validation errors.
	 */
	public static function validate_interval_write_options($data) {
		$errors = array();

		if (!Interval::valid_interval($data['musictheory_quality'], $data['musictheory_size'])) {
			$errors['musictheory_intervalelementgroup'] =
					get_string('validation_qualitymismatch', 'qtype_musictheory');
			return $errors;
		}

		$direction = ($data['musictheory_direction'] == 'above') ? '+' : '-';
		$interval = new Interval($direction, $data['musictheory_quality'], $data['musictheory_size']);
		$ltr = $data['musictheory_givennoteletter'];
		$acc = $data['musictheory_givennoteaccidental'];
		$reg = $data['musictheory_givennoteregister'];
		$givennote = new Note($ltr, $acc, $reg);

		$response = $givennote->getNoteFromInterval($interval);
		if ($response == null) {
			if ($data['musictheory_direction'] == 'above') {
				$errors['musictheory_intervalelementgroup'] =
						get_string('validation_invalidinterval_above', 'qtype_musictheory');
			} else {
				$errors['musictheory_intervalelementgroup'] =
						get_string('validation_invalidinterval_below', 'qtype_musictheory');
			}
		}

		if (count($errors) > 0) {
			return $errors;
		}

		$staff = new Staff($data['musictheory_clef']);
		if (!$staff->noteFitsInStaff($response, 4)) {
			$errors['musictheory_givennoteelementgroup'] =
					get_string('validation_intervaloutsidestaff', 'qtype_musictheory');
		}

		return $errors;
	}

	/**
	 * Validates random interval writing form options.
	 *
	 * It makes sure that at least one combination of possible interval
	 * qualities and sizes yields a valid (existing) type of interval.
	 *
	 * @param array $data The form data.
	 * @return array The validation errors.
	 */
	public static function validate_interval_write_random_options($data) {
		$errors = array();

		$atleastonevalidcombo = false;
		foreach ($data['musictheory_quality_random'] as $quality) {
			foreach ($data['musictheory_size_random'] as $size) {
				if (Interval::valid_interval($quality, $size)) {
					$atleastonevalidcombo = true;
				}
			}
		}

		if (!$atleastonevalidcombo) {
			$errors['musictheory_quality_random'] =
					get_string('validation_interval_novalidcombo', 'qtype_musictheory');
		}

		return $errors;
	}

	/**
	 * Validates scale writing form options.
	 *
	 * It makes sure that the requested scale can be written in the requested
	 * key and mode. It also makes sure that the scale fits in the staff in the
	 * requested clef.
	 *
	 * @param array $data The form data.
	 * @return array The validation errors.
	 */
	public static function validate_scale_write_options($data) {
		$errors = array();

		$comptonic = new Note($data['musictheory_givennoteletter'], $data['musictheory_givennoteaccidental'], 4);
		$mode = ($data['musictheory_scaletype'] == 'major') ? 'M' : 'm';
		$validkeys = Tonality::getValidKeys($mode);
		$isvalidtonic = false;
		foreach ($validkeys as $key) {
			if ($comptonic->equals($key->getTonic(), false)) {
				$isvalidtonic = true;
				break;
			}
		}
		if (!$isvalidtonic) {
			$errors['musictheory_givennoteelementgroup'] =
					get_string('validation_scale_invalidtonic', 'qtype_musictheory');
		}
		$ltr = $data['musictheory_givennoteletter'];
		$acc = $data['musictheory_givennoteaccidental'];
		$reg = $data['musictheory_givennoteregister'];
		$tonic = new Note($ltr, $acc, $reg);
		$staff = new Staff($data['musictheory_clef']);
		$scaletopnote = $tonic->getNoteFromInterval(new Interval('+', 'P', 8));
		if (!$staff->noteFitsInStaff($tonic, 4) || !$staff->noteFitsInStaff($scaletopnote, 4)) {
			$errors['musictheory_givennoteelementgroup'] =
					get_string('validation_scaleoutsidestaff', 'qtype_musictheory');
		}

		return $errors;
	}

	/**
	 * Validates chord quality form options.
	 *
	 * It makes sure that a given chord quality exists on the given root and is supported.
	 *
	 * @param array $data The form data.
	 * @return array The validation errors.
	 */
	public static function validate_chordquality_options($data) {
		$errors = array();

		switch ($data['musictheory_chordquality']) {
			case 'major':
				$quality = 'M';
				break;
			case 'minor':
				$quality = 'm';
				break;
			case 'diminished':
				$quality = 'D';
				break;
			case 'augmented':
				$quality = 'A';
				break;
			default:
				$quality = 'M';
		}
		$root = new Note($data['musictheory_givennoteletter'], $data['musictheory_givennoteaccidental']);
		$chord = new Chord($root, $quality, 0);

		$chordinvalid = false;
		for ($i = 1; $i < $chord->getNumNotes(); $i++) {
			if ($chord->getChordFactor(1 + ($i * 2)) === null) {
				$chordinvalid = true;
				break;
			}
		}

		if ($chordinvalid) {
			$errors['musictheory_givennoteelementgroup'] =
					get_string('validation_invalidchordquality', 'qtype_musictheory');
		}

		return $errors;
	}

	/**
	 * Validates harmonic function form options.
	 *
	 * It makes sure that a given harmonic function exists and is supported.
	 *
	 * @param array $data The form data.
	 * @return array The validation errors.
	 */
	public static function validate_harmonicfunction_options($data) {
		$errors = array();

		$hfprimary = $data['musictheory_hfprimary'];
		$hfinvext = ($data['musictheory_hfinvext'] === 'r') ? '' : $data['musictheory_hfinvext'];
		$hfsecondary = ($data['musictheory_hfsecondary'] === 'none') ? '' : $data['musictheory_hfsecondary'];
		$tonicltr = substr($data['musictheory_keymode'], 0, 1);
		$tonicacc = substr($data['musictheory_keymode'], 1, 1);
		$tonic = new Note($tonicltr, $tonicacc, 4);
		$ismajor = (substr($data['musictheory_keymode'], 2, 1) === 'M');
		$tonality = new Tonality($tonic, $ismajor);

		$hf = new HarmonicFunction($tonality, $hfprimary . $hfinvext . $hfsecondary);
		$validfunction = $hf->isSupported();
		if (!$validfunction) {
			$errors['musictheory_hfelementgroup'] =
					get_string('validation_harmonicfunctionnotsupported', 'qtype_musictheory');
		}

		if ($validfunction && $data['musictheory_musicqtype'] === 'harmonicfunction-identify') {
			$hftype = $hf->getFunctionType();
			$functionselected = false;
			foreach ($data['musictheory_hfidentifyresponsetypes'] as $responsetype) {
				if ($hftype === $responsetype) {
					$functionselected = true;
				}
			}
			if (!$functionselected) {
				$errors['musictheory_hfidentifyresponsetypes'] =
						get_string('validation_harmonicfunctiontypenotselected', 'qtype_musictheory');
			}
		}

		return $errors;
	}

}