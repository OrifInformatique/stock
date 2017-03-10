<br>
<div class="divitem" style="margin-left: auto; margin-right: auto; width: 500px; padding: 30px">

<html>
<head>
<title>Upload Form</title>
</head>
<body>

<?php echo $error;?>

<?php echo form_open_multipart('upload/do_upload');?>

<input type="file" name="userfile" size="100" />

<br /><br />

<input type="submit" value="upload" />

</form>

</body>
</html>