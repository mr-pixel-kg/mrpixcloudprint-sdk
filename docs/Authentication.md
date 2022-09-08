# Authentication
Some actions require you to be authenticated. There are three options you can use for authentication.

1. **Provide login credentials to CloudPrintClient constructor**

    The first option is to provide your login credentials when constructing the CloudPrintClient.
    To do this you have to hand over the username in the first argument and the password in the 
    second argument.
    
    ```php
    // Load credentials from config
    $username = 'your-username@example.com';
    $password = 'yourSecretPassword';
    
    $client = new CloudPrintClient($username, $password);
    ```
   
   However, using hardcoded login credentials is not secure. This method is perfect if you want to load credentials 
   dynamically from some configuration. For static credentials, the recommended way is to use environment variables.

2. **Environment Variables**

    If you don't provide your login credentials in the first option, the cloudprint SDK looks for environment variables.
    You can provide your credentials in the following environment variables:
    
    ```
    MRPIX_CLOUDPRINT_USERNAME=your-username@example.com
    MRPIX_CLOUDPRINT_PASSWORD=yourSecretPassword
    ```

3. **Explicit login**

    The third option is to login with your credentials only if authentication is required.
    To do this, you have to call the login method before sending requests.
    Here is a example on how to do that:
    
    ```php
    $client->login('your-username@example.com', 'yourSecretPassword');
    ```

Note: If the login credentials are not correct, the server will return a 401 or 403 response for all requests.

## Test login credentials
To test if login credentials are correct, you can use the following example:

```php
if($client->checkLoginCredentials('your-username@example.com', 'yourSecretPassword'))
{
    echo 'Login successful!';
} else {
    echo 'Login failed!';
}
```