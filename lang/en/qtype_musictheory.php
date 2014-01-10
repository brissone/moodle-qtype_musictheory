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
// Plugin - generic.
$string['pluginname'] = 'Music Theory';
$string['pluginname_help'] = 'This question type enables the creation of several types of music
 theory exercises using a graphical user interface.';
$string['pluginname_link'] = 'question/type/musictheory';
$string['pluginnamesummary'] = 'Enables the creation of several types of music theory exercises.';
$string['pluginnameadding'] = 'Adding a music theory question';
$string['pluginnameediting'] = 'Editing a music theory question';

// Edit form labels and help.
$string['clef'] = 'Clef';
$string['clef-random'] = 'Possible clefs';
$string['considerregister'] = 'Specify register';
$string['considerregister_help'] = "Indicates whether the note's register is to be
    included as part of the question.";
$string['displaykeysignature'] = 'Display key signature';
$string['direction'] = 'Direction';
$string['givennoteelementgroup'] = 'Given note';
$string['keymode'] = 'Key';
$string['mode-random'] = 'Possible modes';
$string['musicqtype'] = 'Music question type';
$string['musictheory_intervalelementgroup'] = 'Interval';
$string['musictheory_intervalelementgroup_help'] = 'Indicates the type of interval.';
$string['musictheory_intervalelementgroup_random'] = 'Possible intervals';
$string['notelbl'] = 'Note';
$string['quality-random'] = 'Possible qualities';
$string['questionoptions'] = 'Question options';
$string['questiontext'] = 'Question text';
$string['questiontext_help'] = "This field isn't required. If left empty, a question text
 appropriate for the given music question type will be automatically displayed within
 activities. If you do enter text in this field, it will replace the automatically
 generated question text.";
$string['scaletype-random'] = 'Possible scale types';
$string['size-random'] = 'Possible sizes';
$string['tonic'] = 'Tonic';
$string['updatemusicqtype'] = 'Update options';

// Music question subtype options.
$string['qtype_note-write'] = 'Note writing';
$string['qtype_note-write-random'] = 'Note writing (random)';
$string['qtype_note-identify'] = 'Note identification';
$string['qtype_note-identify-random'] = 'Note identification (random)';
$string['qtype_keysignature-write'] = 'Key signature writing';
$string['qtype_keysignature-write-random'] = 'Key signature writing (random)';
$string['qtype_keysignature-identify'] = 'Key signature identification';
$string['qtype_keysignature-identify-random'] = 'Key signature identification (random)';
$string['qtype_interval-write'] = 'Interval writing';
$string['qtype_interval-write-random'] = 'Interval writing (random)';
$string['qtype_interval-identify'] = 'Interval identification';
$string['qtype_interval-identify-random'] = 'Interval identification (random)';
$string['qtype_scale-write'] = 'Scale writing';
$string['qtype_scale-write-random'] = 'Scale writing (random)';

// Edit form - grading strategy options and help.
$string['musictheory_gradingstrategy'] = "Grading strategy";
$string['musictheory_gradingstrategy_help'] = "<p>The grading strategy specifies how the question
 will be graded.</p>
 <p><b>All or nothing</b>: The response is compared to the correct answer. If the response
 is correct, full marks are given. If the answer is incorrect, a mark of zero is given.</p>
";
$string['musictheory_gradingstrategy_scale-write'] = "Grading strategy";
$string['musictheory_gradingstrategy_scale-write_help'] = "<p>The grading strategy specifies how
 the question will be graded.</p>
 <p><b>All or nothing</b>: The response is compared to the correct answer. If the response
 is correct, full marks are given. If the answer is incorrect, a mark of zero is given.</p>
 <p><b>Partial credit for each correct note</b>:
 A grading strategy that divides the grade evenly by the number of scale notes the user has
 to enter, and awards partial grade for each correct note.</p>
