<VirtualHost *:80>
        ServerName %plateforme%htmltopdf.%domaine%
        DocumentRoot "/var/www/htmlToPdfApi/web"
        <Directory />
                Options FollowSymLinks
                AllowOverride All
        </Directory>
</VirtualHost>
