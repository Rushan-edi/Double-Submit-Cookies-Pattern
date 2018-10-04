<?php
session_start();
if (!$_SESSION["loged"]) {
    header('Location: csrf_token.php');
    exit();
  } else {
    echo '<div class="container">  <div class="alert alert-warning">
      <strong> Welcome Rushan! </strong> <a href="signout.php">Sign out</a> 
      </div>
    </div>';
}

function generateToken(){

return setcookie("csrf", base64_encode(openssl_random_pseudo_bytes(32)), time() + 3600, "/");
}
function validateToken($token)
{
    return urldecode($token) ==$_COOKIE['csrf'];
}
generateToken();
if (isset($_POST['csrf_token']) && isset($_POST['current_psw']) && isset($_POST['new_psw'])) {
    if (validateToken($_POST['csrf_token'])) {
      echo '<div class="container">  <div class="alert alert-success">
				Password has Changed!
			</div>
		</div>';
		
    } else {
      echo '<div class="container">  <div class="alert alert-danger alert-dismissible fade in">
				Invalid CSRF Token
			</div>
		</div>';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
</head>
<script>
function getCookieValue(a) {
    var b = document.cookie.match('(^|;)\\s*' + a + '\\s*=\\s*([^;]+)');
    return b ? b.pop() : '';
}
  
</script>
<body>
    <div class="container">
            <div class="panel panel-info" >
                <div class="panel-heading">
                    <div class="panel-title">Change Password</div>
                </div>
                    <div style="padding-top:30px" class="panel-body" >

                        <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>
                        <form id="changeForm" class="form-horizontal" role="form" method="post" action="csrf_token.php">
                            <div style="margin-bottom: 25px" class="form-group">
                                  <label class="col-md-4 control-label" for="textinput">Current Password</label> 
                                  <div class="col-md-4">
                                        <input type="password" class="form-control" name="current_psw"  placeholder="**********" required>
                                 </div>
                             </div>
                            <div style="margin-bottom: 25px" class="form-group">
                                <label class="col-md-4 control-label" for="textinput">New Password</label> 
                              <div class="col-md-4">
                                  <input type="password" class="form-control" name="new_psw" placeholder="**********" required>
                                </div>
                            </div>
                            <div style="margin-bottom: 25px" class="form-group">
                                <label class="col-md-4 control-label" for="textinput">Confirm Password</label> 
                                <div class="col-md-4">
                                  <input type="password" class="form-control" name="confrim_psw" placeholder="**********" required>
                                 <input  type="hidden" class="form-control" id="csrf_token" name="csrf_token">
                                </div>
                            </div>
                             <div style="margin-top:10px" class="form-group">
                              <div class="col-md-4">
                              </div>
                                <div class="col-sm-4 controls">
                                    <button id="btn-bd" class="btn btn-lg btn-primary btn-block btn-signin" value="update" type="submit">Save</button>
                                </div>
                            </div>
                            <span id="message"></span>
                        </form>
                    </div>
            </div>
    </div>
</body>
<script>
document.getElementById('csrf_token').value=getCookieValue('csrf');
</script>
</html>
