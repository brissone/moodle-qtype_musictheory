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
$string['pluginname'] = 'Musique - Théorie';
$string['pluginname_help'] = 'Ce type de question permet la création de plusieurs
 exercises concernant la théorie de la musique, en utilisant un interface graphique.';
$string['pluginname_link'] = 'question/type/musictheory';
$string['pluginnamesummary'] = 'Permet la création de plusieurs exercises concernant la théorie de
     la musique.';
$string['pluginnameadding'] = 'Ajouter une question: Musique - Théorie';
$string['pluginnameediting'] = 'Configurer une question: Musique - Théorie';

// Edit form labels and help.
$string['answerlbl'] = 'Réponse';
$string['aug6thgr'] = 'Sixte allemande';
$string['aug6thfr'] = 'Sixte française';
$string['aug6thit'] = 'Sixte italienne';
$string['chordroot'] = 'Fondamentale';
$string['chordquality'] = "Espèces d'accord";
$string['chordquality-random'] = "Espèces d'accord possibles";
$string['clef'] = 'Clef';
$string['clef-random'] = 'Clefs possibles';
$string['considerregister'] = 'Inclure le registre';
$string['considerregister_help'] = "Indique si le registre de la note devrait
    être inclu dans la question.";
$string['includealterations'] = 'Inclure les altérations';
$string['includealterations_help'] = "Indique si les altérations devraient être
 inclues dans la question.";
$string['includestaticnote'] = 'Inclure une note fixe';
$string['displaykeysignature'] = "Afficher l'armature";
$string['direction'] = 'Direction';
$string['givennoteelementgroup'] = 'Note de départ';
$string['harmonicfunctiontype-random'] = 'Fonctions harmoniques possibles';
$string['hfidentifyresponsetypes'] = 'Fonctions harmoniques possibles dans la réponse';
$string['keymode'] = 'Tonalité';
$string['lbl_harmonicfunction'] = 'Fonction harmonique';
$string['mode-random'] = 'Mode possibles';
$string['musicqtype'] = "Type d'exercise";
$string['musictheory_intervalelementgroup'] = 'Intervalle';
$string['musictheory_intervalelementgroup_help'] = "Indique le type d'intervalle.";
$string['musictheory_intervalelementgroup_random'] = 'Intervalles possibles';
$string['nosectonic'] = '[Pas de tonique secondaire]';
$string['notelbl'] = 'Note';
$string['quality-random'] = 'Qualiticatifs possibles';
$string['questionoptions'] = 'Options de la question';
$string['questiontext'] = 'Texte de la question';
$string['questiontext_help'] = "Ce champ n'est pas requis. Si vous le laissez vide, un texte
 pour cette question sera généré automatiquement. Si vous entrez du texte dans ce champ,
 ce texte replacera celui généré automatiquement.";
$string['rootposition'] = '[Position fondamentale]';
$string['scaletype-random'] = 'Types de gamme possibles';
$string['size-random'] = 'Noms possibles';
$string['tonic'] = 'Tonique';
$string['updatemusicqtype'] = 'Mettre les options à jour';

// Music question subtype options.
$string['qtype_note-write'] = 'Entrer une note';
$string['qtype_note-write-random'] = 'Entrer une note (aléatoire)';
$string['qtype_note-identify'] = 'Identifier une note';
$string['qtype_note-identify-random'] = 'Identifier une note (aléatoire)';
$string['qtype_keyboard-input'] = 'Entrer une note au clavier';
$string['qtype_keysignature-write'] = 'Entrer une armature';
$string['qtype_keysignature-write-random'] = 'Entrer une armature (aléatoire)';
$string['qtype_keysignature-identify'] = 'Identifier une armature';
$string['qtype_keysignature-identify-random'] = 'Identifier une armature (aléatoire)';
$string['qtype_interval-write'] = 'Entrer un intervalle';
$string['qtype_interval-write-random'] = 'Entrer un intervalle (aléatoire)';
$string['qtype_interval-identify'] = 'Identifier un intervalle';
$string['qtype_interval-identify-random'] = 'Identifier un intervalle (aléatoire)';
$string['qtype_scale-write'] = 'Entrer une gamme';
$string['qtype_scale-write-random'] = 'Entrer une gamme (aléatoire)';
$string['qtype_chordquality-write'] = "Entrer une espèce d'accord";
$string['qtype_chordquality-write-random'] = "Entrer une espèce d'accord (aléatoire)";
$string['qtype_chordquality-identify'] = "Identifier une espèce d'accord";
$string['qtype_chordquality-identify-random'] = "Identifier une espèce d'accord (aléatoire)";
$string['qtype_harmonicfunction-write'] = 'Entrer une function harmonique';
$string['qtype_harmonicfunction-write-random'] = 'Entrer une function harmonique (aléatoire)';
$string['qtype_harmonicfunction-identify'] = 'Identifier une fonction harmonique';
$string['qtype_harmonicfunction-identify-random'] = 'Identifier une fonction harmonique (aléatoire)';

