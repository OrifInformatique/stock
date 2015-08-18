<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 
  'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='en' lang='en'>

<head>    
    <title>Login</title>
    
    <?php echo link_tag('public/css/style_login.css'); ?> 
    
</head>
<body>
	
	
	<div class="login">
		<div class="login-screen">
			<div class="app-title">
				<h1>Inventaire Orif</h1>
			</div>

			<div class="login-form">
				<div class="control-group">	

	
					<?php echo $msg;?>
				    <div id="login_form">
				        <form action="<?php echo base_url();?>login/process" method="post" name="process">
				            <h2>Login utilisateur</h2>
				            <br>            
				            <label for="username">Nom d'utilisateur</label>
				            <input type="text" name="username" id="username" size="25" /><br>
				        <br>
				            <label for="password">Mot de passe</label>
				            <input type="password" name="password" id="password" size="25" /><br>                            
				        <br>
        
				            <input type="submit" value="Login" class="btn btn-primary btn-large btn-block" />  
				            
				        </form>
				    </div>
				    

    			</div>
		</div>
	</div>
</body>
    
    
</body>
</html>