YUI.add("yuidoc-meta", function(Y) {
   Y.YUIDoc = { meta: {
    "classes": [
        "Control.Controller",
        "GUIState.Key",
        "GUIState.Keyboard",
        "GUIState.State",
        "KeyboardInput",
        "Render.CoordManager",
        "Render.KeyRend",
        "Render.Renderer"
    ],
    "modules": [
        "KeyboardInput"
    ],
    "allModules": [
        {
            "displayName": "KeyboardInput",
            "name": "KeyboardInput",
            "description": "The Keyboard Input module allows for display and selection of notes on a piano\nkeyboard.\n\nThe user interface is created by instantiating a {{#crossLink \"KeyboardInput\"}}\n{{/crossLink}} object.\n\nHere is an example describing how to use this module:\n\n1) Add an HTMLtag for a small canvas in the web page source, with a unique 'id'\nattribute.\n\n\t<canvas id=\"myUniqueID\" width=\"1\" height=\"1\"/>\n\n2) Define an XML string that will describe the interface's initial state. Here\nis an example:\n\n\tvar initXML = '<keyboardinput maxkeys=\"2\" canvasEditable=\"true\">' +\n\t'<givenkeys>' +\n\t'<givenkey pitchclass=\"4\" register=\"5\" />' +\n\t'</givenkeys>' +\n\t'<selectedkeys>' +\n\t'<selectedkey pitchclass=\"5\" register=\"2\" />' +\n\t'</selectedkeys>' +\n\t'</keyboardinput>';\n\nThe maxkeys attribute indicates the maximum number of keys that can be selected\nat any given time. The given keys are keys that will be highlighted on the\nkeyboard but will not be selectable/unselectable. The selected keys are keys\nthat will be initially selected - these keys can be unselected.\n\nFor more details on the XML schema that the interface will accept and return,\nsee the 'valid_input_xml.xsd' file in the module's XML directory.\n\n3) Define a callback function that the interface will use to message back its\ncurrent state. This function will be called whenever the user changes the\ninterface's state (i.e. by selecting or unselecting keys on the keyboard).\n\n\tvar callBack = function(stateXML) {\n\t//stateXML will contain the most up-to-date canvas state.\n\t};\n\n4) Create a {{#crossLink \"KeyboardInput\"}}{{/crossLink}} object using the\ncanvas id from step 1, the XML string from step 2 and the callback function\nfrom step 3:\n\n\tvar musicCanvas = new KeyboardInput('myUniqueID', initXML, callBack, true);\n\nArgument 4 specifies whether the interface should be editable after\ninitialization. Use a false value to display a static interface.\n\nOnce instantiated, the KeyboardInput object will display an interactive\nkeyboard on the web page. Whenever the user selects or unselects a key, the\ncallback function is called and the most up-to-date canvas state is\nreturned, as an XML string."
        }
    ]
} };
});