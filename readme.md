#URLs SHORTENER WEBAPP
As required by Neueda Frontend Assignment.  
Developed by menonmachado@gmail.com.  
Jan 22nd 2019 in Sao Paulo - Brazil.

###Technical Details
- PHP 7.1.24
- Laravel Framework 5.4.36
- Javascript / HTML / CSS

###General Purpose
This app is capable of:
- Linking a custom alphanumeric string to a any LongURL submitted to it and store such relation.
- Redirecting 'thisAppDomain/cutomString' to respective LongURLs.

###Development
- Single page application with raw Javascript code that requests Laravel's /app/Http/Controllers/ShortenedURL.php to manage Shortened URLs.
- Methods from ShortenedURL Controller are duly documented with PHPDocBlocks
- Laravel's /route/web.php uses regular expression intelligence to manage any URL query.
- Custom URL names are stored in /storage/app/shortenedURLs.json 

