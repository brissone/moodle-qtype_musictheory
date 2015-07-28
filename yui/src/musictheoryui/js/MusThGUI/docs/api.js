YUI.add("yuidoc-meta", function(Y) {
   Y.YUIDoc = { meta: {
    "classes": [
        "Control.Controller",
        "Control.InputDialog",
        "GUIState.FiguredBass",
        "GUIState.FiguredBassRend",
        "GUIState.FiguredBassRow",
        "GUIState.KeySign",
        "GUIState.KeySignAcc",
        "GUIState.Note",
        "GUIState.NoteCol",
        "GUIState.Staff",
        "GUIState.StaffSystem",
        "GUIState.State",
        "GUIState.TextInput",
        "GUIState.Toolbar",
        "GUIState.ToolbarBtn",
        "GUIState.TwoVoiceNoteCol",
        "MusThGUI",
        "Render.CoordManager",
        "Render.GlyphProvider",
        "Render.KeySignRend",
        "Render.NoteColRend",
        "Render.NoteRend",
        "Render.Renderer",
        "Render.StaffRend",
        "Render.StaffSystemRend",
        "Render.ToolbarBtnRend",
        "Render.ToolbarRend"
    ],
    "modules": [
        "MusThGUI"
    ],
    "allModules": [
        {
            "displayName": "MusThGUI",
            "name": "MusThGUI",
            "description": "The Music Theory GUI module allows for display and entry of notes in various\ncontexts that are suitable for music theory exercises.\n\nThe user interface is created by instantiating a {{#crossLink \"MusThGUI\"}}\n{{/crossLink}} object.\n\nHere is an example describing how to use this module:\n\n1) Add an HTMLtag for a small canvas in the web page source, with a unique 'id'\nattribute.\n\n\t<canvas id=\"myUniqueID\" width=\"1\" height=\"1\"/>\n\n2) Define an XML string that will describe the interface's initial state. Here\nis an example that would be well-suited for a scale question:\n\n\tvar initXML = '<MusThGUI canvasEditable=\"true\" accidentalCarryOver=\"true\">' +\n\t'<StaffSystem maxLedgerLines=\"3\">' +\n\t'<Staff clef=\"treble\">' +\n\t'<KeySign totalAccColumns=\"7\" >' +\n\t'<Accidental type=\"#\" letter=\"F\" register=\"5\" editable=\"false\" />' +\n\t'<Accidental type=\"#\" letter=\"C\" register=\"5\" editable=\"false\" />' +\n\t'<Accidental type=\"#\" letter=\"G\" register=\"5\" editable=\"false\" />' +\n\t'</KeySign>' +\n\t'<NoteColumns>' +\n\t'<NoteColumn maxNotes=\"1\" />' +\n\t'<NoteColumn maxNotes=\"1\" />' +\n\t'<NoteColumn maxNotes=\"1\" />' +\n\t'<NoteColumn maxNotes=\"1\" />' +\n\t'<NoteColumn maxNotes=\"1\" />' +\n\t'<NoteColumn maxNotes=\"1\" />' +\n\t'<NoteColumn maxNotes=\"1\" />' +\n\t'<NoteColumn maxNotes=\"1\" />' +\n\t'</NoteColumns>' +\n\t'</Staff>' +\n\t'</StaffSystem>' +\n\t'<Toolbars>' +\n\t'<AccidentalToolbar>' +\n\t'<Button symbol=\"n\" />' +\n\t'<Button symbol=\"#\" />' +\n\t'<Button symbol=\"b\" />' +\n\t'<Button symbol=\"##\" />' +\n\t'<Button symbol=\"bb\" />' +\n\t'</AccidentalToolbar>' +\n\t'</Toolbars>' +\n\t'</MusThGUI>';\n\nFor more details on the XML schema that the interface will accept and return,\nsee the 'valid_input_xml.xsd' file in the module's XML directory.\n\n3) Define a callback function that the interface will use to message back its\ncurrent state. This function will be called whenever the user changes the\ninterface's state (i.e. by adding or deleting notes on the staff).\n\n\tvar callBack = function(stateXML) {\n\t//stateXML will contain the most up-to-date canvas state.\n\t};\n\n4) Create a {{#crossLink \"MusThGUI\"}}{{/crossLink}} object using the canvas id\nfrom step 1, the XML string from step 2 and the callback function from step 3:\n\n\tvar musicCanvas = new MusThGUI('myUniqueID', initXML, callBack, true);\n\nArgument 4 specifies whether the interface should be editable after\ninitialization. Use a false value to display a static interface.\n\nOnce instantiated, the MusThGUI object will display an interactive music canvas\non the web page. Whenever the user makes any changes, the callback function will\nbe called and the most up-to-date canvas state will be returned, as an XML\nstring."
        }
    ]
} };
});