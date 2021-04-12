<?php
/* Copyright (c) 2013 Eric Brisson

  Permission is hereby granted, free of charge, to any person obtaining a copy
  of this software and associated documentation files (the "Software"), to deal
  in the Software without restriction, including without limitation the rights
  to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
  copies of the Software, and to permit persons to whom the Software is
  furnished to do so, subject to the following conditions:

  The above copyright notice and this permission notice shall be included in
  all copies or substantial portions of the Software.

  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
  IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
  FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
  AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
  LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
  OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
  THE SOFTWARE. */

/**
 * This file defines the music scale classes.
 *
 * @package MusicTheory
 */

/**
 * This class represents a musical scale.
 */
abstract class Scale {

	/** @var Note The tonic of the scale. */
	protected $tonic;

	/** @var Interval[] The intervals between the tonic and notes of the scale. */
	protected $intSequence;

	/**
	 * Constructor.
	 *
	 * @param Note $tonic The tonic of the scale.
	 * @return void
	 */
	public function __construct($tonic) {

		$this->tonic = $tonic;
		$this->intSequence = array();
	}

	/**
	 * Retrieves a note from the scale.
	 *
	 * @param integer $degree The scale degree to retrieve (tonic = 1).
	 * @param integer $alteration Optional. If provided, alters the note by the
	 * specified number of half steps. Values between -2 and 2 are accepted - a
	 * value of 0 returns an unaltered scale degree. The default is 0.
	 * @return Note The requested scale degree.
	 */
	public function getScaleDegree($degree, $alteration = 0) {

		$note = $this->tonic->getNoteFromInterval($this->intSequence[$degree - 1]);
		$note->alter($alteration);
		return $note;
	}

	/**
	 * Return all notes from the scale.
	 *
	 * @return Note[] The scale notes.
	 */
	public function getScaleDegrees() {

		$degrees = array();
		array_push($degrees, $this->getScaleDegree(1));
		array_push($degrees, $this->getScaleDegree(2));
		array_push($degrees, $this->getScaleDegree(3));
		array_push($degrees, $this->getScaleDegree(4));
		array_push($degrees, $this->getScaleDegree(5));
		array_push($degrees, $this->getScaleDegree(6));
		array_push($degrees, $this->getScaleDegree(7));
		array_push($degrees, $this->getScaleDegree(8));
		return $degrees;
	}

	/**
	 * Returns a string describing the name of the scale (e.g. 'C major',
	 * 'G natural minor').
	 *
	 * @return string The scale name.
	 */
	public function getName() {

		return '';
	}

	/**
	 * Returns a comma-separated string representation of the scale notes.
	 * (e.g. 'Dn4,En4,F#4,Gn4,An4,Bn4,C#5,Dn5').
	 *
	 * @return string The comma-reparated scale notes.
	 */
	public function __toString() {
		return implode(',', $this->getScaleDegrees());
	}

}

/**
 * This class represents a major scale.
 */
class MajorScale extends Scale {

	/**
	 * Constructor.
	 *
	 * @param Note $tonic The tonic of the scale.
	 * @return void
	 */
	public function __construct($tonic) {

		parent::__construct($tonic);

		$int_1 = new Interval('+', 'P', 1);
		$int_2 = new Interval('+', 'M', 2);
		$int_3 = new Interval('+', 'M', 3);
		$int_4 = new Interval('+', 'P', 4);
		$int_5 = new Interval('+', 'P', 5);
		$int_6 = new Interval('+', 'M', 6);
		$int_7 = new Interval('+', 'M', 7);
		$int_8 = new Interval('+', 'P', 8);

		array_push($this->intSequence, $int_1);
		array_push($this->intSequence, $int_2);
		array_push($this->intSequence, $int_3);
		array_push($this->intSequence, $int_4);
		array_push($this->intSequence, $int_5);
		array_push($this->intSequence, $int_6);
		array_push($this->intSequence, $int_7);
		array_push($this->intSequence, $int_8);
	}

	/**
	 * Returns a string describing the name of the scale (e.g. 'C major',
	 * 'Ab major').
	 *
	 * @return string The scale name.
	 */
	public function getName() {

		return ((string) $this->tonic . getLetterAccidental()) . ' major';
	}

}

/**
 * This class represents a minor scale.
 */
abstract class MinorScale extends Scale {

	/**
	 * Constructor.
	 *
	 * @param Note $tonic The tonic of the scale.
	 * @return void
	 */
	public function __construct($tonic) {

		parent::__construct($tonic);
	}

}

/**
 * This class represents a natural minor scale.
 */
