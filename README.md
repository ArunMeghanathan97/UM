<h1>Laravel 8 API based CRUD (Create, Read, Update, Delete) User Management</h1>
<p>This Project is used to you can add, edit, update, delete, search and export using API</p>
<p>  In "User Management" package we create all of the DB Tables, Entities, Seeders, View for manage users. </p>

<h1>It handles a management user. Some technicals applied to this project:</h1>
<ul>
  <li>Restful webservice</li>
  <li>Paging</li>
  <li>Middleware</li>
  <li>Exception handle</li>
  <li>PHP artisan</li>
  <li>Composer</li>
</ul>

<h1> Requirements </h1>
 <ul>
    <li>Laravel 8</li>
    <li>PHP8</li>
 </ul>

<h1>Installation</h1>
<ul> 
    <li>
        <p>1. Pull source code from github.</p>
        <pre>https://github.com/ArunMeghanathan97/UserManagement-Laravel-8.git</pre>
    </li>
    <li>
        <p> 2. Preparing database. We need to prepare default database for the first time use. At backend folder, run: </p>
        <pre>php artisan migrate</pre>
    </li>
    <li>
        <p>3. Set the application key for back-end. At backend folder, run:</p>
        <pre>php artisan key:generate</pre>
    </li>
</ul>

<h1>Usage</h1>
<p>You also can directly access back-end API via Restful webservice as below:</p>
<code>
<table>
    <tr>
        <th> Method </th>
        <th> API </th>
        <th> Parameters </th>
        <th> Action </th>
    </tr>
    <tr>
        <td>POST</td>
        <td>list</td>
        <td>page and search params (name , email , mobile ,state , dob) </td>
        <td> get user list  </td>
    </tr>
    <tr>
        <td>GET</td>
        <td>list</td>
        <td>page and search params (name , email , mobile ,state , dob)</td>
        <td> export user list </td>
    </tr>
    <tr>
        <td>POST</td>
        <td>add</td>
        <td>name, username, email, mobile, profile_img, dob, address, city, state, country</td>
        <td>add new user</td>
    </tr>
    <tr>
        <td>POST</td>
        <td>edit</td>
        <td>name, username, email, mobile, profile_img, dob, address, city, state, country</td>
        <td>update user details</td>
    </tr>
    <tr>
        <td>POST</td>
        <td>delete</td>
        <td>id</td>
        <td>delete user details</td>
    </tr>
    <tr>
        <td>POST</td>
        <td>detail</td>
        <td>id</td>
        <td>view user details</td>
    </tr>
</table>
</code>

<p> <b>Arunkumar</b> - full stack software engineer</p>