";
$string['qtype_musictheory_strategy_all_or_nothing'] = "All or nothing";
$string['qtype_musictheory_strategy_note_allornothing'] = "All or nothing";
$string['qtype_musictheory_strategy_scale_creditbynote'] = "Partial credit for each correct note";

// Note names.
$string['noteC'] = 'C';
$string['noteD'] = 'D';
$string['noteE'] = 'E';
$string['noteF'] = 'F';
$string['noteG'] = 'G';
$string['noteA'] = 'A';
$string['noteB'] = 'B';

// Clef options.
$string['treble'] = 'Treble';
$string['bass'] = 'Bass';
$string['alto'] = 'Alto';
$string['tenor'] = 'Tenor';

// Key options.
$string['CnM'] = 'C major';
$string['GnM'] = 'G major';
$string['DnM'] = 'D major';
$string['AnM'] = 'A major';
$string['EnM'] = 'E major';
$string['BnM'] = 'B major';
$string['FsharpM'] = 'F&#9839; major';
$string['CsharpM'] = 'C&#9839; major';
$string['FnM'] = 'F major';
$string['BbM'] = 'B&#9837; major';
$string['EbM'] = 'E&#9837; major';
$string['AbM'] = 'A&#9837; major';
$string['DbM'] = 'D&#9837; major';
$string['GbM'] = 'G&#9837; major';
$string['CbM'] = 'C&#9837; major';
$string['Anm'] = 'A minor';
$string['Enm'] = 'E minor';
$string['Bnm'] = 'B minor';
$string['Fsharpm'] = 'F&#9839; minor';
$string['Csharpm'] = 'C&#9839; minor';
$string['Gsharpm'] = 'G&#9839; minor';
$string['Dsharpm'] = 'D&#9839; minor';
$string['Asharpm'] = 'A&#9839; minor';
$string['Dnm'] = 'D minor';
$string['Gnm'] = 'G minor';
$string['Cnm'] = 'C minor';
$string['Fnm'] = 'F minor';
$string['Bbm'] = 'B&#9837; minor';
$string['Ebm'] = 'E&#9837; minor';
$string['Abm'] = 'A&#9837; minor';

// Interval direction options.
$string['dirasc'] = 'Above the given note';
$string['dirdesc'] = 'Below the given note';

// Interval qualities.
$string['qualityM'] = 'Major';
$string['qualitym'] = 'Minor';
$string['qualityP'] = 'Perfect';
$string['qualityA'] = 'Augmented';
$string['qualityD'] = 'Diminished';
$string['major'] = 'Major';
$string['minor'] = 'Minor';
$string['perfect'] = 'Perfect';
$string['augmented'] = 'Augmented';
$string['diminished'] = 'Diminished';

// Interval sizes.
$string['size2'] = '2nd';
$string['size3'] = '3rd';
$string['size4'] = '4th';
$string['size5'] = '5th';
$string['size6'] = '6th';
$string['size7'] = '7th';
$string['size8'] = '8ve';
$string['size9'] = '9th';
$string['size10'] = '10th';
$string['size11'] = '11th';
$string['size12'] = '12th';
$string['size13'] = '13th';

// Intervals
$string['D2'] = 'Diminished 2nd';
$string['m2'] = 'Minor 2nd';
$string['M2'] = 'Major 2nd';
$string['A2'] = 'Augmented 2nd';

$string['D3'] = 'Diminished 3rd';
$string['m3'] = 'Minor 3rd';
$string['M3'] = 'Major 3rd';
$string['A3'] = 'Augmented 3rd';

$string['D4'] = 'Diminished 4th';
$string['P4'] = 'Major 4th';
$string['A4'] = 'Augmented 4th';

$string['D5'] = 'Diminished 5th ';
$string['P5'] = 'Major 5th';
$string['A5'] = 'Augmented 5th';

$string['D6'] = 'Diminished 6th';
$string['m6'] = 'Minor 6th';
$string['M6'] = 'Major 6th';
$string['A6'] = 'Augmented 6th';

