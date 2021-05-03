<?php
/*require_once 'vendor/autoload.php';


$MessageBird = new MessageBird\Client('fba2472d65b9a0286f863898e7ea3eb4');
$Message     = new MessageBird\Objects\MmsMessage();
$Message->originator = "Abdulaziz";
$Message->recipients = array('966552662010');
$Message->body       = 'Hello Abo Mualla';


print_r(json_encode($MessageBird->messages->create($Message)));*/
?>
<html>
<head>
    <title>Test Message</title>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-lg-6">
            <form >
                <button id="88" class="btn btn-success 88">Send Message</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>

<script>
    document.addEventListener('click' , (e) =>{
        let target = e.target
        e.preventDefault()
        if (target && target.classList.contains('88')){
            let request = new XMLHttpRequest();

            request.open('POST', 'https://www.msegat.com/gw/sendsms.php');

            request.setRequestHeader('Content-Type', 'application/json');

            request.onreadystatechange = function () {
                if (this.readyState === 4) {
                    console.log('Status:', this.status);
                    console.log('Headers:', this.getAllResponseHeaders());
                    console.log('Body:', this.responseText);
                }
            };

            let body = '{\
                          "userName": "AbdulazizMualla",\
                          "numbers": "966552662010",\
                          "userSender": "AbdulazizMualla",\
                          "apiKey": "fba2472d65b9a0286f863898e7ea3eb4",\
                          "msg": "hello"\
                        }';

            request.send(body);
        /*    let data = {
                userName: "AbdulazizMualla",
                numbers: "966552662010",
                userSender:"AbdulazizMualla",
                apiKey:"fba2472d65b9a0286f863898e7ea3eb4",
                msg:"Hello Abo mualla"
            }
            let jsonS = JSON.stringify(data)

            console.log(target)
            $.ajax({
                uri: 'https://www.msegat.com/gw/sendsms.php',
                type: 'post',
                dataType: 'application/json',
                data: jsonS,
                success: function (data){
                    console.log(data)
                }

                error: function (xhr ,status , error){
                    console.log(error)
                }
            })*/
        }
    })
</script>