// Edit form - grading strategy options and help.
$string['musictheory_gradingstrategy'] = "Stragégie de correction";
$string['musictheory_gradingstrategy_help'] = "<p>La stratégie de correction indique comment
 la réponse sera corrigée.</p>
 <p><b>Tout ou rien</b>: La réponse est comparée à la solution. Si la réponse est correcte,
 une note parfaite est donnée. Si la réponse est incorrecte, une note de zéro est donnée.
 </p>";
$string['musictheory_gradingstrategy_scale-write'] = "Stragégie de correction";
$string['musictheory_gradingstrategy_scale-write_help'] = "<p>La stratégie de correction indique comment
 la réponse sera corrigée.</p>
 <p><b>Tout ou rien</b>: La réponse est comparée à la solution. Si la réponse est correcte,
 une note parfaite est accordée. Si la réponse est incorrecte, une note de zéro est donnée.
 </p>
 <p><b>Crédit partiel pour chaque note de gamme correcte</b>:
 Cette stratégie de correction divise la note de question par le nombre de notes de gamme à
 entrer, et accorde une note partielle pour chaque note de gamme correcte.</p>";
$string['qtype_musictheory_strategy_all_or_nothing'] = "Tout ou rien";
$string['qtype_musictheory_strategy_chordqualitywrite_allornothing'] = "Tout ou rien";
$string['qtype_musictheory_strategy_harmonicfunctionwrite_allornothing'] = "Tout ou rien";
$string['qtype_musictheory_strategy_harmonicfunctionid_allornothing'] = "Tout ou rien";
$string['qtype_musictheory_strategy_note_allornothing'] = "Tout ou rien";
$string['qtype_musictheory_strategy_scale_creditbynote'] = "Crédit partiel pour chaque note de gamme correcte";

// Note names.
$string['noteC'] = 'Do';
$string['noteD'] = 'Ré';
$string['noteE'] = 'Mi';
$string['noteF'] = 'Fa';
$string['noteG'] = 'Sol';
$string['noteA'] = 'La';
$string['noteB'] = 'Si';

// Clef options.
$string['treble'] = 'Clef de sol';
$string['bass'] = 'Clef de fa';
$string['alto'] = "Clef d'ut (alto)";
$string['tenor'] = "Clef d'ut (ténor)";
$string['grandstaff'] = 'Système de portée (Clefs de sol et fa)';

// Key options.
$string['CnM'] = 'Do majeur';
$string['GnM'] = 'Sol majeur';
$string['DnM'] = 'Ré majeur';
$string['AnM'] = 'La majeur';
$string['EnM'] = 'Mi majeur';
$string['BnM'] = 'Si majeur';
$string['FsharpM'] = 'Fa&#9839; majeur';
$string['CsharpM'] = 'Do&#9839; majeur';
$string['FnM'] = 'Fa majeur';
$string['BbM'] = 'Si&#9837; majeur';
$string['EbM'] = 'Mi&#9837; majeur';
$string['AbM'] = 'La&#9837; majeur';
$string['DbM'] = 'Ré&#9837; majeur';
$string['GbM'] = 'Sol&#9837; majeur';
$string['CbM'] = 'Do&#9837; majeur';
$string['Anm'] = 'La mineur';
$string['Enm'] = 'Mi mineur';
$string['Bnm'] = 'Si mineur';
$string['Fsharpm'] = 'Fa&#9839; mineur';
$string['Csharpm'] = 'Do&#9839; mineur';
$string['Gsharpm'] = 'Sol&#9839; mineur';
$string['Dsharpm'] = 'Ré&#9839; mineur';
$string['Asharpm'] = 'La&#9839; mineur';
$string['Dnm'] = 'Ré mineur';
$string['Gnm'] = 'Sol mineur';
$string['Cnm'] = 'Do mineur';
$string['Fnm'] = 'Fa mineur';
$string['Bbm'] = 'Si&#9837; mineur';
$string['Ebm'] = 'Mi&#9837; mineur';
$string['Abm'] = 'La&#9837; mineur';