class NaturalMinorScale extends MinorScale {

	/**
	 * Constructor.
	 *
	 * @param Note $tonic The tonic of the scale.
	 * @return void
	 */
	public function __construct($tonic) {

		parent::__construct($tonic);

		$int_1 = new Interval('+', 'P', 1);
		$int_2 = new Interval('+', 'M', 2);
		$int_3 = new Interval('+', 'm', 3);
		$int_4 = new Interval('+', 'P', 4);
		$int_5 = new Interval('+', 'P', 5);
		$int_6 = new Interval('+', 'm', 6);
		$int_7 = new Interval('+', 'm', 7);
		$int_8 = new Interval('+', 'P', 8);

		array_push($this->intSequence, $int_1);
		array_push($this->intSequence, $int_2);
		array_push($this->intSequence, $int_3);
		array_push($this->intSequence, $int_4);
		array_push($this->intSequence, $int_5);
		array_push($this->intSequence, $int_6);
		array_push($this->intSequence, $int_7);
		array_push($this->intSequence, $int_8);
	}

	/**
	 * Returns a string describing the name of the scale (e.g. 'C natural minor',
	 * 'F natural minor').
	 *
	 * @return string The scale name.
	 */
	public function getName() {

		return ((string) tonic . getLetterAccidental()) . ' natural minor';
	}

}

/**
 * This class represents a harmonic minor scale.
 */
class HarmonicMinorScale extends MinorScale {

	/**
	 * Constructor.
	 *
	 * @param Note $tonic The tonic of the scale.
	 * @return void
	 */
	public function __construct($tonic) {

		parent::__construct($tonic);

		$int_1 = new Interval('+', 'P', 1);
		$int_2 = new Interval('+', 'M', 2);
		$int_3 = new Interval('+', 'm', 3);
		$int_4 = new Interval('+', 'P', 4);
		$int_5 = new Interval('+', 'P', 5);
		$int_6 = new Interval('+', 'm', 6);
		$int_7 = new Interval('+', 'M', 7);
		$int_8 = new Interval('+', 'P', 8);

		array_push($this->intSequence, $int_1);
		array_push($this->intSequence, $int_2);
		array_push($this->intSequence, $int_3);
		array_push($this->intSequence, $int_4);
		array_push($this->intSequence, $int_5);
		array_push($this->intSequence, $int_6);
		array_push($this->intSequence, $int_7);
		array_push($this->intSequence, $int_8);
	}

	/**
	 * Returns a string describing the name of the scale (e.g. 'C harmonic minor',
	 * 'F# harmonic minor').
	 *
	 * @return string The scale name.
	 */
	public function getName() {
		return $this->tonic->getLetterAccidental() . ' harmonic minor';
	}

}

/**
 * This class represents a melodic minor scale.
 */
class MelodicMinorScale extends MinorScale {

	/**
	 * Constructor.
	 *
	 * @param Note $tonic The tonic of the scale.
	 * @return void
	 */
	public function __construct($tonic) {
		parent::__construct($tonic);

		$int_1 = new Interval('+', 'P', 1);
		$int_2 = new Interval('+', 'M', 2);
		$int_3 = new Interval('+', 'm', 3);
		$int_4 = new Interval('+', 'P', 4);
		$int_5 = new Interval('+', 'P', 5);
		$int_6 = new Interval('+', 'm', 6);
		$int_7 = new Interval('+', 'm', 7);
		$int_8 = new Interval('+', 'P', 8);

		array_push($this->intSequence, $int_1);
		array_push($this->intSequence, $int_2);
		array_push($this->intSequence, $int_3);
		array_push($this->intSequence, $int_4);
		array_push($this->intSequence, $int_5);
		array_push($this->intSequence, $int_6);
		array_push($this->intSequence, $int_7);
		array_push($this->intSequence, $int_8);
	}

	/**
	 * Return all notes from the scale.
	 *
	 * @return Note[] The scale notes.
	 */
	public function getScaleDegrees() {

		$degrees = array();
		array_push($degrees, $this->getScaleDegree(1));
		array_push($degrees, $this->getScaleDegree(2));
		array_push($degrees, $this->getScaleDegree(3));
		array_push($degrees, $this->getScaleDegree(4));
		array_push($degrees, $this->getScaleDegree(5));
		array_push($degrees, $this->getScaleDegree(6, 1));
		array_push($degrees, $this->getScaleDegree(7, 1));
		array_push($degrees, $this->getScaleDegree(8));
		array_push($degrees, $this->getScaleDegree(7));
		array_push($degrees, $this->getScaleDegree(6));
		array_push($degrees, $this->getScaleDegree(5));
		array_push($degrees, $this->getScaleDegree(4));
		array_push($degrees, $this->getScaleDegree(3));
		array_push($degrees, $this->getScaleDegree(2));
		array_push($degrees, $this->getScaleDegree(1));

		return $degrees;
	}

