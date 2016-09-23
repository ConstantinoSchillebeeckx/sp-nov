// http://querybuilder.js.org/

/* var used to define inputs for specimen

Defined inputs are used both on the classification
(where users label the specimen) page as well as 
the search page.

*/
var builderOptions = {
    display_empty_filter: false,
    icons: {error: 'glyphicon glyphicon-exclamation-sign'},
    filters: [
        {
            id: 'View',
            type: 'string',
            input: 'select',
            values: {
                "all":"All specimens",
                "finished":"Finished specimens",
                "unfinished":"Unfinished specimens",
                "issue":"Specimen with issue"
            },
            operators: ['equal', 'not_equal']
        },
        {
            id: 'Genus',
            type: 'string',
            placeholder: 'Anthurium',
            validation: {
                format: /^[a-zA-Z]+$/
            },
        },
        {
            id: 'Section',
            type: 'string',
            placeholder: 'Belolonchium',
            validation: {
                format: /^[a-zA-Z]+$/
            },
        },
        {
            id: 'Species',
            type: 'string',
            placeholder: 'longipoda',
            validation: {
                format: /^[a-zA-Z]+$/
            },
        },
        {
            id: 'Collector',
            type: 'string',
            placeholder: 'Betancur',
            validation: {
                format: /^[a-zA-Z]+$/
            },
        },
        {
            id: 'Number',
            type: 'integer',
            placeholder: '436',
            validation: {
                format: /^[1-9]+$/
            },
        },
        {
            id: 'Determiner',
            type: 'string',
            placeholder: 'Croat',
            validation: {
                format: /^[a-zA-Z]+$/
            },
        },
        {
            id: 'Herbarium',
            type: 'string',
            placeholder: 'COL',
            validation: {
                format: /^[a-zA-Z]+$/
            },
        },
        {
            id: 'Country',
            type: 'string',
            placeholder: 'Colombia',
            validation: {
                format: /^[a-zA-Z]+$/
            },
        },
        {
            id: 'Deparment',
            type: 'string',
            placeholder: 'Betancur',
            validation: {
                format: /^[a-zA-Z]+$/
            },
        },
        {
            id: 'Municipality',
            type: 'string',
            placeholder: 'Icononzo',
            validation: {
                format: /^[a-zA-Z]+$/
            },
        },
        {
            id: 'Location',
            type: 'string',
            placeholder: 'el Taladro finca la Esperanza',
            validation: {
                format: /^[a-zA-Z]+$/
            },
        },
        {
            id: 'Issue',
            type: 'string',
            input: 'select',
            values: {
                "no_label":"No label present",
                "multiple_specimens":"Multiple specimens shown",
                "problem_label":"Problematic label"
            },
            operators: ['equal', 'not_equal']
        },
    ]
};