// Interval direction options.
$string['dirasc'] = 'Au-dessus de la note de départ';
$string['dirdesc'] = 'Au-dessous de la note de départ';

// Interval qualities.
$string['qualityM'] = 'Majeur';
$string['qualitym'] = 'Mineur';
$string['qualityP'] = 'Parfait';
$string['qualityA'] = 'Augmenté(e)';
$string['qualityD'] = 'Diminué(e)';
$string['major'] = 'Majeur';
$string['minor'] = 'Mineur';
$string['perfect'] = 'Parfait';
$string['augmented'] = 'Augmenté(e)';
$string['diminished'] = 'Diminué(e)';

// Interval sizes.
$string['size2'] = 'Seconde';
$string['size3'] = 'Tierce';
$string['size4'] = 'Quarte';
$string['size5'] = 'Quinte';
$string['size6'] = 'Sixte';
$string['size7'] = 'Septième';
$string['size8'] = 'Octave';
$string['size9'] = 'Neuvième';
$string['size10'] = 'Dixième';
$string['size11'] = 'Onzième';
$string['size12'] = 'Douzième';
$string['size13'] = 'Treizième';

// Intervals
$string['D2'] = 'Seconde diminuée';
$string['m2'] = 'Seconde mineure';
$string['M2'] = 'Seconde majeure';
$string['A2'] = 'Seconde augmentée';

$string['D3'] = 'Tierce diminuée';
$string['m3'] = 'Tierce mineure';
$string['M3'] = 'Tierce majeure';
$string['A3'] = 'Tierce augmentée';

$string['D4'] = 'Quarte diminuée';
$string['P4'] = 'Quarte parfaite';
$string['A4'] = 'Quarte augmentée';

$string['D5'] = 'Quinte diminuée';
$string['P5'] = 'Quinte parfaite';
$string['A5'] = 'Quinte augmentée';

$string['D6'] = 'Sixte diminuée';
$string['m6'] = 'Sixte mineure';
$string['M6'] = 'Sixte majeure';
$string['A6'] = 'Sixte augmentée';

$string['D7'] = 'Septième diminuée';
$string['m7'] = 'Septième mineure';
$string['M7'] = 'Septième majeure';
$string['A7'] = 'Septième augmentée';

$string['D8'] = 'Octave diminuée';
$string['P8'] = 'Octave parfaite';
$string['A8'] = 'Octave augmentée';

$string['D9'] = 'Neuvième diminuée';
$string['m9'] = 'Neuvième mineure';
$string['M9'] = 'Neuvième majeure';
$string['A9'] = 'Neuvième augmentée';

$string['D10'] = 'Dixième diminuée';
$string['m10'] = 'Dixième mineure';
$string['M10'] = 'Dixième majeure';
$string['A10'] = 'Dixième augmentée';

$string['D11'] = 'Onzième diminuée';
$string['P11'] = 'Onzième parfaite';
$string['A11'] = 'Onzième augmentée';

$string['D12'] = 'Douzième diminuée';
$string['P12'] = 'Douzième parfaite';
$string['A12'] = 'Douzième augmentée';

$string['D13'] = 'Treizième diminuée';
$string['m13'] = 'Treizième mineure';
$string['M13'] = 'Treizième majeure';
$string['A13'] = 'Treizième augmentée';

// Scale types.
$string['scaletype'] = 'Type de gamme';
$string['scaletype_major'] = 'majeur';
$string['scaletype_natural'] = 'mineur,  naturelle';
$string['scaletype_harmonic'] = 'mineur, harmonique';
$string['scaletype_melodic'] = 'mineur, mélodique';

// Harmonic function types.
$string['hftype_diatonictriad'] = 'Triade diatonique';
$string['hftype_dom7th'] = 'Septième de dominante';
$string['hftype_nondom7th'] = 'Septième (excepté V)';
$string['hftype_leadingtone7thhalfdim'] = 'Septième de sensible';
$string['hftype_leadingtone7thfullydim'] = 'Septième diminuée';
$string['hftype_secdomtriad'] = 'Dominante secondaire)';
$string['hftype_secdom7th'] = 'Dominante secondaire (accord de septième)';
$string['hftype_secnondomtriad'] = 'Function secondaire, sauf V (triade)';
$string['hftype_secnondom7th'] = 'Function secondaire, sauf V (accord de septième)';
$string['hftype_seclttriad'] = 'Accord de sensible secondaire (triade)';
$string['hftype_seclthalfdim'] = 'Septième de sensible secondaire)';
$string['hftype_secltfullydim'] = 'Septième diminuée secondaire';
$string['hftype_neapolitan'] = 'Accord napolitain';
$string['hftype_aug6th'] = 'Sixte augmentée';

