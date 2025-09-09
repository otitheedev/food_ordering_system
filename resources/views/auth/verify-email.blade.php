<x-guest-layout>
    <div class="mb-3 text-muted">
        {{ __('Thanks for signing up! Before getting started, please verify your email address by clicking the link we just emailed to you. If you didn\'t receive the email, you can request another below.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="alert alert-success mb-3">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mt-3">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn btn-primary">{{ __('Resend Verification Email') }}</button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-link">{{ __('Log Out') }}</button>
        </form>
    </div>
</x-guest-layout>
