<h3>
    Stack
</h3>
<table>
    <thead>
        <tr>
            <th>
                 Name
            </th>
            <th>
                Info
            </th>
            <th>
                 Value
            </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                 PHP
            </td>
            <td>
                PHP version
            </td>
            <td>
                8.0.*
            </td>
        </tr>
        <tr>
            <td>
                 MySQL database
            </td>
            <td>
                Database info
            </td>
            <td>
                MariaDB, version:10.4.11
            </td>
        </tr>
        <tr>
            <td>
                 Symfony
            </td>
            <td>
                PHP framework
            </td>
            <td>
                5.3.3
            </td>
        </tr>
        <tr>
            <td>
                 SCSS
            </td>
            <td>
                CSS preprocessor
            </td>
            <td>
                -
            </td>
        </tr>
        <tr>
            <td>
                 StimulusJS
            </td>
            <td>
                JS framework
            </td>
            <td>
                2.0.0
            </td>
        </tr>
    </tbody>
</table>

<h3> 
    Production
</h3>   
<a href="http://bluewom.herokuapp.com/">Live on heroku</a>

<h3> 
    Local start up 
</h3>   
<ul>
    <li>
        Add new database in your MariaDB (pref. ver.: 10.4.11) server with name bluewom
    </li>
    <li>
        Add line in .env file:
        <pre>DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/bluewom?serverVersion=mariadb-10.4.11"</pre>
        PS. Specify the MariaDB version corresponding to the one you have installed
    </li>
    <li>
        Install PHP dependencies: composer install
    </li>
    <li>
        Install NPM dependencies: npm install
    </li>
    <li>
        Run in parallel:
        <ul>
            <li>
                RUN PHP server: php -S localhost:8000 -t public
            </li>
            <li>
                Run NPM server: npm run watch
            </li>
        </ul>
    </li>
</ul>
