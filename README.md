# PDF signing

## Table of Contents

- [Overview](#overview)
- [Requirements](#requirements)
- [Install Guide][#install-guide]
- [Usage](#usage)

## Overview

PHP package for signing PDF documents. The package requires path of PDF, certificate and private key.

## Requirements

This package has been developed in PHP 7.3

## Install Guide

To install this package first clone this repository to your project:

```bash
git clone :gitpath
```

In `composer.json` add:

```json
"require": {
    "$username/$repository": "dev-master"
},
// ...
"repositories": [
    {
        "type": "path",
        "url": "/path/to/the/project" // or link to package repository
    }
]
```

Then install the package:

```bash
composer install
```



## Usage

```php
$signPdfService = new SignPdfService($filePath, $certificate, $privateKey);

$signedPdf = $signPdfService->execute();
```

Returned value should be string containing signed PDF.
