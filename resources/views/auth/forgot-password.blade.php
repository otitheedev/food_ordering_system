<x-guest-layout>
    <div class="mb-3 text-muted">
        {{ __('Forgot your password? No problem. Enter your email and we will email you a reset link.') }}
    </div>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
            @error('email')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>
        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">Email Password Reset Link</button>
        </div>
    </form>
</x-guest-layout>
