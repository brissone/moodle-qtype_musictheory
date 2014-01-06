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
 *     <li>'keysignature-write'</li>
 *     <li>'keysignature-identify'</li>
 *     <li>'interval-identify'</li>
 *     <li>'keysignature-identify'</li>
 *     <li>'scale-write'</li>
 *     </ul>
 *   </li>
 *   <li><b>{String} clef</b>: Indicates which clef to use ('treble', 'bass',
 *   'alto', 'tenor'). Mandatory for the following types: scale, interval, key
 *   signature, harmonic function.
 *   </li>
 *   <li><b>{Boolean} includeKS</b>: Indicates whether a key signature should be
 *   displayed. Used for the following types: scale, harmonic function.
 *   </li>
 *   <li><b>{String} key</b>: Indicates the key and mode, for key signature
 *   display purposes (e.g. 'C#M', 'gm'). Mandatory if includeKS is set to true,
 *   and also mandatory for the four-part voice-leading canvas type.
 *   </li>
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
        case 'keysignature-write':
          return this.getKSWriteTextOutput(stateXML);
        case 'keysignature-identify':
          return this.getKSIdentifyTextOutput();
        case 'interval-write':
          return this.getIntervalWriteTextOutput(stateXML);
        case 'interval-identify':
          return this.getIntervalIdentifyTextOutput();
        case 'scale-write':
          return this.getScaleWriteTextOutput(stateXML);
        default:
          return '';
      }
      return '';
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
  parts.reg = noteName.substr(noteName.length - 1, 1);
  if (noteName.length === 2) {
    parts.acc = 'n';
  }
  else {
    parts.acc = noteName.substring(1, noteName.length - 1);
  }
  return parts;
};