	/**
	 * Returns a string describing the name of the scale (e.g. 'C melodic minor',
	 * 'Bb melodic minor').
	 *
	 * @return string The scale name.
	 */
	public function getName() {

		return ((string) tonic . getLetterAccidental()) . ' melodic minor';
	}

}

/**
 * This class represents a pentatonic major scale.
 */
class PentatonicMajorScale extends Scale {

    /**
     * Constructor.
     *
     * @param Note $tonic The tonic of the scale.
     * @return void
     */
    public function __construct($tonic) {

        parent::__construct($tonic);

        $int_1 = new Interval('+', 'P', 1);
        $int_2 = new Interval('+', 'M', 2);
        $int_3 = new Interval('+', 'M', 3);
        $int_5 = new Interval('+', 'P', 5);
        $int_6 = new Interval('+', 'M', 6);
        $int_8 = new Interval('+', 'P', 8);

        array_push($this->intSequence, $int_1);
        array_push($this->intSequence, $int_2);
        array_push($this->intSequence, $int_3);
        array_push($this->intSequence, $int_5);
        array_push($this->intSequence, $int_6);
        array_push($this->intSequence, $int_8);
    }

    /**
     * Returns a string describing the name of the scale (e.g. 'C pentatonic major',
     * 'Ab pentatonic major').
     *
     * @return string The scale name.
     */
    public function getName() {

        return ((string) $this->tonic . getLetterAccidental()) . ' pentatonic major';
    }

    /**
     * Return all notes from the scale.
     *
     * @return Note[] The scale notes.
     */
    public function getScaleDegrees() {

        $degrees = array();
        array_push($degrees, $this->getScaleDegree(1));
        array_push($degrees, $this->getScaleDegree(2));
        array_push($degrees, $this->getScaleDegree(3));
        array_push($degrees, $this->getScaleDegree(4));
        array_push($degrees, $this->getScaleDegree(5));
        array_push($degrees, $this->getScaleDegree(6));
        return $degrees;
    }
}

/**
 * This class represents a pentatonic minor scale.
 */
class PentatonicMinorScale extends Scale {

    /**
     * Constructor.
     *
     * @param Note $tonic The tonic of the scale.
     * @return void
     */
    public function __construct($tonic) {

        parent::__construct($tonic);

        $int_1 = new Interval('+', 'P', 1);
        $int_3 = new Interval('+', 'm', 3);
        $int_4 = new Interval('+', 'P', 4);
        $int_5 = new Interval('+', 'P', 5);
        $int_7 = new Interval('+', 'm', 7);
        $int_8 = new Interval('+', 'P', 8);

        array_push($this->intSequence, $int_1);
        array_push($this->intSequence, $int_3);
        array_push($this->intSequence, $int_4);
        array_push($this->intSequence, $int_5);
        array_push($this->intSequence, $int_7);
        array_push($this->intSequence, $int_8);
    }

    /**
     * Returns a string describing the name of the scale (e.g. 'C pentatonic minor',
     * 'Ab pentatonic minor').
     *
     * @return string The scale name.
     */
    public function getName() {

        return ((string) $this->tonic . getLetterAccidental()) . ' pentatonic minor';
    }

    /**
     * Return all notes from the scale.
     *
     * @return Note[] The scale notes.
     */
    public function getScaleDegrees() {

        $degrees = array();
        array_push($degrees, $this->getScaleDegree(1));
        array_push($degrees, $this->getScaleDegree(2));
        array_push($degrees, $this->getScaleDegree(3));
        array_push($degrees, $this->getScaleDegree(4));
        array_push($degrees, $this->getScaleDegree(5));
        array_push($degrees, $this->getScaleDegree(6));
        return $degrees;
    }

}

/**
 * This class represents a blues scale.
 */
class BluesScale extends Scale {

    /**
     * Constructor.
     *
     * @param Note $tonic The tonic of the scale.
     * @return void
     */
    public function __construct($tonic) {

        parent::__construct($tonic);

        $int_1 = new Interval('+', 'P', 1);
        $int_2 = new Interval('+', 'm', 3);
        $int_3 = new Interval('+', 'P', 4);
        $int_4 = new Interval('+', 'A', 4);
        $int_5 = new Interval('+', 'P', 5);
        $int_7 = new Interval('+', 'm', 7);
        $int_8 = new Interval('+', 'P', 8);

        array_push($this->intSequence, $int_1);
        array_push($this->intSequence, $int_2);
        array_push($this->intSequence, $int_3);
        array_push($this->intSequence, $int_4);
        array_push($this->intSequence, $int_5);
        array_push($this->intSequence, $int_7);
        array_push($this->intSequence, $int_8);
    }

