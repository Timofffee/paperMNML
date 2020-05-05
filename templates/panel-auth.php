<div class="col">
    <div id="panel-auth-login">
        <h5>LogIn</h5>
        <form class="row" onsubmit="pa_login(this);return false;" id="panel-auth-login-form">
            <p class="col is-horizontal-align text-error" id="panel-auth-login-error"></p>
            <!-- tooltip="4-16 symbols. Only literals, numbers and underspace" -->
            <input class="col-12" type="text" name="login" id="panel-auth-login-input-login" placeholder="Login" required>
            <input class="col-12" type="password" name="pass" id="panel-auth-login-input-password" placeholder="Password" required>
            <div class="col is-horizontal-align"><small><a href="/where-is-my-pass/" class="text-grey">Forgot password?</a></small></div>
            <button class="col-12 text-uppercase" type="submit" id="panel-auth-login-input-submit">Sign in</button>
            <div class="col is-horizontal-align">
                <a onclick="$('#panel-auth-login').addClass('is-hidden');$('#panel-auth-reg').removeClass('is-hidden')" href="#" class="text-uppercase">Registration</a>
            </div>
        </form>
    </div>
    <div class="is-hidden" id="panel-auth-reg">
        <h5>Registration</h5>
        <form class="row" onsubmit="pa_reg(this);return false;">
        <p class="col is-horizontal-align text-error" id="panel-auth-reg-error"></p>
            <input class="col-12" type="text" name="login" id="panel-auth-reg-input-login" placeholder="Login" required>
            <input class="col-12" type="text" name="email" id="panel-auth-reg-input-email" placeholder="E-mail" required>
            <input class="col-12" type="password" name="pass" id="panel-auth-reg-input-password" placeholder="Password" required>
            <div class="col is-horizontal-align"><small>By creating an account, I agree to <a>the rules of MNML</a> and agree to <a>the processing of personal data</a>.</small></div>
            <button class="col-12 text-uppercase" type="submit" id="panel-auth-reg-input-submit">Create account</button>
            <div class="col is-horizontal-align">
                <a onclick="$('#panel-auth-reg').addClass('is-hidden');$('#panel-auth-login').removeClass('is-hidden')" href="#" class="text-uppercase">Registration</a>
            </div>
        </form>
    </div>
</div>

<script>
    function pa_login(login_form) {
        if ($('#panel-auth-login-error').hasClass("text-success")) {
            $('#panel-auth-login-error').removeClass("text-success");
            $('#panel-auth-login-error').addClass("text-error");
        }
        
                
        $('#panel-auth-login-error').text("hm..");
        event.preventDefault();
        axios.post('/api/user/login_account.php', {
            login: login_form.login.value,
            password: login_form.pass.value
        })
        .then(function (response) {
            console.log(response);
            if (response.data.status == 1) {
                $('#panel-auth-login-error').text("Error. Bad login. Hacks?");
            } else if(response.data.status == 2) {
                $('#panel-auth-login-error').text("Error. Bad password. Hacks?");
            } else if(response.data.status == 3) {
                $('#panel-auth-login-error').text("Incorrect login or password");
            } else if(response.data.status == 0) {
                let data = response.data.data;
                document.cookie = "sid="+data.sid+"; max-age="+(60*60*24*30)+";path=/";
                document.cookie = "uid="+data.uid+"; max-age="+(60*60*24*30)+";path=/";
                location.reload(true);
            } 
        })
        .catch(function (error) {
            console.log(error);
            $('#panel-auth-login-error').text("Server error. Try later.");
        });
    }

    function pa_reg(reg_form) {
        $('#panel-auth-reg-error').text("hm..");
        event.preventDefault();
        axios.post('/api/user/create_account.php', {
            login: reg_form.login.value,
            email: reg_form.email.value,
            password: reg_form.pass.value
        })
        .then(function (response) {
            console.log(response);
            if (response.data.status == 1) {
                $('#panel-auth-reg-error').text("Error. Bad login. Hacks?");
            } else if(response.data.status == 2) {
                $('#panel-auth-reg-error').text("Error. Bad e-mail. Hacks?");
            } else if(response.data.status == 3) {
                $('#panel-auth-reg-error').text("Error. Bad password. Hacks?");
            } else if(response.data.status == 4) {
                $('#panel-auth-reg-error').text("Login already exists.");
            } else if(response.data.status == 5) {
                $('#panel-auth-reg-error').text("E-mail already exists.");
            } else if(response.data.status == 6) {
                $('#panel-auth-reg-error').text("Internal error. Try later.. ");
            } else if(response.data.status == 0) {
                $('#panel-auth-reg').addClass('is-hidden');
                $('#panel-auth-login-error').removeClass("text-error");
                $('#panel-auth-login-error').addClass("text-success");
                $('#panel-auth-login-error').text("You have successfully registered!");
                $('#panel-auth-login').removeClass('is-hidden');
                
            } 
        })
        .catch(function (error) {
            console.log(error);
            $('#panel-auth-reg-error').text("Server error. Try later.");
        });
    }
</script>