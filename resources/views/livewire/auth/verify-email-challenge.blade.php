<x-layouts.auth>
    <div class="flex flex-col gap-6">
        <div
            class="relative w-full h-auto"
            x-cloak
            x-data="{ code: '' }"
        >
            <x-auth-header
                :title="__('Verify Your Email')"
                :description="__('Enter the 6-digit verification code sent to your email address.')"
            />

            <form method="POST" action="{{ route('email.verify.code') }}">
                @csrf

                <div class="space-y-5 text-center">
                    <div class="flex items-center justify-center my-5">
                        <x-input-otp
                            name="code"
                            digits="6"
                            autocomplete="one-time-code"
                            x-model="code"
                        />
                    </div>

                    @error('code')
                        <flux:text color="red">
                            {{ $message }}
                        </flux:text>
                    @enderror

                    <flux:button
                        variant="primary"
                        type="submit"
                        class="w-full"
                    >
                        {{ __('Verify Email') }}
                    </flux:button>
                </div>
            </form>

            <div class="mt-6 text-sm text-center opacity-70">
                {{ __('Didn’t receive the code?') }}
                <a
                    href="{{ route('email.verify.resend') }}"
                    class="font-medium underline opacity-90"
                >
                    {{ __('Resend code') }}
                </a>
            </div>
        </div>
    </div>
</x-layouts.auth>
