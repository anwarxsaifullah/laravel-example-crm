<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Employee') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <form method="post" action="{{ route('employees.update', $employee->id) }}" class="mt-6 space-y-6" enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                
                        <div>
                            <x-input-label for="first_name" :value="__('First Name')" />
                            <x-text-input id="first_name" name="first_name" type="text" class="mt-1 block w-full" required autofocus autocomplete="name" :value="old('first_name', $employee->first_name)" />
                            <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
                        </div>

                        <div>
                            <x-input-label for="last_name" :value="__('Last Name')" />
                            <x-text-input id="last_name" name="last_name" type="text" class="mt-1 block w-full" required autofocus autocomplete="name" :value="old('last_name', $employee->last_name)" />
                            <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
                        </div>
                
                        <div>
                            <x-input-label for="company" :value="__('Company')" />
                            <x-text-input id="company" name="company" type="text" class="mt-1 block w-full" required list="companies" :value="old('company', $employee->company)" />
                            {{-- <input list="companies"> --}}
                            <datalist id="companies">
                                @foreach ($companies as $company)
                                    <option value="{{ $company->name }}">
                                @endforeach
                            </datalist>
                            <x-input-error class="mt-2" :messages="$errors->get('company')" />
                        </div>

                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" required autocomplete="email" :value="old('email', $employee->email)" />
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
                        </div>
                        
                        <div>
                            <x-input-label for="phone" :value="__('Phone')" />
                            <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" required autocomplete="phone" :value="old('phone', $employee->phone)" />
                            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Save') }}</x-primary-button>
                
                            @if (session('status') === 'profile-updated')
                                <p
                                    x-data="{ show: true }"
                                    x-show="show"
                                    x-transition
                                    x-init="setTimeout(() => show = false, 2000)"
                                    class="text-sm text-gray-600"
                                >{{ __('Saved.') }}</p>
                            @endif
                        </div>
                    </form>
                </div>    
                
            </div>
        </div>
    </div>
</x-app-layout>
