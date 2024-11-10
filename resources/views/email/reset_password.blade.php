<x-mail::message>
# Reset Password

<x-mail::button :url="$reset_password_link">
    Button Text
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>