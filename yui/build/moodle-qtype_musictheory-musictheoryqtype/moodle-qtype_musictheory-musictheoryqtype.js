YUI.add('moodle-qtype_musictheory-musictheoryqtype', function (Y, NAME) {

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

/**
 * This module takes care of instantiating MusThGUI canvases for the Moodle
 * music theory question type.
 *
 * @module Moodle Music Theory Question Type
 */

/**
 * Although documented as a class, this file is simply a container for module
 * functions.
 *
 * @class musictheoryqtype
 * @static
 */

M.qtype_musictheory = M.qtype_musictheory || {};
M.qtype_musictheory.musictheoryqtype = {};
var NS = M.qtype_musictheory.musictheoryqtype;

NS.questionRender = {};

/**
 * Initializes MusThGUI canvases when a music theory question is displayed.
 *
 * @method initQuestionRender
 * @param {String} HTMLInputID The unique id of the text input that the MusThGUI
 * canvas is to replace.
 * @param {String} optionsXML An XML string specifying the Moodle music
 * question's settings.
 * @param {Boolean} readOnly Indicates whether the canvas should be editable.
 * @param {String} initialInput The initial input to use when initializing the
 * MusThGUI canvas, formatted in accordance with the music question type.
 * @param {String} correctResponse The correct answer for the question,
 * formatted in accordance with the music question type.
 * @param {String} correctRespStr The sentence to display when the correct
 * answer is rendered.
 * @return {Undefined}
 */
NS.initQuestionRender = function(HTMLInputID, optionsXML, readOnly,
		initialInput, correctResponse, correctRespStr) {

	var options = NS.questionRender.convertOptionsXMLtoObjectLiteral(optionsXML);

	NS.questionRender.renderQuestion(HTMLInputID, options,
			readOnly, initialInput);

	if (correctResponse !== null && typeof(correctResponse) !== 'undefined' &&
			correctResponse !== '') {
		NS.questionRender.renderCorrectResponse(HTMLInputID, options,
				correctResponse,
				correctRespStr);
	}

};

/**
 * Initializes the MusThGUI canvas for the question section.
 *
 * @method renderQuestion
 * @param {String} HTMLInputID The unique id of the text input that the MusThGUI
 * canvas is to replace.
 * @param {Object literal} options An object literal specifying the Moodle music
 * question's settings.
 * @param {Boolean} readOnly Indicates whether the canvas should be editable.
 * @param {String} initialInput The initial input to use when initializing the
 * MusThGUI canvas, formatted in accordance with the music question type.
 * @return {Undefined}
 */
NS.questionRender.renderQuestion = function(HTMLInputID, options,
		readOnly, initialInput) {

	HTMLInputID = HTMLInputID.replace(':', '\\:');

	var YInput = Y.one('#' + HTMLInputID);

	var replacedDiv = Y.one(
			'#' + 'musictheory_div_replacedbycanvas_' + HTMLInputID);
	if (replacedDiv) {
		replacedDiv.hide();
	}

	var canvasDiv = Y.one('#musictheory_div_canvas_' + HTMLInputID);

	if (!canvasDiv) {
		return;
	}

	var displayCanvasID = 'musictheory_renderMusicCanvas_' + HTMLInputID.replace(
			'\\:', '-');

	var canvasNode = Y.one('#' + displayCanvasID);
	if (!canvasNode) {
		canvasNode = Y.Node.create(
				'<div style="margin-top:10px;margin-bottom:15px;overflow:auto"><canvas id="' +
				displayCanvasID + '" width="1" height="1" /></div>');
		canvasDiv.append(canvasNode);
	}

	options.editable = !readOnly;
	options.containsUserInput = true;

	var xmlConverter = new NS.XMLConverter(options);
	var callBack = function(stateXML) {
		YInput.set('value', xmlConverter.getCanvasTextOutput(stateXML));
	};

	var stateXML = xmlConverter.getCanvasXML(initialInput);
	new MusThGUI(displayCanvasID, stateXML, callBack,
			options.editable);

	canvasDiv.show();
};

/**
 * Initializes MusThGUI canvases when a music theory question is displayed.
 *
 * @method renderCorrectResponse
 * @param {String} HTMLInputID The unique id of the text input that the MusThGUI
 * canvas is to replace.
 * @param {String} options An XML string specifying the Moodle music
 * question's settings.
 * @param {String} correctResponse The correct answer for the question,
 * formatted in accordance with the music question type.
 * @param {String} correctResponseStr The sentence to display when the correct
 * answer is rendered.
 * @return {Undefined}
 */
NS.questionRender.renderCorrectResponse = function(HTMLInputID, options,
		correctResponse, correctResponseStr) {

	HTMLInputID = HTMLInputID.replace(':', '\\:');
	var YInput = Y.one('#' + 'musictheory_correctanswerdiv_' + HTMLInputID);

	if (!YInput) {
		return;
	}

	var correctCanvasID = 'musictheory_renderCorrectResponseCanvas_' +
			HTMLInputID.replace('\\:', '-');

	var canvasNode = Y.one('#' + correctCanvasID);
	if (!canvasNode) {
		YInput.setHTML('<p>' + correctResponseStr + '</p>' +
				'<canvas id="' + correctCanvasID + '" width="1" height="1" />');
	}

	options.editable = false;
	options.containsUserInput = false;

	var xmlConverter = new NS.XMLConverter(options);
	var callBack = function() {
	};

	var stateXML = xmlConverter.getCanvasXML(correctResponse);
	new MusThGUI(correctCanvasID, stateXML, callBack,
			options.editable);

};

/**
 * Converts the question options from XML to an object literal.
 *
 * @method convertOptionsXMLtoObjectLiteral
 * @param {String} optionsXML An XML string specifying the Moodle music
 * question's settings.
 * @return {Object literal}
 */
NS.questionRender.convertOptionsXMLtoObjectLiteral = function(optionsXML) {

	var parsedXML = Y.XML.parse(optionsXML);
	var options = {};

	var optionsNode = parsedXML.getElementsByTagName('options')[0].firstChild;
	var musicQType = optionsNode.nodeName;

	options.musicQType = musicQType;

	switch (musicQType) {
		case 'note-write':
		case 'note-identify':
			options.clef = optionsNode.getElementsByTagName(
					'clef')[0].firstChild.nodeValue;
			options.includeAlterations = optionsNode.getElementsByTagName(
					'includealterations')[0].firstChild.nodeValue;
			options.includeAlterations = (options.includeAlterations === 'true');
			break;
		case 'keysignature-write':
		case 'keysignature-identify':
			options.clef = optionsNode.getElementsByTagName(
					'clef')[0].firstChild.nodeValue;
			options.key = optionsNode.getElementsByTagName(
					'key')[0].firstChild.nodeValue;
			break;
		case 'interval-write':
		case 'interval-identify':
			options.clef = optionsNode.getElementsByTagName(
					'clef')[0].firstChild.nodeValue;
			options.givenNote = [];
			options.givenNote.ltr =
					optionsNode.getElementsByTagName('letter')[0].firstChild.nodeValue;
			options.givenNote.acc =
					optionsNode.getElementsByTagName(
					'accidental')[0].firstChild.nodeValue;
			options.givenNote.reg =
					optionsNode.getElementsByTagName('register')[0].firstChild.nodeValue;
			break;
		case 'scale-write':
			options.clef = optionsNode.getElementsByTagName(
					'clef')[0].firstChild.nodeValue;
			options.givenNote = [];
			options.givenNote.ltr =
					optionsNode.getElementsByTagName('letter')[0].firstChild.nodeValue;
			options.givenNote.acc =
					optionsNode.getElementsByTagName(
					'accidental')[0].firstChild.nodeValue;
			options.givenNote.reg =
					optionsNode.getElementsByTagName('register')[0].firstChild.nodeValue;
			options.includeKS =
					optionsNode.getElementsByTagName(
					'displaykeysignature')[0].firstChild.nodeValue;
			options.includeKS = (options.includeKS === 'true');
			options.scaleType = optionsNode.getElementsByTagName(
					'scaletype')[0].firstChild.nodeValue;
			break;
	}

	return options;

};

NS.editForm = {};

/**
 * Initializes the javascript functionalities used during music theory question
 * editing.
 *
 * @method initEditForm
 * @return {Undefined}
 */
NS.initEditForm = function() {

	NS.editForm.setOptionVisibility();
	NS.editForm.setFormOptionListeners();

};

/**
 * Attaches listeners to elements in the edit form.
 *
 * @method setFormOptionListeners
 * @return {Undefined}
 */
NS.editForm.setFormOptionListeners = function() {

	Y.all(
			'#id_musictheory_musicqtype').on('change', function() {
		var typeBtnNode = Y.one('#' + 'id_musictheory_updatemusicqtype');
		if (typeBtnNode) {
			typeBtnNode.simulate('click');
		}
	});

};

/**
 * Hides elements in the edit form as necessary.
 *
 * @method setOptionVisibility
 * @return {Undefined}
 */
NS.editForm.setOptionVisibility = function() {

	var typeBtnNode = Y.one('#' + 'id_musictheory_updatemusicqtype');
	if (typeBtnNode) {
		typeBtnNode.hide();
	}

};

/**
 * Returns the key signature of a given key in the given clef.
 *
 * @method getKeySign
 * @param {String} key - The given key (e.g. 'C#M', 'Ebm', 'FM'). Letter names
 * are to be upper case, and the mode is case sensitive ('M' = major,
 * 'm' = minor).
 * @param {String} clef - The clef ('treble', 'bass', 'alto', 'tenor').
 * @return {Array} Returns an array of note names listing the accidentals in
 * the key signature. If the tonic and mode are invalid, returns null.
 */
NS.getKeySign = function(key, clef) {

	var tonic = key.substring(0, key.length - 1);
	var mode = key.substr(key.length - 1, 1);

	var sharpOrFlat = [];
	sharpOrFlat.Cn = 'sharp';
	sharpOrFlat.Gn = 'sharp';
	sharpOrFlat.Dn = 'sharp';
	sharpOrFlat.An = 'sharp';
	sharpOrFlat.En = 'sharp';
	sharpOrFlat.Bn = 'sharp';
	sharpOrFlat['F#'] = 'sharp';
	sharpOrFlat['C#'] = 'sharp';
	sharpOrFlat.Fn = 'flat';
	sharpOrFlat.Bb = 'flat';
	sharpOrFlat.Eb = 'flat';
	sharpOrFlat.Ab = 'flat';
	sharpOrFlat.Db = 'flat';
	sharpOrFlat.Gb = 'flat';
	sharpOrFlat.Cb = 'flat';

	var trebleSharp = new Array('F#5', 'C#5', 'G#5', 'D#5', 'A#4', 'E#5', 'B#4');
	var bassSharp = new Array('F#3', 'C#3', 'G#3', 'D#3', 'A#2', 'E#3', 'B#2');
	var altoSharp = new Array('F#4', 'C#4', 'G#4', 'D#4', 'A#3', 'E#4', 'B#3');
	var tenorSharp = new Array('F#3', 'C#4', 'G#3', 'D#4', 'A#3', 'E#4', 'B#3');
	var trebleFlat = new Array('Bb4', 'Eb5', 'Ab4', 'Db5', 'Gb4', 'Cb5', 'Fb4');
	var bassFlat = new Array('Bb2', 'Eb3', 'Ab2', 'Db3', 'Gb2', 'Cb3', 'Fb2');
	var altoFlat = new Array('Bb3', 'Eb4', 'Ab3', 'Db4', 'Gb3', 'Cb4', 'Fb3');
	var tenorFlat = new Array('Bb3', 'Eb4', 'Ab3', 'Db4', 'Gb3', 'Cb4', 'Fb3');

	var accList = [];
	accList.treblesharp = trebleSharp;
	accList.basssharp = bassSharp;
	accList.altosharp = altoSharp;
	accList.tenorsharp = tenorSharp;
	accList.trebleflat = trebleFlat;
	accList.bassflat = bassFlat;
	accList.altoflat = altoFlat;
	accList.tenorflat = tenorFlat;

	var numAccMajor = [];
	numAccMajor.Cn = 0;
	numAccMajor.Gn = 1;
	numAccMajor.Dn = 2;
	numAccMajor.An = 3;
	numAccMajor.En = 4;
	numAccMajor.Bn = 5;
	numAccMajor['F#'] = 6;
	numAccMajor['C#'] = 7;
	numAccMajor.Fn = 1;
	numAccMajor.Bb = 2;
	numAccMajor.Eb = 3;
	numAccMajor.Ab = 4;
	numAccMajor.Db = 5;
	numAccMajor.Gb = 6;
	numAccMajor.Cb = 7;

	var relativeMajorKeys = [];
	relativeMajorKeys.An = 'Cn';
	relativeMajorKeys.En = 'Gn';
	relativeMajorKeys.Bn = 'Dn';
	relativeMajorKeys['F#'] = 'An';
	relativeMajorKeys['C#'] = 'En';
	relativeMajorKeys['G#'] = 'Bn';
	relativeMajorKeys['D#'] = 'F#';
	relativeMajorKeys['A#'] = 'C#';
	relativeMajorKeys.Dn = 'Fn';
	relativeMajorKeys.Gn = 'Bb';
	relativeMajorKeys.Cn = 'Eb';
	relativeMajorKeys.Fn = 'Ab';
	relativeMajorKeys.Bb = 'Db';
	relativeMajorKeys.Eb = 'Gb';
	relativeMajorKeys.Ab = 'Cb';

	var majorTonic = (mode === 'M') ? tonic : relativeMajorKeys[tonic];

	var acc;
	acc = accList[clef + sharpOrFlat[majorTonic]];
	acc = acc.slice(0, numAccMajor[majorTonic]);

	return acc;

};// This file is part of Moodle - http://moodle.org/
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

/**
 * The XMLConverter object takes care of converting canvas
 * options into a MusThGUI XML input.
 *
 * @class XMLConverter
 *
 * @constructor
 * @param {Object literal} options The canvas options. Properties include:
 * <ul>
 *   <li><b>{String} musicQType</b>: Indicates the type of canvas to instantiate.
 *   This index can have the following string values:
 *     <ul>
 *     <li>'note-write'</li>
 *     <li>'keysignature-write'</li>
 *     <li>'keysignature-identify'</li>
 *     <li>'interval-identify'</li>
 *     <li>'keysignature-identify'</li>
 *     <li>'scale-write'</li>
 *     </ul>
 *   </li>
 *   <li><b>{String} clef</b>: Indicates which clef to use ('treble', 'bass',
 *   'alto', 'tenor'). Mandatory for the following types: note, scale, interval,
 *   key signature.
 *   </li>
 *   <li><b>{Boolean} includeKS</b>: Indicates whether a key signature should be
 *   displayed. Used for the following types: scale.
 *   </li>
 *   <li><b>{Boolean} includeAlterations</b>: Indicates whether alterations should
 *   be included in note writing/identification questions.
 *   </li>
 *   <li><b>{String} key</b>: Indicates the key and mode, for key signature
 *   display purposes (e.g. 'C#M', 'gm'). Mandatory if includeKS is set to true,
 *   and also mandatory for the four-part voice-leading canvas type.
 *   </li>
 *   <li><b>{String} givenNote</b>: Specifies a note to display in terms of
 *   letter name (.ltr), accidental (.acc) and register (.reg)
 *   <li><b>{String} scaleType</b>: Specifies the type of minor scale ('natural',
 *   'harmonic', 'melodic'). Used only for scale canvas types.
 *   <li><b>{String} givenNote</b>: Provides a static note to be
 *   displayed in scale and interval questions (e.g. 'Ab4'). This note will not
 *   be editable. It will be include as part of the answer for scale types, but
 *   not included for interval types. Used only for scale and interval
 *   types.
 *   </li>
 *   <li><b>{Boolean} editable</b>: Indicates whether the canvas will be
 *   editable after initialization. Mandatory for all canvas types.
 *   </li>
 *   <li><b>{Boolean} containsUserInput</b>: Indicates whether the canvas
 *   display elements that were added by the user. If not, display all notes
 *   in black (to indicate that Moodle has generated them).
 *   </li>
 * </ul>
 * @return {undefined}
 */
NS.XMLConverter = function(options) {

	this.options = options;
	this.setNotesEditable = (options.containsUserInput) ? true : false;

};

/**
 * Converts the options and initial input into an XML string that can be
 * passed to a MusThGUI instance.
 *
 * @method getCanvasXML
 * @param {String} input Provides the initial input as a string,
 * formatted according to the canvas type. An empty string is used to
 * indicate a blank input. Input formats are the following:
 *    <ul>
 *      <li>for scales: e.g. 'A3,B3,C#4,D4,E4,F#4,G#4,A4'</li>
 *      <li>for intervals: e.g. 'G#3'</li>
 *      <li>for key signatures: e.g. 'F#5,C#5,G#5'</li>
 *    </li>
 *   </ul>
 * @return {String} A MusThGUI compatible XML string.
 */
NS.XMLConverter.prototype.getCanvasXML = function(input) {

	switch (this.options.musicQType) {
		case 'note-write':
			return this.getNoteWriteXML(input);
		case 'note-identify':
			return this.getNoteIdentifyXML(input);
		case 'keysignature-write':
			return this.getKSWriteXML(input);
		case 'keysignature-identify':
			return this.getKSIdentifyXML(input);
		case 'interval-write':
			return this.getIntervalWriteXML(input);
		case 'interval-identify':
			return this.getIntervalIdentifyXML(input);
		case 'scale-write':
			return this.getScaleWriteXML(input);
		default:
			return null;
	}

};

/**
 * Converts the MusThGUI's state from a XML to a simpler string describing
 * the state in a format suited for the Moodle music question subtype.
 *
 * @method getCanvasTextOutput
 * @param {String} stateXML The MusThGUI canvas' state, as XML
 * @return {String} A string describing the state in a format compatible with
 * the Moodle music question subtype.
 */
NS.XMLConverter.prototype.getCanvasTextOutput =
		function(stateXML) {
			switch (this.options.musicQType) {
				case 'note-write':
					return this.getNoteWriteTextOutput(stateXML);
				case 'keysignature-write':
					return this.getKSWriteTextOutput(stateXML);
				case 'interval-write':
					return this.getIntervalWriteTextOutput(stateXML);
				case 'scale-write':
					return this.getScaleWriteTextOutput(stateXML);
				default:
					return '';
			}
			return '';
		};

/**
 * Converts the MusThGUI's state from a XML to a simpler string describing
 * the state in a format suited for note writing questions.
 *
 * @method getNoteWriteTextOutput
 * @param {String} stateXML The MusThGUI canvas' state, as XML
 * @return {String} A string describing the state in a format compatible for
 * interval writing questions.
 */
NS.XMLConverter.prototype.getNoteWriteTextOutput =
		function(stateXML) {

			var parsedXML = Y.XML.parse(stateXML);
			var respString = '';
			var noteXML = parsedXML.getElementsByTagName('Note');
			var i = 0;
			for (i = 0; i < noteXML.length; i++) {
				var acc;
				if (noteXML[i].getAttribute('editable') === 'true') {
					acc = noteXML[i].getAttribute('accidental');
					respString += noteXML[i].getAttribute('letter') + acc +
							noteXML[i].getAttribute('register') + ',';
				}
			}
			if (respString.length > 0) {
				respString = respString.substr(0, respString.length - 1);
			}
			else {
				respString = '';
			}
			return respString;

		};

/**
 * Converts the options and initial input for a note writing question
 * into an XML string that can be passed to a MusThGUI instance.
 *
 * @method getNoteWriteXML
 * @param {String} input Provides the initial input as a string, formatted
 * as a Moodle key signature writing response.
 * @return {String} A MusThGUI compatible XML string.
 */
NS.XMLConverter.prototype.getNoteWriteXML = function(input) {

	var stateXML = '<MusThGUI>\n';
	stateXML += '<StaffSystem maxLedgerLines="4">\n';
	stateXML += '<Staff clef="' + this.options.clef + '">\n';
	stateXML += '<KeySign totalAccColumns="0" >';
	stateXML += '</KeySign>';
	stateXML += '<NoteColumns>';
	stateXML += '<NoteColumn maxNotes="1" >';

	if (input !== '' && input !== null && typeof(input) !== 'undefined') {
		if (input.length === 2) {
			input += '4';
		}
		var inputParts = this.noteNameToParts(input);
		stateXML += '<Note letter="' + inputParts.ltr + '" ';
		stateXML += 'register="' + inputParts.reg + '" ';
		stateXML += 'accidental="' + inputParts.acc + '" ';
		stateXML += 'noteValue="whole" editable="' + this.setNotesEditable + '" />';
	}

	stateXML += '</NoteColumn>';
	stateXML += '</NoteColumns>';

	stateXML += '</Staff>\n';
	stateXML += '</StaffSystem>\n';
	if (this.options.includeAlterations) {
		stateXML += '    <Toolbars>\n';
		stateXML += '        <AccidentalToolbar>\n';
		stateXML += '            <Button symbol="n"/>';
		stateXML += '            <Button symbol="#"/>';
		stateXML += '            <Button symbol="b"/>';
		stateXML += '            <Button symbol="x"/>';
		stateXML += '            <Button symbol="bb"/>';
		stateXML += '        </AccidentalToolbar>\n';
		stateXML += '    </Toolbars>\n';
	}
	stateXML += '</MusThGUI>';

	return stateXML;
};

/**
 * Converts the options and initial input for a note identification question
 * into an XML string that can be passed to a MusThGUI instance.
 *
 * @method getNoteIdentifyXML
 * @param {String} input Provides the initial input as a string, formatted
 * as a Moodle key signature writing response.
 * @return {String} A MusThGUI compatible XML string.
 */
NS.XMLConverter.prototype.getNoteIdentifyXML = function(input) {

	var stateXML = '<MusThGUI>\n';
	stateXML += '<StaffSystem maxLedgerLines="4">\n';
	stateXML += '<Staff clef="' + this.options.clef + '">\n';
	stateXML += '<KeySign totalAccColumns="0" >';
	stateXML += '</KeySign>';
	stateXML += '<NoteColumns>';
	stateXML += '<NoteColumn maxNotes="1" >';

	var inputParts = this.noteNameToParts(input);
	stateXML += '<Note letter="' + inputParts.ltr + '" ';
	stateXML += 'register="' + inputParts.reg + '" ';
	stateXML += 'accidental="' + inputParts.acc + '" ';
	stateXML += 'noteValue="whole" editable="false" />';

	stateXML += '</NoteColumn>';
	stateXML += '</NoteColumns>';

	stateXML += '</Staff>\n';
	stateXML += '</StaffSystem>\n';
	stateXML += '</MusThGUI>';

	return stateXML;
};

/**
 * Converts the MusThGUI's state from a XML to a simpler string describing
 * the state in a format suited for key signature writing questions.
 *
 * @method getKSWriteTextOutput
 * @param {String} stateXML The MusThGUI canvas' state, as XML
 * @return {String} A string describing the state in a format compatible for key
 * signature writing questions.
 */
NS.XMLConverter.prototype.getKSWriteTextOutput = function(stateXML) {

	var parsedXML = Y.XML.parse(stateXML);
	var respString = '';
	var accXML = parsedXML.getElementsByTagName('Accidental');
	var i;
	for (i = 0; i < accXML.length; i++) {
		respString += accXML[i].getAttribute('letter') +
				accXML[i].getAttribute('type') +
				accXML[i].getAttribute('register') + ',';
	}
	if (respString.length > 0) {
		respString = respString.substr(0, respString.length - 1);
	}
	else {
		respString = '';
	}
	return respString;

};

/**
 * Converts the options and initial input for a key signature writing question
 * into an XML string that can be passed to a MusThGUI instance.
 *
 * @method getKSWriteXML
 * @param {String} input Provides the initial input as a string, formatted
 * as a Moodle key signature writing response.
 * @return {String} A MusThGUI compatible XML string.
 */
NS.XMLConverter.prototype.getKSWriteXML = function(input) {

	var stateXML = '<MusThGUI>\n';
	stateXML += '<StaffSystem maxLedgerLines="0">\n';
	stateXML += '<Staff clef="' + this.options.clef + '">\n';
	stateXML += '<KeySign totalAccColumns="7">\n';

	var resp;
	if (input === '' || input === null || typeof(input) === 'undefined') {
		resp = null;
	}
	else {
		resp = input.split(',');
	}
	var i;
	if (resp !== null) {
		for (i = 0; i < resp.length; i++) {
			stateXML += '<Accidental type="' + resp[i].substr(1, 1) +
					'" letter="' + resp[i].substr(0, 1) +
					'" register="' + resp[i].substr(2, 1) +
					'" editable="' + this.setNotesEditable + '" />\n';
		}
	}

	stateXML += '</KeySign>\n';
	stateXML += '</Staff>\n';
	stateXML += '</StaffSystem>\n';
	stateXML += '    <Toolbars>\n';
	stateXML += '        <AccidentalToolbar>\n';
	stateXML += '            <Button symbol="#"/>\n';
	stateXML += '            <Button symbol="b"/>\n';
	stateXML += '        </AccidentalToolbar>\n';
	stateXML += '    </Toolbars>\n';
	stateXML += '</MusThGUI>';

	return stateXML;
};

/**
 * Converts the options and initial input for a key signature identification
 * question into an XML string that can be passed to a MusThGUI instance.
 *
 * @method getKSIdentifyXML
 * @param {String} input Provides the initial input as a string, formatted
 * as a Moodle key signature identification response.
 * @return {String} A MusThGUI compatible XML string.
 */
NS.XMLConverter.prototype.getKSIdentifyXML = function(input) {

	var stateXML = '<MusThGUI>\n';
	stateXML += '<StaffSystem maxLedgerLines="0">\n';
	stateXML += '<Staff clef="' + this.options.clef + '">\n';
	stateXML += '<KeySign totalAccColumns="7">\n';

	var resp;
	if (input === '' || input === null || typeof(input) === 'undefined') {
		resp = null;
	}
	else {
		resp = input.split(',');
	}
	var i;
	if (resp !== null) {
		for (i = 0; i < resp.length; i++) {
			stateXML += '<Accidental type="' + resp[i].substr(1, 1) +
					'" letter="' + resp[i].substr(0, 1) +
					'" register="' + resp[i].substr(2, 1) +
					'" editable="false" />\n';
		}
	}

	stateXML += '</KeySign>\n';
	stateXML += '</Staff>\n';
	stateXML += '</StaffSystem>\n';
	stateXML += '    <Toolbars>\n';
	stateXML += '        <AccidentalToolbar>\n';
	stateXML += '            <Button symbol="#"/>\n';
	stateXML += '            <Button symbol="b"/>\n';
	stateXML += '        </AccidentalToolbar>\n';
	stateXML += '    </Toolbars>\n';
	stateXML += '</MusThGUI>';

	return stateXML;
};

/**
 * Converts the MusThGUI's state from a XML to a simpler string describing
 * the state in a format suited for scale writing questions.
 *
 * @method getScaleWriteTextOutput
 * @param {String} stateXML The MusThGUI canvas' state, as XML
 * @return {String} A string describing the state in a format compatible for
 * scale writing questions.
 */
NS.XMLConverter.prototype.getScaleWriteTextOutput =
		function(stateXML) {

			var parsedXML = Y.XML.parse(stateXML);
			var respString = '';
			var noteColXML = parsedXML.getElementsByTagName('NoteColumn');
			var i = 0;
			var noteXML;
			for (i = 0; i < noteColXML.length; i++) {
				noteXML = noteColXML[i].getElementsByTagName('Note')[0];
				if (typeof(noteXML) !== 'undefined' && noteXML !== null) {
					var acc;
					acc = noteXML.getAttribute('accidental');
					respString += noteXML.getAttribute('letter') + acc +
							noteXML.getAttribute('register');
				}
				respString += ',';
			}
			for (i; i < 8; i++) {
				respString += ',';
			}
			respString = respString.substr(0, respString.length - 1);
			return respString;

		};

/**
 * Converts the options and initial input for a scale writing
 * question into an XML string that can be passed to a MusThGUI instance.
 *
 * @method getScaleWriteXML
 * @param {String} input Provides the initial input as a string, formatted
 * as a Moodle scale writing response.
 * @return {String} A MusThGUI compatible XML string.
 */
NS.XMLConverter.prototype.getScaleWriteXML = function(input) {

	var i;
	var noteParts;

	var keySign;
	var key = this.options.givenNote.ltr + this.options.givenNote.acc;
	if (this.options.scaleType === 'major') {
		key += 'M';
	}
	else {
		key += 'm';
	}
	if (this.options.includeKS) {
		keySign = new NS.getKeySign(key, this.options.clef);
	}
	else {
		keySign = [];
	}

	var stateXML = '<MusThGUI>\n';
	stateXML += '<StaffSystem maxLedgerLines="4">\n';
	stateXML += '<Staff clef="' + this.options.clef + '">\n';
	stateXML += '<KeySign totalAccColumns="' + keySign.length + '">\n';
	for (i = 0; i < keySign.length; i++) {
		noteParts = this.noteNameToParts(keySign[i]);
		stateXML += '<Accidental type="' + noteParts.acc + '" letter="' +
				noteParts.ltr + '" register="' + noteParts.reg + '" ' +
				'editable="false" />';
	}
	stateXML += '</KeySign>\n';

	var resp;
	if (input === '' || input === null || typeof(input) === 'undefined') {
		resp = null;
	}
	else {
		resp = input.split(',');
	}

	stateXML += '<NoteColumns>';

	if (resp !== null) {

		for (i = 0; i < resp.length; i++) {
			if (resp[i] !== '') {
				noteParts = this.noteNameToParts(resp[i]);
				stateXML += '<NoteColumn maxNotes="1" >';
				stateXML += '<Note letter="' + noteParts.ltr + '" ';
				stateXML += 'register="' + noteParts.reg + '" ';
				stateXML += 'accidental="' + noteParts.acc + '" ';
				if (i === 0) {
					stateXML += 'noteValue="whole" editable="false" />';
				}
				else {
					stateXML += 'noteValue="whole" editable="' +
							this.setNotesEditable + '" />';
				}
				stateXML += '</NoteColumn>';
			}
			else {
				stateXML += '<NoteColumn maxNotes="1" />';
			}
		}
	}
	else {
		var scaleLength;
		if (this.options.scaleType === 'melodic') {
			scaleLength = 15;
		}
		else {
			scaleLength = 8;
		}
		for (i = 0; i < scaleLength; i++) {
			if (i === 0) {
				stateXML += '<NoteColumn maxNotes="1">';
				stateXML += '<Note letter="' + this.options.givenNote.ltr + '" ';
				stateXML += 'register="' + this.options.givenNote.reg + '" ';
				stateXML += 'accidental="' + this.options.givenNote.acc + '" ';
				stateXML += 'noteValue="whole" editable="false" />';
				stateXML += '</NoteColumn>';
			}
			else {
				stateXML += '<NoteColumn maxNotes="1" />';
			}
		}
	}
	stateXML += '</NoteColumns>';

	stateXML += '</Staff>\n';
	stateXML += '</StaffSystem>\n';
	stateXML += '    <Toolbars>\n';
	stateXML += '        <AccidentalToolbar>\n';
	stateXML += '            <Button symbol="n"/>';
	stateXML += '            <Button symbol="#"/>';
	stateXML += '            <Button symbol="b"/>';
	stateXML += '            <Button symbol="x"/>';
	stateXML += '            <Button symbol="bb"/>';
	stateXML += '        </AccidentalToolbar>\n';
	stateXML += '    </Toolbars>\n';
	stateXML += '</MusThGUI>';

	return stateXML;
};

/**
 * Converts the MusThGUI's state from a XML to a simpler string describing
 * the state in a format suited for interval writing questions.
 *
 * @method getIntervalWriteTextOutput
 * @param {String} stateXML The MusThGUI canvas' state, as XML
 * @return {String} A string describing the state in a format compatible for
 * interval writing questions.
 */
NS.XMLConverter.prototype.getIntervalWriteTextOutput =
		function(stateXML) {

			var parsedXML = Y.XML.parse(stateXML);
			var respString = '';
			var noteXML = parsedXML.getElementsByTagName('Note');
			var i = 0;
			for (i = 0; i < noteXML.length; i++) {
				var acc;
				if (noteXML[i].getAttribute('editable') === 'true') {
					acc = noteXML[i].getAttribute('accidental');
					respString += noteXML[i].getAttribute('letter') + acc +
							noteXML[i].getAttribute('register') + ',';
				}
			}
			if (respString.length > 0) {
				respString = respString.substr(0, respString.length - 1);
			}
			else {
				respString = '';
			}
			return respString;

		};

/**
 * Converts the options and initial input for a interval writing
 * question into an XML string that can be passed to a MusThGUI instance.
 *
 * @method getIntervalWriteXML
 * @param {String} input Provides the initial input as a string, formatted
 * as a Moodle interval writing response.
 * @return {String} A MusThGUI compatible XML string.
 */
NS.XMLConverter.prototype.getIntervalWriteXML = function(input) {

	var stateXML = '<MusThGUI>';
	stateXML += '<StaffSystem maxLedgerLines="4">';
	stateXML += '<Staff clef="' + this.options.clef + '">';
	stateXML += '<KeySign totalAccColumns="0" >';
	stateXML += '</KeySign>';
	stateXML += '<NoteColumns>';
	stateXML += '<NoteColumn maxNotes="2" >';
	stateXML += '<Note letter="' + this.options.givenNote.ltr + '" ';
	stateXML += 'register="' + this.options.givenNote.reg + '" ';
	stateXML += 'accidental="' + this.options.givenNote.acc + '" ';
	stateXML += 'noteValue="whole" editable="false" />';

	if (input !== '' && input !== null && typeof(input) !== 'undefined') {
		var inputParts = this.noteNameToParts(input);
		stateXML += '<Note letter="' + inputParts.ltr + '" ';
		stateXML += 'register="' + inputParts.reg + '" ';
		stateXML += 'accidental="' + inputParts.acc + '" ';
		stateXML += 'noteValue="whole" editable="' + this.setNotesEditable + '" />';
	}

	stateXML += '</NoteColumn>';
	stateXML += '</NoteColumns>';


	stateXML += '</Staff>';
	stateXML += '</StaffSystem>';
	stateXML += '    <Toolbars>\n';
	stateXML += '        <AccidentalToolbar>\n';
	stateXML += '            <Button symbol="n"/>';
	stateXML += '            <Button symbol="#"/>';
	stateXML += '            <Button symbol="b"/>';
	stateXML += '            <Button symbol="x"/>';
	stateXML += '            <Button symbol="bb"/>';
	stateXML += '        </AccidentalToolbar>\n';
	stateXML += '    </Toolbars>\n';
	stateXML += '</MusThGUI>';

	return stateXML;

};

/**
 * Converts the options and initial input for a interval identification
 * question into an XML string that can be passed to a MusThGUI instance.
 *
 * @method getIntervalWriteXML
 * @param {String} input Provides the initial input as a string, formatted
 * as a Moodle interval identification response.
 * @return {String} A MusThGUI compatible XML string.
 */
NS.XMLConverter.prototype.getIntervalIdentifyXML = function(input) {

	var stateXML = '<MusThGUI>';
	stateXML += '<StaffSystem maxLedgerLines="4">';
	stateXML += '<Staff clef="' + this.options.clef + '">';
	stateXML += '<KeySign totalAccColumns="0" >';
	stateXML += '</KeySign>';
	stateXML += '<NoteColumns>';
	stateXML += '<NoteColumn maxNotes="2" >';
	stateXML += '<Note letter="' + this.options.givenNote.ltr + '" ';
	stateXML += 'register="' + this.options.givenNote.reg + '" ';
	stateXML += 'accidental="' + this.options.givenNote.acc + '" ';
	stateXML += 'noteValue="whole" editable="false" />';

	if (input !== '' && input !== null && typeof(input) !== 'undefined') {
		var inputParts = this.noteNameToParts(input);
		stateXML += '<Note letter="' + inputParts.ltr + '" ';
		stateXML += 'register="' + inputParts.reg + '" ';
		stateXML += 'accidental="' + inputParts.acc + '" ';
		stateXML += 'noteValue="whole" editable="false" />';
	}

	stateXML += '</NoteColumn>';
	stateXML += '</NoteColumns>';


	stateXML += '</Staff>';
	stateXML += '</StaffSystem>';
	stateXML += '    <Toolbars>\n';
	stateXML += '        <AccidentalToolbar>\n';
	stateXML += '            <Button symbol="n"/>';
	stateXML += '            <Button symbol="#"/>';
	stateXML += '            <Button symbol="b"/>';
	stateXML += '            <Button symbol="x"/>';
	stateXML += '            <Button symbol="bb"/>';
	stateXML += '        </AccidentalToolbar>\n';
	stateXML += '    </Toolbars>\n';
	stateXML += '</MusThGUI>';

	return stateXML;

};

/**
 * Converts a note represented as a string to an object literal with properties
 * for letter name, accidental and register.
 *
 * @method noteNameToParts
 * @param {String} noteName The note name.
 * @return {Object literal} An object literal with 3 string properties: ltr, acc
 * and reg.
 */
NS.XMLConverter.prototype.noteNameToParts = function(noteName) {
	var parts = [];
	parts.ltr = noteName.substr(0, 1);
	parts.acc = noteName.substr(1, noteName.length - 2);
	parts.reg = noteName.substr(noteName.length - 1, 1);
	return parts;
};

}, '@VERSION@', {"requires": ["base", "node", "datatype", "node-event-simulate"]});
