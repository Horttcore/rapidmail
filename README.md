# rapidmail

A rapidmail api client

## Usage

### Create a connection

```php
<?php
$connection = new RapidMail( $user, $password );
```

### Get recipient lists

```php
<?php
$recipientlists = new RecipientLists($connection);
$list = $recipientlists->get(); // Retrieve paged recipient lists;
$lists = $recipientlists->getAll(); // Get all recipient lists
```

### Get a specific list

```php
<?php
$recipientlist = (new RecipientList($connection, $listId))->get();
```

### Create a new Mailing

```php
<?php
$mailing = new Mailing($connection);
$mailing->status = 'scheduled';
$mailing->recipientListId = 1413;
$mailing->fromName = 'My Website';
$mailing->fromEmail = 'newsletter@domain.tld';
$mailing->subject = 'Awesome Newsletter';
$mailing->sendAt = '2019-06-15 8:00:00';
$mailing->file = __DIR__ . '/mailing.zip';
$mailing->save();
```

### Get a mailing

```php
<?php
$mailing = (new Mailing($connection, $mailingId))->get();
echo $mailing->subject;
```