$string['D7'] = 'Diminished 7th';
$string['m7'] = 'Minor 7th';
$string['M7'] = 'Major 7th';
$string['A7'] = 'Augmented 7th';

$string['D8'] = 'Diminished octave';
$string['P8'] = 'Major octave';
$string['A8'] = 'Augmented octave';

$string['D9'] = 'Diminished 9th';
$string['m9'] = 'Minor 9th';
$string['M9'] = 'Major 9th';
$string['A9'] = 'Augmented 9th';

$string['D10'] = 'Diminished 10th';
$string['m10'] = 'Diminished 10th';
$string['M10'] = 'Major 10th';
$string['A10'] = 'Augmented 10th';

$string['D11'] = 'Diminished 11th';
$string['P11'] = 'Major 11th';
$string['A11'] = 'Augmented 11th';

$string['D12'] = 'Diminished 12th';
$string['P12'] = 'Major 12th';
$string['A12'] = 'Augmented 12th';

$string['D13'] = 'Diminished 13th';
$string['m13'] = 'Minor 13th';
$string['M13'] = 'Major 13th';
$string['A13'] = 'Augmented 13th';

// Scale types.
$string['scaletype'] = 'Scale type';
$string['scaletype_major'] = 'Major';
$string['scaletype_natural'] = 'Natural minor';
$string['scaletype_harmonic'] = 'Harmonic minor';
$string['scaletype_melodic'] = 'Melodic minor';

// Edit form validation.
$string['validation_noteoutsidestaff'] = "This note's register doesn't fit within the staff
 in the specified clef.";
$string['validation_qualitymismatch'] = "This combination of interval size and quality is invalid.";
$string['validation_invalidinterval_above'] = "This interval cannot be written above the given note.";
$string['validation_invalidinterval_below'] = "This interval cannot be written below the given note.";
$string['validation_intervaloutsidestaff'] = "The given note's register produces an interval that
 doesn't fit within the staff in the given clef.";
$string['validation_interval_novalidcombo'] = "The selected possible qualities and sizes do not
 produce at least one valid interval.";
$string['validation_scale_invalidtonic'] = "Invalid tonic for the specified type of scale.";
$string['validation_scaleoutsidestaff'] = "The given tonic's register produces a scale that doesn't
 fit within the staff in the given clef.";

// Question rendering.
$string['correctansweris'] = 'The correct answer is:';
$string['correctansweris_morethanone'] = 'One possible correct answer could be:';
$string['selectakey'] = "Select a key";
$string['selectasize'] = "Select a size";
$string['selectaquality'] = "Select a quality";
$string['trebleclef'] = 'Treble clef';
$string['bassclef'] = 'Bass clef';
$string['altoclef'] = 'Alto clef';
$string['tenorclef'] = 'Tenor clef';

// Question text and help button.
$string['questiontext_note_write'] = 'Enter the following note';
$string['questiontext_note_identify'] = 'Identify the following note';
$string['questiontext_keysignature_write'] = 'Enter the following key signature';
$string['questiontext_keysignature_identify_major'] = 'Determine the major key represented by the
 following key signature';
$string['questiontext_keysignature_identify_minor'] = 'Determine the minor key represented by the
 following key signature';
$string['questiontext_interval_write_above'] = 'Enter the following interval <b>above</b> the given note';
$string['questiontext_interval_write_below'] = 'Enter the following interval <b>below</b> the given note';
$string['questiontext_interval_identify'] = 'Identify the following interval';
$string['questiontext_scale_write'] = 'Write the following scale in ascending direction';
$string['questiontext_scale_write_melodic'] = 'Write the following scale in both ascending and
     descending directions';

$string['acc_n'] = '&#9838;';
$string['acc_sharp'] = '&#9839;';
$string['acc_x'] = 'x';
$string['acc_b'] = '&#9837;';
$string['acc_bb'] = 'bb';