// Edit form validation.
$string['validation_noteoutsidestaff'] = "Le registre de cette note se situe en
 dehors de la portée avec la clef indiquée.";
$string['validation_noteoutsidekeyboard'] = "Cette note est hors des limites du clavier.";
$string['validation_qualitymismatch'] = "Cette combinaison de nom d'intervalle et de qualificatif est non valide.";
$string['validation_harmonicfunctionnotsupported'] = "Cette fonction harmonique n'est pas supportée ou est invalide.";
$string['validation_harmonicfunctiontypenotselected'] = 'Le type de fonction correspondant à la fonction harmonique spécifée doit être sélectionné.';
$string['validation_invalidchordquality'] = "Cette espèce d'accord ne peut pas être construit sur cette fondamentale.";
$string['validation_invalidinterval_above'] = "Cet intervalle ne peut être écrit au-dessus de la note de départ.";
$string['validation_invalidinterval_below'] = "Cet intervalle ne peut être écrit au-dessous de la note de départ.";
$string['validation_intervaloutsidestaff'] = "Le registre de la note de départ produit un
 intervalle qui en dehors de la portée avec la clef indiquée.";
$string['validation_interval_novalidcombo'] = "Les options d'intervalles possibles sélectionnées
 ne produisent pas au moins un type d'interval valide.";
$string['validation_scale_invalidtonic'] = "Tonique non valide pour le type de gamme sélectionné.";
$string['validation_scaleoutsidestaff'] = "Le registre de la note de départ produit une gamme
 qui en dehors de la portée avec la clef indiquée";

// Question rendering.
$string['correctansweris'] = 'La réponse correcte est:';
$string['correctansweris_morethanone'] = "L'une des réponses correctes possibles est:";
$string['javascriptrequired'] = "Ce texte est normalement remplacé par un interface
 graphique, qui requiert que Javascript sois activé dans votre navigateur.";
$string['selectanoption'] = "[Pas de tonique secondaire]";
$string['selectanoption'] = "Sélectionnez";
$string['selectakey'] = "Sélectionnez une tonalité";
$string['selectasize'] = "Sélectionnez un nom";
$string['selectaquality'] = "Sélectionnez un qualificatif";
$string['trebleclef'] = 'Clef de sol';
$string['bassclef'] = 'Clef de fa';
$string['altoclef'] = "Clef d'ut (alto)";
$string['tenorclef'] = "Clef d'ut (ténor)";

// Question text and help button.
$string['questiontext_note_write'] = 'Entrez la note suivante';
$string['questiontext_note_identify'] = 'Identifiez la note suivante';
$string['questiontext_keyboard_input'] = 'Entrez la note suivante au clavier';
$string['questiontext_keysignature_write'] = "Entrez l'armature suivante";
$string['questiontext_keysignature_identify_major'] = "Déterminez la tonalité majeure
 représentée par l'armature suivante";
$string['questiontext_keysignature_identify_minor'] = "Déterminez la tonalité mineure
 représentée par l'armature suivante";
$string['questiontext_interval_write_above'] = "Entrez l'intervalle suivant <b>au-dessus</b> de la note de départ";
$string['questiontext_interval_write_below'] = "Entrez l'intervalle suivant <b>au-dessous</b> de la note de départ";
$string['questiontext_interval_identify'] = "Identifiez l'intervalle suivant";
$string['questiontext_scale_write'] = 'Entrez la gamme suivante en direction ascendante';
$string['questiontext_scale_write_melodic'] = 'Entrez la gamme suivante en direction
 ascendante et descendante';
$string['questiontext_chordquality_write'] = "Entrez l'accord suivant";
$string['questiontext_chordquality_identify'] = "Identifiez la note fondamentale et l'espèce de l'accord suivant";
$string['questiontext_harmonicfunction_write'] = 'Entrez la fonction harmonique suivante';
$string['questiontext_harmonicfunction_identify'] = 'Identifiez la fonction harmonique suivante';

$string['acc_n'] = '&#9838;';
$string['acc_sharp'] = '&#9839;';
$string['acc_x'] = 'x';
$string['acc_b'] = '&#9837;';
$string['acc_bb'] = 'bb';

