
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{URL::asset('css/primitive.css')}}">
<link rel="stylesheet" href="{{URL::asset('css/custom.css')}}">

<script type="text/javascript" src="{{URL::asset('js/shortener.js')}}"></script>

<div class="small-container text-center">
        <div class="flex-row">
            <div class="flex-large">
                <h1>SHORTEN LONG URL</h1>
            </div>
        </div>
        <div class="flex-row">
            <div class="flex-large text-center">
                <textarea type="text" id="long_url" name="long_url" class="border-r" rows="6" placeholder="Paste a long URL here." style="font-size: 18pt;"></textarea>
                <input type="text" id="short_name" name="short_name" class="border-r" placeholder="Type a short alphanumeric name here." style="margin: auto; width: 70%;">
                <span style="color: red; display: none;" id="msg">This name has already been taken! Type another one.</span>
                <div id="loader" class="lds-ellipsis" style="display: none;"><div></div><div></div><div></div><div></div></div>
                <div id="new_url" data-newURL="" style="display: none; text-decoration: underline;">
                    <h6 style="margin-bottom: -15px;">THIS IS YOUR SHORTENED URL:</h6>
                    <h3 style="border-style: dashed; padding: 1em;"><a href="#" target="_blank" id="new_url_domain"></a><span id="new_url_query" style="color:green;"></span></h3>
                    <button id="btn_save" class="full-button round-button">Save!</button>
                </div>
                <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">


            </div>
        </div>
    </div>
</div>

<script>

    // VARIABLES DECLARATION
    var url = '{{url()->current()}}'+'/';
    var token = document.querySelector('meta[name="csrf-token"]').content;
    var timeout = null;
    new_url_domain.innerText = url;


    // SHORT_NAME CHECKING
    short_name.addEventListener('input', nameCheckStart);
    function nameCheckStart(){

        short_name.value = short_name.value.match(/\w+/g);
        clearTimeout(timeout);
        show_loader();
        show_new_url();
        timeout = setTimeout(nameCheck, 400);
    };
    function nameCheck(){
        var urlAction = url + "namecheck";
        xhr = new XMLHttpRequest();
        xhr.open('POST', urlAction);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.setRequestHeader('X-CSRF-TOKEN', token);
        xhr.onload = function() {
            if (xhr.status === 200) {
                if(xhr.responseText == 0){
                    msg.style.display = 'block';
                    short_name.style.backgroundColor= 'pink';
                    new_url.style.display = 'none';
                }else{
                    msg.style.display = 'none';
                    short_name.style.backgroundColor= 'white';
                    new_url_query.style.color = 'green';
                    new_url.style.display = 'block';
                    btn_save.className = "full-button round-button";
                    btn_save.innerText = "Save!"
                    if (short_name.value == "") {hide_new_url()};
                }
            }
            else if (xhr.status !== 200) {
                console.log(xhr.responseText);
            }
        };
        xhr.send(encodeURI('short_name=' + short_name.value));
        hide_loader();
    };


    // SAVING
    btn_save.addEventListener('click', saving);
    function saving (){
        if (btn_save.innerText == "It is saved!") {
            return false;
        }else{
            nameCheck();
            save();
        }
    }
    function save() {
        var urlAction = url + "insert";

        btn_save.className = "full-button round-button accent-button";
        btn_save.innerText = "It is saved!";

        validateLongUrl();


        xhr = new XMLHttpRequest();
        xhr.open('POST', urlAction);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.setRequestHeader('X-CSRF-TOKEN', token);
        xhr.onload = function() {
            if (xhr.status === 200) {
                if(xhr.responseText == 1) {
                    btn_save.className = "full-button round-button accent-button";
                    btn_save.innerText = "It is saved!";
                }
            }
            else if (xhr.status !== 200) {
                console.log(xhr.responseText);
            }
        };
        xhr.send(encodeURI('long_url=' + long_url.value + '&' + 'short_name=' + short_name.value));
    };

    function validateLongUrl() {
        btn_save.className = "full-button round-button";
        btn_save.innerText = "Save!";
        if (long_url.value == '') {
            long_url.style.backgroundColor = 'pink';

            return false;
        }else{
            long_url.style.backgroundColor = 'white';
        }
    };

    long_url.addEventListener('input', clearSaveButton);
    function clearSaveButton(){
        if (short_name.value != '') {
            nameCheckStart();
        }
        validateLongUrl();
    }

    // VIEW MODIFIERS
    function show_new_url() {
        new_url.style.display = 'block';
        new_url_domain.innerText = window.location.href;
        new_url_query.innerText = short_name.value;
        new_url_domain.href = new_url_domain.innerText + new_url_query.innerText;
    };

    function hide_new_url() {
        new_url.style.display = 'none';
    };

    function show_loader() {
        loader.style.display = 'inline-block';
    };

    function hide_loader(){
        loader.style.display = 'none';
    };

</script>
