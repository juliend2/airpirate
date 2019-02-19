# README

## Usage

```php
include 'airpirate.php';
define('API_KEY', 'YOUR API KEY');

$n_records = do_with_records(API_KEY, 'baseID', 'tablename', 'viewname', function($records){
    echo '<dl>';
    foreach ($records as $record) {
        echo '<dt>';
        echo $record->fields->Date;
        echo '</dt>';
        echo '<dd>';
        if (isset( ((array) $record->fields )['Bien être'])) {
            echo ((array) $record->fields )['Bien être'];
        }
        echo '</dd>';
    }
    echo '</dl>';
});

echo '<br/>';
echo $n_records . ' records';
```

## License

MIT.