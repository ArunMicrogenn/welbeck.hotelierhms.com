<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
*/

$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
    'dsn'          => '',
    'hostname'     => 'DRIVER={SQL Server Native Client 11.0};Server=164.52.195.176\SQLEXPRESS;Database=welbeck;MARS_Connection=Yes;',
    'username'     => 'sa',
    'password'     => 'Mgenn@123',
    'database'     => 'welbeck',
    'dbdriver'     => 'odbc',
    'dbprefix'     => '',
    'pconnect'     => FALSE,
    'db_debug'     => FALSE,
    'cache_on'     => FALSE,
    'cachedir'     => '',
    'char_set'     => 'utf8',
    'dbcollat'     => 'utf8_general_ci',
    'swap_pre'     => '',
    'encrypt'      => FALSE,
    'compress'     => FALSE,
    'stricton'     => FALSE,
    'failover'     => array(),
    'save_queries' => TRUE
);

$db['another_db'] = array(
    'dsn'          => '',
    'hostname'     => 'DRIVER={SQL Server Native Client 11.0};Server=164.52.195.176\SQLEXPRESS;Database=mpower_beehives;',
    'username'     => 'sa',
    'password'     => 'Mgenn@123',
    'database'     => 'mpower_beehives',
    'dbdriver'     => 'odbc',
    'dbprefix'     => '',
    'pconnect'     => FALSE,
    'db_debug'     => FALSE,
    'cache_on'     => FALSE,
    'cachedir'     => '',
    'char_set'     => 'utf8',
    'dbcollat'     => 'utf8_general_ci',
    'swap_pre'     => '',
    'encrypt'      => FALSE,
    'compress'     => FALSE,
    'stricton'     => FALSE,
    'failover'     => array(),
    'save_queries' => TRUE
);

$db['whatsapp_db'] = array(
    'dsn'          => '',
    'hostname'     => 'DRIVER={SQL Server Native Client 11.0};Server=164.52.195.176\SQLEXPRESS;Database=Whatsapp;MARS_Connection=Yes;',
    'username'     => 'sa',
    'password'     => 'Mgenn@123',
    'database'     => 'Whatsapp',
    'dbdriver'     => 'odbc',
    'dbprefix'     => '',
    'pconnect'     => FALSE,
    'db_debug'     => FALSE,
    'cache_on'     => FALSE,
    'cachedir'     => '',
    'char_set'     => 'utf8',
    'dbcollat'     => 'utf8_general_ci',
    'swap_pre'     => '',
    'encrypt'      => FALSE,
    'compress'     => FALSE,
    'stricton'     => FALSE,
    'failover'     => array(),
    'save_queries' => TRUE
);

// SECURITY WARNING:
// SA password committed to GitHub - change immediately!
// 1. Change SA password on SQL Server
// 2. Create low-privilege app DB user (not SA)
// 3. Add database.php to .gitignore
```

---

**Commit aana piragu VPS RDP-la:**
```
cd C:\inetpub\wwwroot\welbeckfodemo
git pull origin main