$string['chordquality_write_questionastext'] = "Entrée de réponse d'espèce d'accord";
$string['chordquality_write_questionastext_help'] = "<p>Entrez les notes de l'accord, séparées par des
 virgules, sans espaces. Utilisez la syntaxe suivante:</p>
 <p>[Nom de note en majuscule (do = 'C', ré = 'D', mi = 'E', fa = 'F', sol = 'G', la = 'A', si = 'B')][Altération
 (bécarre = 'n', dièse = '#', bémol = 'b', double-dièse = 'x', double-bémol = 'bb')]4, ... </p>
 <p>Exemple aléatoire: <b>réponse=>Cn4,En4,G#4</b></p>";
$string['chordquality_write_questionasui'] = "Entrée de réponse réponse d'espèce d'accord";
$string['chordquality_write_questionasui_help'] = "<p>Entrez les notes de l'accord en cliquant sur la
 portée, après avoir sélectionné l'altération voulue avec la barre d'outils de droite. Pour
 effacer une note, cliquez sur celle-ci à nouveau.</p>";
$string['harmonicfunction_write_questionastext'] = "Entrée de réponse de fonction harmonique";
$string['harmonicfunction_write_questionastext_help'] = "<p>Entrez les notes de la fonction harmonique, séparées par des
 virgules, sans espaces. Utilisez la syntaxe suivante:</p>
 <p>[Nom de note en majuscule (do = 'C', ré = 'D', mi = 'E', fa = 'F', sol = 'G', la = 'A', si = 'B')][Altération
 (bécarre = 'n', dièse = '#', bémol = 'b', double-dièse = 'x', double-bémol = 'bb')]4, ... </p>
 <p>Exemple aléatoire: <b>réponse=>Cn4,En4,G#4</b></p>";
$string['harmonicfunction_write_questionasui'] = "Entrée de réponse de fonction harmonique";
$string['harmonicfunction_write_questionasui_help'] = "<p>Entrez les notes de la fonction harmonique en cliquant sur la
 portée, après avoir sélectionné l'altération voulue avec la barre d'outils de droite. Pour
 effacer une note, cliquez sur celle-ci à nouveau.</p>";
$string['note_write_questionastext'] = 'Entrée de réponse de note';
$string['note_write_questionastext_help'] = "<p>Entrez la note de réponse, sans espaces,
 en utilisant la syntaxe suivante:</p>
 <p>[Nom de note en majuscule (do = 'C', ré = 'D', mi = 'E', fa = 'F', sol = 'G', la = 'A', si = 'B')]
 [Altération (bécarre = 'n', dièse = '#', bémol = 'b', double-dièse = 'x', double-bémol = 'bb')]
 [Registre (un chiffre entre 1 et 6, suivant la numérotation
 américaine, e.g. La 440Hz = 4)]</p><p>Exemples:
 </p><ul><li><b>Gn5</b></li><li><b>A#4</b></li><li><b>Ebb3</b></li></ul>";
$string['note_write_questionasui'] = 'Entrée de réponse de note';
$string['note_write_questionasui_help'] = "<p>Entrez la note de réponse en cliquant sur la
 portée, après avoir sélectionné l'altération voulue avec la barre d'outils de droite. Pour
 effacer la note, cliquez sur celle-ci à nouveau.</p>";
$string['keyboard_input_questionasui'] = 'Entrée de réponse au clavier';
$string['keyboard_input_questionasui_help'] = '<p>Entrez la note en cliquant sur le clavier. Pour
 effacer la note, cliquez sur celle-ci à nouveau.</p>';
$string['keysignature_write_questionastext'] = "Entrée de réponse d'armature";
$string['keysignature_write_questionastext_help'] = "<p>Entrez une liste (entre 1 et 7)
 d'altérations séparées par des virgules, sans espaces, en utilisant la syntaxe suivante:</p>
 <p>[Nom de note en majuscule (do = 'C', ré = 'D', mi = 'E', fa = 'F', sol = 'G', la = 'A', si = 'B')]
 [Altération (dièse = '#', bémol = 'b')] [Registre (un chiffre entre 2 et 5, suivant la numérotation
 américaine, e.g. La 440Hz = 4)], ... </p><p>Exemple: <b>A#4,F#4,G#4</b></p>";
$string['keysignature_write_questionasui'] = "Entrée de réponse d'armature";
$string['keysignature_write_questionasui_help'] = "<p>Entrez les altérations en cliquant sur la
  portée, après avoir sélectionné l'altération voulue avec la barre d'outils de droite. Pour
  effacer une altération, cliquez sur celle-ci à nouveau.</p>";
