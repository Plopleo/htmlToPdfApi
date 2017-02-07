<VirtualHost *:80>
        ServerName %plateforme%htmltopdf.%domaine%
        DocumentRoot "/var/www/htmlToPdfApi/web"
        <Directory />
                Options FollowSymLinks
                AllowOverride All
        </Directory>
        ErrorLog "/var/log/apache2/%plateforme%htmltopdf.%domaine%-error_log"
        CustomLog "/var/log/apache2/%plateforme%htmltopdf.%domaine%-access_log" common
</VirtualHost>
