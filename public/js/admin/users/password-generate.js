  // Generate a random password
  document.addEventListener('DOMContentLoaded', function() {
 

   document.getElementById('generatePassword').addEventListener('click', function() {
     const randomPassword = generateRandomPassword();
    const passwordConfirmField = document.getElementById('password-confirm');
    const passwordCurrentField = document.getElementById('password-current');

    const passwordConfirm = document.getElementById('password');
    const generatedPasswordField = document.getElementById('generatedPassword');
    const copyPasswordButton = document.getElementById('copyPassword');
    const copyStatus = document.getElementById('copyStatus');
    if (passwordConfirmField) {
        // Element exists, it's safe to access its properties
        passwordConfirmField.value = randomPassword;
    }
    if (passwordCurrentField) {
        // Element exists, it's safe to access its properties
        passwordCurrentField.value = randomPassword;
    }
    passwordConfirm.value=randomPassword;
    // passwordConfirmField.value = randomPassword;
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

}
 });