    /**
     * Returns a string describing the name of the scale (e.g. 'C blues',
     * 'Ab blues').
     *
     * @return string The scale name.
     */
    public function getName() {

        return ((string) $this->tonic . getLetterAccidental()) . ' blues';
    }

    /**
     * Return all notes from the scale.
     *
     * @return Note[] The scale notes.
     */
    public function getScaleDegrees() {

        $degrees = array();
        array_push($degrees, $this->getScaleDegree(1));
        array_push($degrees, $this->getScaleDegree(2));
        array_push($degrees, $this->getScaleDegree(3));
        array_push($degrees, $this->getScaleDegree(4));
        array_push($degrees, $this->getScaleDegree(5));
        array_push($degrees, $this->getScaleDegree(6));
        array_push($degrees, $this->getScaleDegree(7));
        return $degrees;
    }

}

/**
 * This class represents a ionian mode scale.
 */
class IonianScale extends Scale {

    /**
     * Constructor.
     *
     * @param Note $tonic The tonic of the scale.
     * @return void
     */
    public function __construct($tonic) {

        parent::__construct($tonic);

        $int_1 = new Interval('+', 'P', 1);
        $int_2 = new Interval('+', 'M', 2);
        $int_3 = new Interval('+', 'M', 3);
        $int_4 = new Interval('+', 'P', 4);
        $int_5 = new Interval('+', 'P', 5);
        $int_6 = new Interval('+', 'M', 6);
        $int_7 = new Interval('+', 'M', 7);
		$int_8 = new Interval('+', 'P', 8);

        array_push($this->intSequence, $int_1);
        array_push($this->intSequence, $int_2);
        array_push($this->intSequence, $int_3);
        array_push($this->intSequence, $int_4);
        array_push($this->intSequence, $int_5);
        array_push($this->intSequence, $int_6);
        array_push($this->intSequence, $int_7);
		array_push($this->intSequence, $int_8);
    }

    /**
     * Returns a string describing the name of the scale (e.g. 'C Ionian mode',
     * 'Ab Ionian mode').
     *
     * @return string The scale name.
     */
    public function getName() {

        return ((string) $this->tonic . getLetterAccidental()) . ' Ionian mode';
    }

    /**
     * Return all notes from the scale.
     *
     * @return Note[] The scale notes.
     */
    public function getScaleDegrees() {

        $degrees = array();
        array_push($degrees, $this->getScaleDegree(1));
        array_push($degrees, $this->getScaleDegree(2));
        array_push($degrees, $this->getScaleDegree(3));
        array_push($degrees, $this->getScaleDegree(4));
        array_push($degrees, $this->getScaleDegree(5));
        array_push($degrees, $this->getScaleDegree(6));
        array_push($degrees, $this->getScaleDegree(7));
		array_push($degrees, $this->getScaleDegree(8));
        return $degrees;
    }

}

/**
 * This class represents a dorian mode scale.
 */
class DorianScale extends Scale {

    /**
     * Constructor.
     *
     * @param Note $tonic The tonic of the scale.
     * @return void
     */
    public function __construct($tonic) {

        parent::__construct($tonic);

        $int_1 = new Interval('+', 'P', 1);
        $int_2 = new Interval('+', 'M', 2);
        $int_3 = new Interval('+', 'm', 3);
        $int_4 = new Interval('+', 'P', 4);
        $int_5 = new Interval('+', 'P', 5);
        $int_6 = new Interval('+', 'M', 6);
        $int_7 = new Interval('+', 'm', 7);
		$int_8 = new Interval('+', 'P', 8);

        array_push($this->intSequence, $int_1);
        array_push($this->intSequence, $int_2);
        array_push($this->intSequence, $int_3);
        array_push($this->intSequence, $int_4);
        array_push($this->intSequence, $int_5);
        array_push($this->intSequence, $int_6);
        array_push($this->intSequence, $int_7);
		array_push($this->intSequence, $int_8);
    }

    /**
     * Returns a string describing the name of the scale (e.g. 'C Dorian mode',
     * 'Ab Dorian mode').
     *
     * @return string The scale name.
     */
    public function getName() {

        return ((string) $this->tonic . getLetterAccidental()) . ' Dorian mode';
    }

