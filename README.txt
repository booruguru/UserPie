Copyright (c) 2013 UserPie

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.


Thank you for downloading UserPie, the simple user management package.

//--Installation.

1. Before proceeding please open up models/settings.php

2. Create a database on your server / web hosting package.

3. Fill out the connection details in settings.php

4. UserPie supports mysql and mysqli via phpBB's DBAL layer, UserPie defaults to mysql, to change it to mysqli change variable $dbtype to "mysqli".

5. You can setup the database manually or use the installer. If you wish to setup the database manually look inside the install folder and you will find sql.txt which contains the sql.

To use the installer visit http://yourdomain.com/install/ in your browser. UserPie will attempt to build the database for you. After completion delete the install folder.

6. The first user you create will be the admin.

-  That's it. For further documentation visit http://userpie.com


//--Notes

It is recommend that any database interaction you perform, you use the database abstraction layer. Info and help on using this can be located here;

http://wiki.phpbb.com/Dbal

//--Credits

UserPie is based upon UserCake created by Adam Davis - http://adavisdavis.co.uk

Database Abstraction Layer: phpBB Group - http://phpbb.com

---------------------------------------------------------------

Vers: 1.0
http://userpie.com
http://userpie.com/LICENCE.txt

