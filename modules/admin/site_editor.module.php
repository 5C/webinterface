<?php
defined('MODE') or die('<strong>Access denied!</strong>');
?>
<div id="selection_btn">
	<button id="load" name="load">Load</button><button id="save" name="save">Save</button>
</div>
<div id="editor">
</div>
<div id="dialog-modal" title="File Browser">
</div>

<script src="http://rawgithub.com/ajaxorg/ace-builds/master/src-noconflict/ace.js" type="text/javascript" charset="utf-8"></script>
<script>
    var editor = ace.edit("editor");
    editor.setTheme("ace/theme/monokai");
    editor.getSession().setMode("ace/mode/javascript");
    editor.setValue('// Press load to edit a file from the Server\n// After you finished your world changing programm\n// click save.');
</script>