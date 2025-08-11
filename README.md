# Appointment Date Prepopulate Module

## Overview

The **Appointment Date Prepopulate** module is a simple but effective utility for Drupal that enhances the user experience when creating appointments. Its sole purpose is to automatically populate the date field on the appointment creation form based on a `date` parameter provided in the URL.

This is particularly useful when linking from a calendar or a list of available days, as it reduces the number of clicks and potential errors for the user.

## Requirements

This module is specifically designed to work with a particular content type and field. Before use, please ensure the following are present on your site:

* **Content Type**: The module targets a content type with the machine name `appointment`.
* **Date Field**: The `appointment` content type must have a Date field with the machine name `field_appointment_date`.

## Features

* **URL-Based Prepopulation**: Automatically fills the appointment date field from a URL query parameter.
* **Robust Implementation**: Uses both `hook_form_alter()` to set the default value when the form is built and `hook_node_presave()` as a failsafe to ensure the date is set on the node just before saving.
* **Flexible Date Formatting**: Correctly parses dates from the URL and formats them to the `YYYY-MM-DD` format required by the field.

## How It Works

The module uses two Drupal hooks to achieve its functionality:

1.  **`hook_form_alter()`**: When the appointment creation form (`node_appointment_form`) is loaded, this hook inspects the current URL for a query parameter named `date`. If found, it takes the value and sets it as the default value for the `field_appointment_date` form element.
2.  **`hook_node_presave()`**: As a backup, this hook runs just before an appointment node is saved to the database. It performs the same check for a `date` parameter in the URL and directly sets the value on the node object if it exists. This ensures the date is captured even if other modules interfere with the form's default values.

## Installation

1.  Place the `appointment_date_prepopulate` module folder in your Drupal site's `modules/custom` directory.
2.  Enable the module through the Drupal admin UI or by using Drush:
    ```sh
    drush en appointment_date_prepopulate
    ```

## Usage

To use this module, simply create a link to the appointment creation page and append the date you wish to pre-fill as a query parameter.

**Example Link:**
To create a link that pre-fills the date for December 25, 2025, your URL would look like this:

`/node/add/appointment?date=2025-12-25`

When a user clicks this link, the "Appointment Date" field on the form will be automatically populated with "2025-12-25".