$string['note_write_questionastext'] = 'Note answer entry';
$string['note_write_questionastext_help'] = '<p>Enter the response note, without spaces, using
 the following syntax:</p><p>[Uppercase letter name] [Accidental ("n" = natural, "#" = sharp,
 "b" = flat, "x" = double-sharp, "bb" = double-flat)] [Register (a digit between 1 and 6, following
 the scientific pitch notation)]</p><p>Examples:
 </p><ul><li><b>Gn5</b></li><li><b>A#4</b></li><li><b>Ebb3</b></li></ul>';
$string['note_write_questionasui'] = 'Note answer entry';
$string['note_write_questionasui_help'] = '<p>Enter the note by clicking on the staff, after
 selecting the type of accidental in the right-hand toolbar. To delete the note, click on it again.</p>';
$string['keysignature_write_questionastext'] = 'Key signature answer entry';
$string['keysignature_write_questionastext_help'] = '<p>Enter a comma-separated list of accidentals
 (between 1 and 7 of them), without spaces, using the following syntax:</p><p>[Uppercase letter name]
 [Accidental ("#" = sharp, "b" = flat)] [Register (a digit between 2 and 5, following the scientific
 pitch notation)], ... </p><p>Example: <b>A#4,F#4,G#4</b></p>';
$string['keysignature_write_questionasui'] = 'Key signature answer entry';
$string['keysignature_write_questionasui_help'] = '<p>Enter accidentals by clicking on the staff,
 after selecting the type of accidental in the right-hand toolbar. To delete an accidental, click on
 it again.</p>';
$string['interval_write_questionastext'] = 'Interval answer entry';
$string['interval_write_questionastext_help'] = '<p>Enter the response note, without spaces, using
 the following syntax:</p><p>[Uppercase letter name] [Accidental ("n" = natural, "#" = sharp,
 "b" = flat, "x" = double-sharp, "bb" = double-flat)] [Register (a digit between 1 and 6, following
 the scientific pitch notation)]</p><p>Examples:
 </p><ul><li><b>Gn5</b></li><li><b>A#4</b></li><li><b>Ebb3</b></li></ul>';
$string['interval_write_questionasui'] = 'Interval answer entry';
$string['interval_write_questionasui_help'] = '<p>Enter the note by clicking on the staff, after
 selecting the type of accidental in the right-hand toolbar. To delete the note, click on it again.</p>';
$string['scale_write_questionastext'] = 'Scale answer entry';
$string['scale_write_questionastext_help'] = '<p>Enter a comma-separated list of notes, including
 the specified tonic, without spaces, using the following syntax:</p><p>[Uppercase letter name]
 [Accidental ("n" = natural, "#" = sharp, "b" = flat, "x" = double-sharp, "bb" = double-flat)]
 [Register (a digit between 2 and 6, following the scientific pitch notation)], ... </p>
 <p>Random example: <b>Tonic = An4 answer=>An4,Bb4,C#5,D#5,E#5,F#5,G#5,An5</b></p>';
$string['scale_write_questionasui'] = 'Scale answer entry';
$string['scale_write_questionasui_help'] = '<p>Enter notes by clicking on the staff, after selecting
 the type of accidental in the right-hand toolbar. To delete a note, click on it again.</p>
 <p>Note that accidentals carry over to subsequent notes.</p>';
$string['emptykeysignature'] = 'Empty key signature';

// Question answer validation.
$string['validationerror_note_identify'] = 'Incomplete answer. The letter name, accidental
 and register must be selected.';
$string['validationerror_empty'] = 'No answer was provided.';
$string['validationerror_interval_identify'] = 'Incomplete answer. Both the quality and the size
 must be selected.';
$string['validationerror_invalidsyntax'] = 'Invalid answer syntax.';
$string['validationerror_scale_incomplete'] = 'Incomplete answer. A total of 8 notes is required,
 including the given tonic.';
$string['validationerror_scale_incomplete_melodic'] = 'Incomplete answer. A total of 15 notes is
 required, including the given tonic.';
$string['validationerror_whitespace'] = 'Invalid answer syntax: remove all spaces from your answer.';