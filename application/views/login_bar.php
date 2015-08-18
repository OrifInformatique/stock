<style>

html, body {

	
    font-family: "Helvetica";
    font-size: 0.9em;


}

	.clstitle {
		font-family: "Helvetica";
		font-size: 1.8em;
		text-align: center;
		vertical-align: middle;
		height: 50px;
		line-height: 50px;
		/* background-color: #9999ff; */
		background-color: #AACCff; 
		color: #FFF;
		text-shadow: 1px 1px #444;
		padding:5px;
		margin:0px;
		

	}
	
	.clscredentials	{
		position: absolute;
		right: 0px;
		font-size: 0.9em;
		margin: 4px;
		padding: 4px;
		font-family: "Helvetica";

	{
	
</style>


<div>
		<div class="clscredentials">
			 <?php 
			 
			if(isset($userdata['validated']))
			{
				echo 'Logué en tant que : <b>'. $userdata['initials']; 
				echo '</b> <a href='.site_url('login/logout').'>Log out</a>';
				if($userdata['access_level'] >= 10)
					echo ' | <a href='.site_url('admin').'>Administration</a>';
			}
			else
			{
				echo 'Logué en tant que : <b>Invité';
				echo '</b> <a href='.site_url('login').'>Log in</a>';
			
			}
			
			?>
		</div>
			

		<div class="clstitle">
			Inventaire Informatique ORIF
			
		</div>
		
	</div>