    /**
     * Return all notes from the scale.
     *
     * @return Note[] The scale notes.
     */
    public function getScaleDegrees() {

        $degrees = array();
        array_push($degrees, $this->getScaleDegree(1));
        array_push($degrees, $this->getScaleDegree(2));
        array_push($degrees, $this->getScaleDegree(3));
        array_push($degrees, $this->getScaleDegree(4));
        array_push($degrees, $this->getScaleDegree(5));
        array_push($degrees, $this->getScaleDegree(6));
        array_push($degrees, $this->getScaleDegree(7));
		array_push($degrees, $this->getScaleDegree(8));
        return $degrees;
    }

}

/**
 * This class represents a phryigan mode scale.
 */
class PhrygianScale extends Scale {

    /**
     * Constructor.
     *
     * @param Note $tonic The tonic of the scale.
     * @return void
     */
    public function __construct($tonic) {

        parent::__construct($tonic);

        $int_1 = new Interval('+', 'P', 1);
        $int_2 = new Interval('+', 'm', 2);
        $int_3 = new Interval('+', 'm', 3);
        $int_4 = new Interval('+', 'P', 4);
        $int_5 = new Interval('+', 'P', 5);
        $int_6 = new Interval('+', 'm', 6);
        $int_7 = new Interval('+', 'm', 7);
		$int_8 = new Interval('+', 'P', 8);

        array_push($this->intSequence, $int_1);
        array_push($this->intSequence, $int_2);
        array_push($this->intSequence, $int_3);
        array_push($this->intSequence, $int_4);
        array_push($this->intSequence, $int_5);
        array_push($this->intSequence, $int_6);
        array_push($this->intSequence, $int_7);
		array_push($this->intSequence, $int_8);
    }

    /**
     * Returns a string describing the name of the scale (e.g. 'C Phrygian mode',
     * 'Ab Phrygian mode').
     *
     * @return string The scale name.
     */
    public function getName() {

        return ((string) $this->tonic . getLetterAccidental()) . ' Phrygian mode';
    }

    /**
     * Return all notes from the scale.
     *
     * @return Note[] The scale notes.
     */
    public function getScaleDegrees() {

        $degrees = array();
        array_push($degrees, $this->getScaleDegree(1));
        array_push($degrees, $this->getScaleDegree(2));
        array_push($degrees, $this->getScaleDegree(3));
        array_push($degrees, $this->getScaleDegree(4));
        array_push($degrees, $this->getScaleDegree(5));
        array_push($degrees, $this->getScaleDegree(6));
        array_push($degrees, $this->getScaleDegree(7));
		array_push($degrees, $this->getScaleDegree(8));
        return $degrees;
    }

}

/**
 * This class represents a lydian mode scale.
 */
class LydianScale extends Scale {

    /**
     * Constructor.
     *
     * @param Note $tonic The tonic of the scale.
     * @return void
     */
    public function __construct($tonic) {

        parent::__construct($tonic);

        $int_1 = new Interval('+', 'P', 1);
        $int_2 = new Interval('+', 'M', 2);
        $int_3 = new Interval('+', 'M', 3);
        $int_4 = new Interval('+', 'A', 4);
        $int_5 = new Interval('+', 'P', 5);
        $int_6 = new Interval('+', 'M', 6);
        $int_7 = new Interval('+', 'M', 7);
		$int_8 = new Interval('+', 'P', 8);

        array_push($this->intSequence, $int_1);
        array_push($this->intSequence, $int_2);
        array_push($this->intSequence, $int_3);
        array_push($this->intSequence, $int_4);
        array_push($this->intSequence, $int_5);
        array_push($this->intSequence, $int_6);
        array_push($this->intSequence, $int_7);
		array_push($this->intSequence, $int_8);
    }

    /**
     * Returns a string describing the name of the scale (e.g. 'C Lydian mode',
     * 'Ab Lydian mode').
     *
     * @return string The scale name.
     */
    public function getName() {

        return ((string) $this->tonic . getLetterAccidental()) . ' Lydian mode';
    }

    /**
     * Return all notes from the scale.
     *
     * @return Note[] The scale notes.
     */
    public function getScaleDegrees() {

        $degrees = array();
        array_push($degrees, $this->getScaleDegree(1));
        array_push($degrees, $this->getScaleDegree(2));
        array_push($degrees, $this->getScaleDegree(3));
        array_push($degrees, $this->getScaleDegree(4));
        array_push($degrees, $this->getScaleDegree(5));
        array_push($degrees, $this->getScaleDegree(6));
        array_push($degrees, $this->getScaleDegree(7));
		array_push($degrees, $this->getScaleDegree(8));
        return $degrees;
    }

}

