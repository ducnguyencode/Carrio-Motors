<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Application Code Style and Language Rules
    |--------------------------------------------------------------------------
    |
    | This configuration file defines the rules and standards for code
    | style and language usage throughout the application.
    |
    */

    'language' => [
        // All application code must be written in English
        'use_english_only' => true,

        // Standardized messages
        'validation_messages' => [
            'required' => 'The :attribute field is required.',
            'max' => 'The :attribute may not be greater than :max.',
            'exists' => 'The selected :attribute is invalid.',
            'boolean' => 'The :attribute field must be true or false.',
            'numeric' => 'The :attribute must be a number.',
            'file' => 'The :attribute must be a file.',
            'mimes' => 'The :attribute must be a file of type: :values.',
            'max_file' => 'The :attribute may not be greater than :max kilobytes.',
        ],

        // Success messages
        'success_messages' => [
            'created' => ':resource created successfully.',
            'updated' => ':resource updated successfully.',
            'deleted' => ':resource deleted successfully.',
        ],

        // Error messages
        'error_messages' => [
            'upload_failed' => 'Failed to upload :resource. Please try again.',
            'save_failed' => 'Failed to save :resource. Please try again.',
            'not_found' => ':resource not found.',
            'unauthorized' => 'You are not authorized to perform this action.',
        ],
    ],

    'code_style' => [
        // PSR-2 coding standards
        'follow_psr2' => true,

        // Prefer camelCase for variable names
        'camel_case_for_variables' => true,

        // Prefer snake_case for database columns
        'snake_case_for_db_columns' => true,

        // Use a consistent line ending
        'line_ending' => 'LF', // Can be 'LF' or 'CRLF'

        // Naming conventions
        'naming_conventions' => [
            'controllers' => 'PascalCase',
            'models' => 'PascalCase',
            'views' => 'snake_case',
            'routes' => 'snake_case',
        ],
    ],
];
