# LARAVEL-FormInputs

Form Inputs is a Laravel package for managing form inputs by stocking them into a database and allowing users to download the data as XLSX files. The package also supports uploading XLSX files to populate the database.

## Features

- Stock form inputs in a database
- Download form input data as XLSX files
- Upload XLSX files to populate the database

## Technologies Used

- Laravel
- MySQL

## Installation

1. Install the package via Composer.
2. Publish the package configuration file.
3. Run the migration to create the necessary tables in the database.
4. Seed the database with test data (optional).

## Usage

1. Add the StoresFormInputs trait to the model where you want to store form input data.
2. Call the storeFormInputs method on the model to store the form input data.
3. Add a link to the route in your view.
4. Add a form to upload an XLSX file.
5. Add a route to handle the file upload.

## Contributing

Contributions to Form Inputs are welcome! Please follow these steps to contribute:

1. Fork this repository.
2. Create a branch: `git checkout -b my-new-feature`.
3. Make your changes and commit them: `git commit -m 'Add some feature'`.
4. Push to the branch: `git push origin my-new-feature`.
5. Submit a pull request.