/**
 * This class represents a mixolydian mode scale.
 */
class MixolydianScale extends Scale {

    /**
     * Constructor.
     *
     * @param Note $tonic The tonic of the scale.
     * @return void
     */
    public function __construct($tonic) {

        parent::__construct($tonic);

        $int_1 = new Interval('+', 'P', 1);
        $int_2 = new Interval('+', 'M', 2);
        $int_3 = new Interval('+', 'M', 3);
        $int_4 = new Interval('+', 'P', 4);
        $int_5 = new Interval('+', 'P', 5);
        $int_6 = new Interval('+', 'M', 6);
        $int_7 = new Interval('+', 'm', 7);
		$int_8 = new Interval('+', 'P', 8);

        array_push($this->intSequence, $int_1);
        array_push($this->intSequence, $int_2);
        array_push($this->intSequence, $int_3);
        array_push($this->intSequence, $int_4);
        array_push($this->intSequence, $int_5);
        array_push($this->intSequence, $int_6);
        array_push($this->intSequence, $int_7);
		array_push($this->intSequence, $int_8);
    }

    /**
     * Returns a string describing the name of the scale (e.g. 'C Mixolydian mode',
     * 'Ab Mixolydian mode').
     *
     * @return string The scale name.
     */
    public function getName() {

        return ((string) $this->tonic . getLetterAccidental()) . ' Mixolydian mode';
    }

    /**
     * Return all notes from the scale.
     *
     * @return Note[] The scale notes.
     */
    public function getScaleDegrees() {

        $degrees = array();
        array_push($degrees, $this->getScaleDegree(1));
        array_push($degrees, $this->getScaleDegree(2));
        array_push($degrees, $this->getScaleDegree(3));
        array_push($degrees, $this->getScaleDegree(4));
        array_push($degrees, $this->getScaleDegree(5));
        array_push($degrees, $this->getScaleDegree(6));
        array_push($degrees, $this->getScaleDegree(7));
		array_push($degrees, $this->getScaleDegree(8));
        return $degrees;
    }

}

/**
 * This class represents a aeolian mode scale.
 */
class AeolianScale extends Scale {

    /**
     * Constructor.
     *
     * @param Note $tonic The tonic of the scale.
     * @return void
     */
    public function __construct($tonic) {

        parent::__construct($tonic);

        $int_1 = new Interval('+', 'P', 1);
        $int_2 = new Interval('+', 'M', 2);
        $int_3 = new Interval('+', 'm', 3);
        $int_4 = new Interval('+', 'P', 4);
        $int_5 = new Interval('+', 'P', 5);
        $int_6 = new Interval('+', 'm', 6);
        $int_7 = new Interval('+', 'm', 7);
		$int_8 = new Interval('+', 'P', 8);

        array_push($this->intSequence, $int_1);
        array_push($this->intSequence, $int_2);
        array_push($this->intSequence, $int_3);
        array_push($this->intSequence, $int_4);
        array_push($this->intSequence, $int_5);
        array_push($this->intSequence, $int_6);
        array_push($this->intSequence, $int_7);
		array_push($this->intSequence, $int_8);
    }

    /**
     * Returns a string describing the name of the scale (e.g. 'C Aeolian mode',
     * 'Ab Aeolian mode').
     *
     * @return string The scale name.
     */
    public function getName() {

        return ((string) $this->tonic . getLetterAccidental()) . ' Aeolian mode';
    }

    /**
     * Return all notes from the scale.
     *
     * @return Note[] The scale notes.
     */
    public function getScaleDegrees() {

        $degrees = array();
        array_push($degrees, $this->getScaleDegree(1));
        array_push($degrees, $this->getScaleDegree(2));
        array_push($degrees, $this->getScaleDegree(3));
        array_push($degrees, $this->getScaleDegree(4));
        array_push($degrees, $this->getScaleDegree(5));
        array_push($degrees, $this->getScaleDegree(6));
        array_push($degrees, $this->getScaleDegree(7));
		array_push($degrees, $this->getScaleDegree(8));
        return $degrees;
    }

}

/**
 * This class represents a Locrian mode scale.
 */
class LocrianScale extends Scale {

