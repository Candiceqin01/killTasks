<?php


function login()
{
$input_style='border-2 border-grey-600 rounded';
  return "
        <form action='../service/auth.php' method='POST'>
        <label for='email'>Email</label>
        <input type='text' name='email' id='email'>
        <label for='password'>Password</label>
        <input type='password' name='password' id='password'>
        <button type='submit'>Login</button>
    </form>
        <a href='register.php'>No account? Register!</a>
  
  ";
}
