Readme file for the MUSIC THEORY question type

================================================================================

DESCRIPTION
-----------

This Moodle question type deals music theory. It currently supports the
following music theory exercises:

1) Note writing: The respondent is asked to enter a given note on the staff.
2) Note identification: The response is asked to identify a give note.
3) Key signature writing: The respondent is asked to enter a given key signature.
4) Key signature identification: The respondent is asked to identify a given
major or minor key signature.
5) Interval writing: The respondent is asked to enter a given interval above or
below a given note.
6) Interval identification: The respondent is asked to identify the quality and
size of a given interval
7) Scale writing: The respondent is asked to enter a given scale.


When Javascript is enabled, answers are entered and displayed in an HTML5 graphical
user interface, using a separate Javascript component (Music Theory GUI)
packaged as a YUI module. All the exercises above are fully functional without
Javascript, except for 1) Note writing and 2) Note identification.

Each of the exercises above can also be configured so that a specific question
is randomly generated upon starting an activity. The randomization can be based
on a set of parameters configured when the question is created or edited. For
example, it is possible to configure an interval writing question so that it
asks for a perfect fifth above a randomly chosen given note. This randomization
process, configured during question creation, alleviates the need to create very
large question banks, and can be particularly useful for interval questions,
given that the number of possible intervals, especially when all possible clefs
and given notes are considered, is very large.

I made a choice to create a framework where the correctness of a given question
is automatically computed, without having to enter individual answers during
question creation. A framework for adding various grading strategies for each
exercise is also in place, and is currently used for the scale writing exercise
(currently allowing either an "all-or-nothing" grading strategy, or a "partial
grade" approach where each correct note is given partial credit).

This new plugin was developed with the hope of creating a music question type
that would support a wide range of music theory exercises, using a single
graphical user interface that is flexible enough to support such exercises. It
is hoped that it will facilitate further development and Moodle server
maintenance.

Import/Export to Moodle XML format is supported, as well as activity backup and
restore.

Special thanks to Jay Huber for his very significant contributions to the
existing standalone Moodle music question types (Music Key Signature, Music
Interval and Music Scale), and for inspiring me to develop this new question
type.

Maintainer: Eric Brisson

===========================================================================

INSTALLATION
------------

Requirements:

1) 	Moodle 2.6.x
	The plug-in might work with previous versions of Moodle 2, but has only been
tested with this version.

2) 	PHP 5: the plug-in was coded with version 5.5.3. It hasn't been tested with
earlier versions of PHP.

3)	Javascript is used for the graphical user interface, but the question type
is fully functional without it, with the exception of the note writing and note
identification exercises.

How to install:

1) Copy the contents of this folder into the following folder:
moodle/question/type/musictheory
2) Load the "Notifications" page on the Moodle home page - this will create
database tables used by the question type.

================================================================================

LICENSE
-------

This plugin is released under the GNU GPL License, v3 or later.

It also includes two separate utilities:

1) Music Theory GUI (musictheory/yui/src/musictheoryui/js/MusThGUI): An HTML5
component for displaying or interacting with music theory examples and exercises.
It was created by Eric Brisson and its source code is available under the MIT
License.

1) Music Theory PHP Library (musictheory/lib/MusicTheory): A PHP library which
may be useful for any application dealing with music theoretical concepts. It
was created by Eric Brisson and its source code is available under the MIT
License.