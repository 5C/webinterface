<fieldset id="login_set" class="pulse">
	<div>
		<form action="admin.php?<?php echo session_name().'='.session_id() ?>&module=editor" method="post">
		<input type="text" name="user" placeholder="Insert Username" required/><br />
		<input type="password" name="password" placeholder="Insert Password" required/><br />
		<input type="submit" name="login" value="Logon" />
		</form>
	</div>
 </fieldset>