
                <div class="card">
                    <h1>New post</h1>
                    <p class="text-error">I'm sorry, but most of the editor functions are currently unavailable.</p>
                    <form class="row" onsubmit="newPost(this);return false;">
                        <input class="col-9" type="text" name="title" id="title" placeholder="Title">
                        <input class="col-6"type="text" name="tags" id="tags" placeholder="Tag, tag, tag...">
                        <textarea class="col-12" name="text" id="text" rows="10" placeholder="My story begginer with..."></textarea>
                        <button class="col-" type="submit">Create post</button>
                    </form>
                </div>

<script>
    function getCookie(name) {

        var matches = document.cookie.match(new RegExp(
        "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
        ))
        return matches ? decodeURIComponent(matches[1]) : undefined
    }

    function newPost(send_form) {
        event.preventDefault();
        axios.post('/api/post/new_post.php', {
            user_id: getCookie('uid'),
            title: send_form.title.value,
            tags: send_form.tags.value,
            text: send_form.text.value
        })
        .then(function (response) {
            console.log(response);
            // if (response.data.status == 1) {
            //     $('#panel-auth-reg-error').text("Error. Bad login. Hacks?");
            // } else if(response.data.status == 2) {
            //     $('#panel-auth-reg-error').text("Error. Bad e-mail. Hacks?");
            // } else if(response.data.status == 3) {
            //     $('#panel-auth-reg-error').text("Error. Bad password. Hacks?");
            // } else if(response.data.status == 4) {
            //     $('#panel-auth-reg-error').text("Login already exists.");
            // } else if(response.data.status == 5) {
            //     $('#panel-auth-reg-error').text("E-mail already exists.");
            // } else if(response.data.status == 6) {
            //     $('#panel-auth-reg-error').text("Internal error. Try later.. ");
            // } else 
            if(response.data.status == 0) {
                window.location.href = "/";
            } 
        })
        .catch(function (error) {
            console.log(error);
            // $('#panel-auth-reg-error').text("Server error. Try later.");
        });
    }
</script>