    /**
     * Constructor.
     *
     * @param Note $tonic The tonic of the scale.
     * @return void
     */
    public function __construct($tonic) {

        parent::__construct($tonic);

        $int_1 = new Interval('+', 'P', 1);
        $int_2 = new Interval('+', 'm', 2);
        $int_3 = new Interval('+', 'm', 3);
        $int_4 = new Interval('+', 'P', 4);
        $int_5 = new Interval('+', 'D', 5);
        $int_6 = new Interval('+', 'm', 6);
        $int_7 = new Interval('+', 'm', 7);
		$int_8 = new Interval('+', 'P', 8);

        array_push($this->intSequence, $int_1);
        array_push($this->intSequence, $int_2);
        array_push($this->intSequence, $int_3);
        array_push($this->intSequence, $int_4);
        array_push($this->intSequence, $int_5);
        array_push($this->intSequence, $int_6);
        array_push($this->intSequence, $int_7);
		array_push($this->intSequence, $int_8);
    }

    /**
     * Returns a string describing the name of the scale (e.g. 'C Locrian mode',
     * 'Ab Locrian mode').
     *
     * @return string The scale name.
     */
    public function getName() {

        return ((string) $this->tonic . getLetterAccidental()) . ' Locrian mode';
    }

    /**
     * Return all notes from the scale.
     *
     * @return Note[] The scale notes.
     */
    public function getScaleDegrees() {

        $degrees = array();
        array_push($degrees, $this->getScaleDegree(1));
        array_push($degrees, $this->getScaleDegree(2));
        array_push($degrees, $this->getScaleDegree(3));
        array_push($degrees, $this->getScaleDegree(4));
        array_push($degrees, $this->getScaleDegree(5));
        array_push($degrees, $this->getScaleDegree(6));
        array_push($degrees, $this->getScaleDegree(7));
		array_push($degrees, $this->getScaleDegree(8));
        return $degrees;
    }

}

/**
 * This class represents a chromatic scale.
 */
class ChromaticScale extends Scale {

    /**
     * Constructor.
     *
     * @param Note $tonic The tonic of the scale.
     * @return void
     */

