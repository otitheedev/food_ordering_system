<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 m-0">{{ __('Profile') }}</h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="row g-4">
                <div class="col-12 col-lg-6">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
