# E-liides HTTP Cloud Printer
Print PDF files to local windows computer over HTTP requests

## Register licence
Register account and create new 10 day trial licence on site:
https://www.e-liides.ee/et/printer

## Download .exe file and setup windows program

After receiving licence key download .exe setup to windows computer what is connected to printer

Now insert licence key to opened popup and follow next steps.

## Connect your web application with API
### Install via composer
    composer require veebiekspert/cloud-print
    
### Use API from your PHP application

    <?php
    use Veebiekspert\CloudPrint\Api;
    
    $licenceKey = ''; // replace this with your e-liides licence key
    
    $pdfPath = ''; // path where pdf file exists
    $pdfFileSource = file_get_contents($pdfPath);
    
    $cloudPrinter = new Api($licenceKey);
    
    $printers = [];
    foreach ($cloudPrinter->getPrinters() as $printer) {
        $printers[] = [
            'printer_id' => $printer['printer_id'],
            'name' => $printer['name'],
        ];
    }
    
    // Get first printer if exists
    if (!empty($printers)) {
        $printer = array_shift($printers);
        $cloudPrinter->addJob($pdfFileSource, $printer['printer_id']);
        
        // up to 10 seconds and windows device starts printing
    }
    
# Important notes for success printing
1. Windows machine must be running
2. Installed .exe application must be running, default it launch automatically after restart
3. Java installed to windows machine

# Swagger documentation
https://e-liides.ee/api/documentation#/Cloud%20Print    
