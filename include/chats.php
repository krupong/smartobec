<?php 
//Insert chats
if(isset($_POST['chat_submit'])) {
	if($_SESSION["login_user_id"]!=""){ 
		$sqlchatdup = "SELECT * FROM chats WHERE chats.personid='".$_SESSION["login_user_id"]."' and chats.message='".$_POST["message"]."'";
		//printf($sqlchatdup);
		$result_chatdup = mysqli_query($connect, $sqlchatdup);
		$result_chatdup_num = mysqli_num_rows($result_chatdup);
		if($result_chatdup_num == 0) {
			$sqlchat = " INSERT INTO chats(personid,message) VALUES('".$_SESSION["login_user_id"]."','".$_POST["message"]."') "; 
			mysqli_query($connect, $sqlchat);
		}
	}
}elseif(isset($_GET["token"])) {
	if($_SESSION["login_user_id"]!=""){ 
		$sqlchat = "SELECT * FROM chats WHERE chats.chatid=".$_GET["token"];
		//printf($sqlchatdup);
		$own_personid = "";
		if($resultchat = mysqli_query($connect, $sqlchat)) {
			$rowchat = $resultchat->fetch_assoc();
			$own_personid = $rowchat["personid"];
		}

		if($own_personid == $_SESSION["login_user_id"]) {
			$sqlchat = " UPDATE chats SET chatstatus=0 WHERE chatid=".$_GET["token"]; 
			mysqli_query($connect, $sqlchat);
		}
	}	
}
?>