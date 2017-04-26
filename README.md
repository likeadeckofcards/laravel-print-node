# Laravel-PrintNode
Laravel Wrapper for PrintNode API. More about PrintNode can be found here: http://www.printnode.com

# Laravel 5
This package has been written in Laravel 5.4 but should support previous versions of Laravel 5.
 
# Installation
You can pull this package in through Composer.
```
composer require infernobass7/laravel-print-node
```
You will need to add the following lines to `config/app.php`
```
'providers' => [
    ...
    Infernobass7\Laravel-PrintNode\PrintNodeServiceProvider::class,
    ...
]
```

Next you will want to publish the config file. 
```
php artisan vendor:publish
```

#Configuration
The config files comes with two sections out of the box. The first is auth, which is required in 
order for the package to work. The username is either the API Key or the email address. If you 
use the API Key you should not provide a password. However, if you use an email address, you must 
provide the password too. The second section is the configuration options for printing. These will 
be used as a default should you not specify any while creating a PrintJob. 

```
return [
    'auth' => [
        /*
         * Use this to set either API Key or email
         */
        'username' => '',
        
        /*
         * Do not set this if you are using API Key
         */
        'password' => ''
    ],
    
    'options' => [
        /*
         *  * = Options only available when installed client is running on a OSX Machine
         */
//      'bin' => , // String
//      'collate' => , // Boolean
//      'copies' => , // Integer
//      'dpi' => , // String
//      'duplex' => , // String - "long-edge" or "short-edge"
//      'fit_to_page' => , // * Boolean
//      'media' => , //String
//      'nup' => , // * String - Print Multiple Pages on One Sheet
//      'pages' => , // String - Specific Set of pages from the PDF. Format explained here https://printnode.com/docs/api/curl/#parameters
//      'paper' => , // String - Named paper size
//      'rotate' => // Integer - Rotate Page specified degrees ( accepted values: 90, 180, or 270 )
    ]
];
```

#Usage

##Printer
This class handles retrieving list of Printers from PrintNode.
```
/*
 * Will return a collection of Printer Objects 
 */
Printer::all();
 
/*
 * Will return the specific printer Object based on the ID.
 * The ID can retrieved from PrintNode's service.
 */
$printer = Printer::get($printer_id);

/*
 * Retrieve a list of all PrintJobs previously printed on the Printer
 */
$previousJobs = $printer->getPrintJobs(); 
 
/*
 * Retrieve a specific print job previousl printed on the Printer
 */
$previousJob = $printer->getPrintJob($id);
```

##Print Job
This class handles retrieving and creating new PrintJobs.
```
/*
 * Create a new PrintJob
 */
$job = new PrintJob($attributes = []);
 
/*
 * Sends the print job to the specified Printer
 */
$job->print(Printer $printer);
// Alternatively
$printer->print(PrintJob $job);

/*
 * Fluent Setters to create PrintJob
 */
 
/*
 * Grabs file based on the path of the storage disk defined in Storage Configuration 
 * Set contentType to either 'raw_base64' or 'pdf_base64'
 */
$job->setFile($path, $disk = 'local', $raw = false);

/*
 * Sets the content to the URI provided
 * Sets Credentials for basic Authentication type
 */
$job->setUri($uri, $credentials = null, $raw = false);
// Alternatively 
$job->setUri($uri)->setAuthentication($credentials, $basic = true);

/*
 * 
 */
$job->setOptions($options = []);

/*
 * Please note the next two methods are not the same.
 */

/*
 * Sets the number of times that the PrintJob is going to be sent to the Printer
 */
$job->setQuantity(int $qauntity);

/*
 * Sets the number of copies that are printed per PrintJob
 */
$job->setCopies(int $quantity);

/*
 * Sets the source name to display on PrintNode
 */
$job->setSource($name);

/*
 * Sets how long in seconds the PrintJob will sit in the queue waiting to be printed
 * Afterwards it will be deleted
 */
$job->setExpireAfter(int $seconds);
```