$string['interval_write_questionastext'] = "Entrée de réponse d'intervalle";
$string['interval_write_questionastext_help'] = "<p>Entrez la note de réponse, sans espaces,
 en utilisant la syntaxe suivante:</p>
 <p>[Nom de note en majuscule (do = 'C', ré = 'D', mi = 'E', fa = 'F', sol = 'G', la = 'A', si = 'B')]
 [Altération (bécarre = 'n', dièse = '#', bémol = 'b', double-dièse = 'x', double-bémol = 'bb')]
 [Registre (un chiffre entre 1 et 6, suivant la numérotation
 américaine, e.g. La 440Hz = 4)]</p><p>Exemples:
 </p><ul><li><b>Gn5</b></li><li><b>A#4</b></li><li><b>Ebb3</b></li></ul>";
$string['interval_write_questionasui'] = "Entrée de réponse d'intervalle";
$string['interval_write_questionasui_help'] = "<p>Entrez la note de réponse en cliquant sur la
 portée, après avoir sélectionné l'altération voulue avec la barre d'outils de droite. Pour
 effacer la note, cliquez sur celle-ci à nouveau.</p>";
$string['scale_write_questionastext'] = "Entrée de réponse de gamme";
$string['scale_write_questionastext_help'] = "<p>Entrez les notes de la gamme, séparées par des
 virgules, sans espaces, et en incluant la tonique déjà affichée. Utilisez la syntaxe
 suivante:</p>
 <p>[Nom de note en majuscule (do = 'C', ré = 'D', mi = 'E', fa = 'F', sol = 'G', la = 'A', si = 'B')]
 [Altération (bécarre = 'n', dièse = '#', bémol = 'b', double-dièse = 'x', double-bémol = 'bb')]
 [Registre (un chiffre entre 2 et 6, suivant la numérotation
 américaine, e.g. La 440Hz = 4)], ... </p>
 <p>Exemple aléatoire: <b>Tonique = An4,  réponse=>An4,Bb4,C#5,D#5,E#5,F#5,G#5,An5</b></p>";
$string['scale_write_questionasui'] = "Entrée de réponse de gamme";
$string['scale_write_questionasui_help'] = "<p>Entrez les notes de la gamme en cliquant sur la
 portée, après avoir sélectionné l'altération voulue avec la barre d'outils de droite. Pour
 effacer une note, cliquez sur celle-ci à nouveau.</p>
 <p>Prenez note que les altérations demeurent en effet jusqu'à la fin de la portée.</p>";
$string['emptykeysignature'] = 'Armature vide';

// Question answer validation.
$string['validationerror_chordquality_identify'] = "Réponse incomplète. Il faut sélectionner la note fondamentale et son altération, ainsi que l'espèce d'accord.";
$string['validationerror_notewrite_twonotesingrandstaff'] = "Deux notes ont été entrées. Il ne faut entrer qu'une seule note.";
$string['validationerror_note_identify'] = "Réponse incomplète. Il faut sélectionner le
 nom de la note, l'altération et le registre.";
$string['validationerror_note_identify_ltr_acc'] = "Réponse incomplète. Il faut sélectionner le
 nom de la note et l'altération.";
$string['validationerror_note_identify_ltr_reg'] = "Réponse incomplète. Il faut sélectionner le
 nom de la note et le registre.";
$string['validationerror_empty'] = 'Veuillez entrer une réponse.';
$string['validationerror_incompletechordquality'] = 'Réponse incomplète. Nombre de notes dans cet accord';
$string['validationerror_harmonicfunction_identify'] = 'Réponse incomplète. Tous les menus déroulants doivent être sélectionnés.';
$string['validationerror_incompleteharmonicfunction'] = 'Réponse incomplète. Nombre de notes dans cette fonction harmonique';
$string['validationerror_interval_identify'] = "Réponse incomplète. Il faut sélectionner un
 nom d'intervalle et un qualiticatif d'interval.";
$string['validationerror_invalidsyntax'] = 'Syntaxe de réponse non valide.';
$string['validationerror_scale_incomplete'] = 'Réponse incomplète. Il faut entrer une total de
 8 notes, incluant la tonique fournie.';
$string['validationerror_scale_incomplete_melodic'] = 'Réponse incomplète. Il faut entrer une total de
 15 notes, incluant la tonique fournie.';
$string['validationerror_whitespace'] = 'Syntaxe de réponse non valide: veuillez enlever tous les
    espaces dans votre réponse.';