    public function __construct($tonic) {
			define ('chromaticCn', array('Cn4', 'Cn2', 'Cn3', 'Cn4', 'Cn5', 'Cn6'));
			define ('chromaticDn', array('Dn2', 'Dn3', 'Dn4', 'Dn5', 'Dn6'));
			define ('chromaticEn', array('En2', 'En3', 'En4', 'En5', 'En6')); //TODO
        if (in_array($tonic, chromaticCn)) {
				parent::__construct($tonic);
				$int_1 = new Interval('+', 'P', 1);
	        	$int_2 = new Interval('+', 'A', 1);
	        	$int_3 = new Interval('+', 'M', 2);
		        $int_4 = new Interval('+', 'A', 2);
		        $int_5 = new Interval('+', 'M', 3);
		        $int_6 = new Interval('+', 'P', 4);
		        $int_7 = new Interval('+', 'A', 4);
				$int_8 = new Interval('+', 'P', 5);
				$int_9 = new Interval('+', 'A', 5);
				$int_10 = new Interval('+', 'M', 6);
				$int_11 = new Interval('+', 'A', 6);
				$int_12 = new Interval('+', 'M', 7);
				$int_13 = new Interval('+', 'P', 8);

		        array_push($this->intSequence, $int_1);
		        array_push($this->intSequence, $int_2);
		        array_push($this->intSequence, $int_3);
		        array_push($this->intSequence, $int_4);
		        array_push($this->intSequence, $int_5);
		        array_push($this->intSequence, $int_6);
		        array_push($this->intSequence, $int_7);
				array_push($this->intSequence, $int_8);
				array_push($this->intSequence, $int_9);
				array_push($this->intSequence, $int_10);
				array_push($this->intSequence, $int_11);
				array_push($this->intSequence, $int_12);
				array_push($this->intSequence, $int_13);
						}
			else if (in_array($tonic, chromaticDn)) {
				parent::__construct($tonic);
				$int_1 = new Interval('+', 'P', 1);
			    $int_2 = new Interval('+', 'A', 1);
			    $int_3 = new Interval('+', 'M', 2);
			    $int_4 = new Interval('+', 'm', 3);
			    $int_5 = new Interval('+', 'M', 3);
			    $int_6 = new Interval('+', 'P', 4);
			    $int_7 = new Interval('+', 'A', 4);
				$int_8 = new Interval('+', 'P', 5);
				$int_9 = new Interval('+', 'A', 5);
				$int_10 = new Interval('+', 'M', 6);
				$int_11 = new Interval('+', 'A', 6);
				$int_12 = new Interval('+', 'M', 7);
				$int_13 = new Interval('+', 'P', 8);

			    array_push($this->intSequence, $int_1);
			    array_push($this->intSequence, $int_2);
			   	array_push($this->intSequence, $int_3);
			    array_push($this->intSequence, $int_4);
			    array_push($this->intSequence, $int_5);
			    array_push($this->intSequence, $int_6);
			    array_push($this->intSequence, $int_7);
				array_push($this->intSequence, $int_8);
				array_push($this->intSequence, $int_9);
				array_push($this->intSequence, $int_10);
				array_push($this->intSequence, $int_11);
				array_push($this->intSequence, $int_12);
				array_push($this->intSequence, $int_13);
				}
			else if (in_array($tonic, chromaticEn)) {
				parent::__construct($tonic);
				$int_1 = new Interval('+', 'P', 1);
			    $int_2 = new Interval('+', 'm', 2);
			    $int_3 = new Interval('+', 'M', 2);
			    $int_4 = new Interval('+', 'm', 3);
			    $int_5 = new Interval('+', 'M', 3);
			    $int_6 = new Interval('+', 'P', 4);
			    $int_7 = new Interval('+', 'A', 4);
				$int_8 = new Interval('+', 'P', 5);
				$int_9 = new Interval('+', 'm', 6);
				$int_10 = new Interval('+', 'M', 6);
				$int_11 = new Interval('+', 'm', 7);
				$int_12 = new Interval('+', 'M', 7);
				$int_13 = new Interval('+', 'P', 8);

			    array_push($this->intSequence, $int_1);
			    array_push($this->intSequence, $int_2);
			    array_push($this->intSequence, $int_3);
			    array_push($this->intSequence, $int_4);
			    array_push($this->intSequence, $int_5);
		     	array_push($this->intSequence, $int_6);
			    array_push($this->intSequence, $int_7);
				array_push($this->intSequence, $int_8);
				array_push($this->intSequence, $int_9);
				array_push($this->intSequence, $int_10);
				array_push($this->intSequence, $int_11);
				array_push($this->intSequence, $int_12);
						array_push($this->intSequence, $int_13);
				}
			else {
				parent::__construct($tonic);
				$int_1 = new Interval('+', 'P', 1);
				$int_2 = new Interval('+', 'A', 1);
				$int_3 = new Interval('+', 'M', 2);
				$int_4 = new Interval('+', 'A', 2);
				$int_5 = new Interval('+', 'M', 3);
				$int_6 = new Interval('+', 'P', 4);
				$int_7 = new Interval('+', 'A', 4);
				$int_8 = new Interval('+', 'P', 5);
				$int_9 = new Interval('+', 'A', 5);
				$int_10 = new Interval('+', 'M', 6);
				$int_11 = new Interval('+', 'A', 6);
				$int_12 = new Interval('+', 'M', 7);
				$int_13 = new Interval('+', 'P', 8);

			    array_push($this->intSequence, $int_1);
			    array_push($this->intSequence, $int_2);
			   	array_push($this->intSequence, $int_3);
			    array_push($this->intSequence, $int_4);
			    array_push($this->intSequence, $int_5);
			    array_push($this->intSequence, $int_6);
			    array_push($this->intSequence, $int_7);
				array_push($this->intSequence, $int_8);
				array_push($this->intSequence, $int_9);
				array_push($this->intSequence, $int_10);
				array_push($this->intSequence, $int_11);
				array_push($this->intSequence, $int_12);
				array_push($this->intSequence, $int_13);
						}
    }

    /**
     * Returns a string describing the name of the scale (e.g. 'C Chromatic mode',
     * 'Ab Chromatic mode').
     *
     * @return string The scale name.
     */
    public function getName() {

        return ((string) $this->tonic . getLetterAccidental()) . ' Chromatic';
    }

    /**
     * Return all notes from the scale.
     *
     * @return Note[] The scale notes.
     */
    public function getScaleDegrees() {

        $degrees = array();
        array_push($degrees, $this->getScaleDegree(1));
        array_push($degrees, $this->getScaleDegree(2));
        array_push($degrees, $this->getScaleDegree(3));
        array_push($degrees, $this->getScaleDegree(4));
        array_push($degrees, $this->getScaleDegree(5));
        array_push($degrees, $this->getScaleDegree(6));
        array_push($degrees, $this->getScaleDegree(7));
		array_push($degrees, $this->getScaleDegree(8));
	 	array_push($degrees, $this->getScaleDegree(9));
		array_push($degrees, $this->getScaleDegree(10));
		array_push($degrees, $this->getScaleDegree(11));
		array_push($degrees, $this->getScaleDegree(12));
		array_push($degrees, $this->getScaleDegree(13));
        return $degrees;
    }

}
