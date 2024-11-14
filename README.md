<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Project
This project uses latest Laravel as pure API only. <br/>
This is laravel based test coding for livline.

## Laravel Sponsors

LIVLINE

## HowTo

- Assuming it is pulled or saved locally...
- `composer install` && `php artisan migrate --seed`
- `php artisan key:generate` if key is not generated on `.env`

## Structure
```
 Controller (Injects Interface)
     |
 Interface ---------> Service (implements Interface)
                         |
                         |
                       Model (Hard injected to Service)
```
- Our `TaskController` injects on `__construct(TaskInterface $interface)`
- Then we implement `TaskInterface` to `TaskService`
- From `TaskService` we then inject `Task` model.
- (Optional) we could add `TaskRepository` to add abstraction to our model.
- To make this work, we create a provider `TaskServiceProvider` where we 
  bind together `TaskInterface` and `TaskService`.
- Then we add the `TaskServiceProvider` to either or both `app.php` and `providers.php`


## VHost for Local Dev
- If you are running Ubuntu you could modify a local domain e.g. (`livline.local`)

- Make a copy of existing sample of `.conf` file for vhost <br />
  `sudo cp /etc/apache2/sites-available/000-default.conf /etc/apache2/sites-available/livline.conf`

- Then modify `sudo vi /etc/apache2/sites-available/livline.conf`

- Add the following:
```
<VirtualHost *:80>

        ServerAdmin webmaster@localhost
        DocumentRoot /var/www/liv_line_folder/public
        ServerName livline.local
        ServerAlias livline.local

        <Directory /var/www/liv_line_folder/public/>
                Options Indexes FollowSymLinks
                AllowOverride All
                Require all granted
        </Directory>

        ErrorLog ${APACHE_LOG_DIR}/error.log
        CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
```
- Then save by pressing ESC then type `:wq` and enter.
- Then enable it by `sudo a2ensite livline.conf`

- Then add livline.local to hosts file <br />
  `sudo vi /etc/hosts`

```
    //Just add this line next below the last IPV4

    127.0.0.1   livline.local
    ::1 liveline.local
```

## Optional
- If you just setup you environment make sure you <br/>
  `sudo a2enmod rewrite`
- Then, `sudo service apache2 restart` restart apache.

- You could also add a default username with password on <br/>
  `UserSeeder.php`

Done!
