<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => ['code' => 'must_be_accepted'],
    'active_url'           => ['code' => 'invalid_url'],
    'after'                => [
        'code'      => 'must_be_after_date',
        'date'      => ':date'
    ],
    'alpha'                => ['code' => 'only_letters_allowed'],
    'alpha_dash'           => ['code' => 'only_letters_numbers_dashes_allowed'],
    'alpha_num'            => ['code' => 'only_letters_numbers_allowed'],
    'array'                => ['code' => 'must_be_an_array'],
    'before'               => [
        'code'      => 'must_be_before_date',
        'date'      => ':date'
    ],
    'between'              => [
        'code'      => 'must_be_between_min_max',
        'min'       => ':min',
        'max'       => ':max'
    ],
    'boolean'              => ['code' => 'must_be_true_or_false'],
    'confirmed'            => ['code' => 'confirmation_does_not_match'],
    'date'                 => ['code' => 'not_a_valid_date'],
    'date_format'          => [
        'code'      => 'invalid_date_format',
        'format'    => ':format'
    ],
    'different'            => [
        'code'      => 'must_be_different_than_other',
        'other'     => ':other'
    ],
    'digits'               => [
        'code'      => 'must_be_number_of_digits',
        'digits'    => ':digits'
    ],
    'digits_between'       => [
        'code'      => 'must_be_between_min_max_number_of_digits',
        'min'       => ':min',
        'max'       => ':max'
    ],
    'dimensions'           => ['code' => 'invalid_image_dimensions'],
    'distinct'             => ['code' => 'has_duplicate_value'],
    'email'                => ['code' => 'invalid_email_address_format'],
    'exists'               => ['code' => 'invalid_attribute_selected'],
    'file'                 => ['code' => 'not_a_file'],
    'filled'               => ['code' => 'field_required'],
    'image'                => ['code' => 'not_an_image'],
    'in'                   => ['code' => 'invalid_attribute_selected'],
    'in_array'             => [
        'code'      => 'field_does_not_exist_in',
        'other'     => ':other'
    ],
    'integer'              => ['code' => 'not_an_integer'],
    'ip'                   => ['code' => 'invalid_ip_address'],
    'json'                 => ['code' => 'invalid_json_string'],
    'max'                  => [
        'code'      => 'must_not_be_greater_than',
        'max'       => ':max'
    ],
    'mimes'                => [
        'code'      => 'invalid_file_type',
        'values'    => ':values'
    ],
    'mimetypes'            => [
        'code'      => 'invalid_file_type',
        'values'    => ':values'
    ],
    'min'                  => [
        'code'      => 'must_be_at_less_than',
        'min'       => ':min'
    ],
    'not_in'               => ['code' => 'invalid_attribute_selected'],
    'numeric'              => ['code' => 'not_a_number'],
    'present'              => [
        'code'      => 'field_not_present',
        'field'     => ':attribute'
    ],
    'regex'                => ['code' => 'invalid_format'],
    'required'             => ['code' => 'field_required'],
    'required_if'          => [
        'code'      => 'field_required_when_other_is_value',
        'other'     => ':other',
        'value'     => ':value'
    ],
    'required_unless'      => [
        'code'      => 'field_required_unless_other_is_in_values',
        'other'     => ':other',
        'values'    => ':values'
    ],
    'required_with'        => [
        'code'      => 'field_required_when_values_is_present',
        'values'    => ':values'
    ],
    'required_with_all'    => [
        'code'      => 'field_required_when_values_is_present',
        'values'    => ':values'
    ],
    'required_without'     => [
        'code'      => 'field_required_when_values_is_not_present.',
        'values'    => ':values'
    ],
    'required_without_all' => [
        'code'      => 'field_required_when_none_of_values_are_present.',
        'values'    => ':values'
    ],
    'same'                 => [
        'code'      => 'must_match_other',
        'other'     => ':other'
    ],
    'size'                 => [
        'code'      => 'must_be_of_size',
        'size'  => ':size'
    ],
    'string'               => ['code' => 'not_a_string'],
    'timezone'             => ['code' => 'not_a_valid_timezone'],
    'unique'               => ['code' => 'not_unique'],
    'uploaded'             => ['code' => 'failed_to_upload'],
    'url'                  => ['code' => 'invalid_format'],





    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];
