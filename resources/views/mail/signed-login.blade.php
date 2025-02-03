<x-mail::message>
# Two-Factor Authentication

Click the button below to login to your account.<br>
<x-mail::button :url="$url">Login</x-mail::button>

If the button above does not work, you can also use this link:<br>
<x-mail::panel>
<{!! $url !!}>
</x-mail::panel>

This URL will expire in 3 minutes and can only be used once.

If you did not request a verification code, no further action is required.<br>
</x-mail::message>
