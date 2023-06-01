<style>
@import url("//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800");
body {
    font-family: 'Open Sans', sans-serif;
    font-weight: 300;
}
.ir-email-container {
    max-width: 600px;margin:0 auto;
}
.ir-email-top {
    background: #00a5db; padding: 15px;color: #fff;font-weight: bold;font-size:26px;padding-left: 20px;
}
.ir-email-top img {
    width: 150px;
}
.ir-email-subject {
    background: #717D81;padding:20px;color: #fff;font-size:21px;font-weight:bold;
}
.ir-email-message {
  background: #fff;
  padding: 20px;
  padding-top: 9px;
  border-left: 1px solid #F7F7F7;
  border-right: 1px solid #F7F7F7;
}
.ir-email-message p {
    margin-bottom: 10px;
}
.ir-email-footer {
    color: #6d6d6d;
    padding: 25px;
    background: #f7f7f7;
    border-bottom-right-radius: 6px;
    border-bottom-left-radius: 6px;
}
.ir-email-footer a {
    text-decoration: none;
    color: #6d6d6d;
    font-weight: 700;
}
</style>
<div class='ir-email-container'>
                    
    <div class='ir-email-top'>
        <img src="{{ url('/images/logo1.png') }}" />
    </div>

    <div class='ir-email-subject'>Hello {{ $user->firstname }}</div>
                        
    <div class='ir-email-message'>

        <p>
            Click the link below to go ahead and reset your password:<br />
            {{ url('/password/reset/'.$token) }}
        </p>

        <br>
        Thanks,<br>
        <a href="{{ url('/') }}">{{ url('/') }}</a>
    </div>

    <div class='ir-email-footer'>
        <p> This message was sent to {{ $user->email }}. If you don't want to receive these emails from AdsAndAffiliates in the future, you can edit your profile or <a href="{{ url('/email/unsubscribe') }}">unsubscribe</a>.</p>
    </div>
</div>




