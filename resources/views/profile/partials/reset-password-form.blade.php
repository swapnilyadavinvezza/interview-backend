<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Reset Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>
@if ($errors->has('password'))
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->get('password') as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <form method="post" action="{{ route('admin.reset.password.update',$user->id) }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

     

        <div>
            <x-input-label for="password" :value="__('New Password')" />
            <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                                                           <button type="button" class="btn btn-secondary" id="generatePassword">Generate</button>

            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />

        </div>

        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" name="password_confirmation" type="password" id="password-confirm" class="mt-1 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                 <button class="btn btn-secondary" id="copyPassword" type="button" style="display: none;">
                <i class="fa fa-copy"></i> 
            </button>

            <div id="copyStatus" style="display: none; margin-top: 5px; color: green;">
                Copied!
            </div>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Reset') }}</x-primary-button>

            @if (session('status') === 'password-updated')
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
</section>

<script>
    
    // Generate a random password
document.addEventListener('DOMContentLoaded', function() {
       document.getElementById('generatePassword').addEventListener('click', function() {
         const randomPassword = generateRandomPassword();
        const passwordConfirmField = document.getElementById('password-confirm');
        const passwordConfirm = document.getElementById('password');
        const generatedPasswordField = document.getElementById('generatedPassword');
        const copyPasswordButton = document.getElementById('copyPassword');
        const copyStatus = document.getElementById('copyStatus');
        passwordConfirm.value=randomPassword;
        passwordConfirmField.value = randomPassword;
        generatedPasswordField.value = randomPassword;
        //document.getElementById('resetLink').style.display = 'inline';
     // Add an event listener to the "Copy Password" button
        copyPasswordButton.style.display = passwordConfirmField.value ? 'inline' : 'none';
        // Add an event listener to the "Copy Password" button
        copyPasswordButton.addEventListener('click', function() {
            copyToClipboard(passwordConfirmField);
               copyStatus.style.display = 'inline';
            setTimeout(function() {
                copyStatus.style.display = 'none';
            }, 2000); // Hide the message after 2 seconds (adjust as needed)
        });
        
        });
  // Add an event listener to the "Copy Password" button
       

    // Function to generate a random password
  function generateRandomPassword() {
    const length = 10;
    const uppercaseLetters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    const lowercaseLetters = 'abcdefghijklmnopqrstuvwxyz';
    const numbers = '0123456789';
    const specialCharacters = '!@#$%^&*';

    // Ensure at least one character from each group
    const upperChar = uppercaseLetters.charAt(Math.floor(Math.random() * uppercaseLetters.length));
    const lowerChar = lowercaseLetters.charAt(Math.floor(Math.random() * lowercaseLetters.length));
    const numberChar = numbers.charAt(Math.floor(Math.random() * numbers.length));

    // Create a pool of characters to choose from for the remaining characters
    const charset = uppercaseLetters + lowercaseLetters + numbers + specialCharacters;

    // Randomly select the remaining characters
    let password = upperChar + lowerChar + numberChar;
    for (let i = 0; i < length - 3; i++) {
        const randomIndex = Math.floor(Math.random() * charset.length);
        password += charset.charAt(randomIndex);
    }

    // Shuffle the characters to make the password more random
    password = password.split('').sort(function () {
        return 0.5 - Math.random();
    }).join('');

    return password;
}

     // Function to copy text to the clipboard
    function copyToClipboard(element) {
        // Temporarily change the input type to "text" to allow selection
        element.type = 'text';
        element.select();
        document.execCommand('copy');
        // Change the input type back to "password" for security
        element.type = 'password';

        // Optionally, you can provide some visual feedback to the user (e.g., show a tooltip)
        // or an alert message to indicate that the text has been copied.
    }
     });

</script>
