// http://querybuilder.js.org/

/* var used to define inputs for specimen

Defined inputs are used both on the classification
(where users field the specimen) page as well as 
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
            operators: ['equal', 'not_equal'],
            labelTag: {
                "title": "Title",
                "data-content": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum feugiat sodales. In hac habitasse platea dictumst. Nunc blandit suscipit finibus. Donec sit amet venenatis tortor. Pellentesque vel posuere nunc."
            },
            field: "status",
            label: "View",
            onchange: "nextSpecimen()",
            extraHTML: "<hr>"
        },
        {
            id: 'Genus',
            label: 'Genus',
            type: 'string',
            placeholder: 'Anthurium',
            validation: {
                format: /^[a-zA-Z]+$/
            },
            field: 'inputGenus',
            title: "Only letters are allowed" ,
            labelTag: {
                "title": "Title",
                "data-content": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum feugiat sodales. In hac habitasse platea dictumst. Nunc blandit suscipit finibus. Donec sit amet venenatis tortor. Pellentesque vel posuere nunc."
            },
        },
        {
            id: 'Section',
            label: 'Section',
            type: 'string',
            placeholder: 'Belolonchium',
            validation: {
                format: /^[a-zA-Z]+$/
            },
            field: 'inputSection',
            title: "Only letters are allowed" ,
            labelTag: {
                "title": "Title",
                "data-content": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum feugiat sodales. In hac habitasse platea dictumst. Nunc blandit suscipit finibus. Donec sit amet venenatis tortor. Pellentesque vel posuere nunc."
            },
        },
        {
            id: 'Species',
            label: 'Species',
            type: 'string',
            placeholder: 'longipoda',
            validation: {
                format: /^[a-zA-Z]+$/
            },
            field: 'inputSpecies',
            title: "Only letters are allowed" ,
            labelTag: {
                "title": "Title",
                "data-content": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum feugiat sodales. In hac habitasse platea dictumst. Nunc blandit suscipit finibus. Donec sit amet venenatis tortor. Pellentesque vel posuere nunc."
            },
        },
        {
            id: 'Collector',
            label: 'Collector',
            type: 'string',
            placeholder: 'Betancur',
            validation: {
                format: /^[a-zA-Z]+$/
            },
            field: 'inputCollector',
            title: "Only letters are allowed" ,
            labelTag: {
                "title": "Title",
                "data-content": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum feugiat sodales. In hac habitasse platea dictumst. Nunc blandit suscipit finibus. Donec sit amet venenatis tortor. Pellentesque vel posuere nunc."
            },
        },
        {
            id: 'Number',
            label: 'Number',
            type: 'integer',
            placeholder: '436',
            validation: {
                format: /^[1-9]+$/
            },
            field: 'inputNumber',
            title: "Only numbers are allowed" ,
            labelTag: {
                "title": "Title",
                "data-content": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum feugiat sodales. In hac habitasse platea dictumst. Nunc blandit suscipit finibus. Donec sit amet venenatis tortor. Pellentesque vel posuere nunc."
            },
        },
        {
            id: 'Determiner',
            label: 'Determiner',
            type: 'string',
            placeholder: 'Croat',
            validation: {
                format: /^[a-zA-Z]+$/
            },
            field: 'inputDeterminer',
            title: "Only letters are allowed" ,
            labelTag: {
                "title": "Title",
                "data-content": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum feugiat sodales. In hac habitasse platea dictumst. Nunc blandit suscipit finibus. Donec sit amet venenatis tortor. Pellentesque vel posuere nunc."
            },
        },
        {
            id: 'Herbarium',
            label: 'Herbarium',
            type: 'string',
            placeholder: 'COL',
            validation: {
                format: /^[a-zA-Z]+$/
            },
            field: 'inputHerbarium',
            title: "Only letters are allowed" ,
            labelTag: {
                "title": "Title",
                "data-content": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum feugiat sodales. In hac habitasse platea dictumst. Nunc blandit suscipit finibus. Donec sit amet venenatis tortor. Pellentesque vel posuere nunc."
            },
        },
        {
            id: 'Country',
            label: 'Country',
            type: 'string',
            placeholder: 'Colombia',
            validation: {
                format: /^[a-zA-Z]+$/
            },
            field: 'inputCountry',
            title: "Only letters are allowed" ,
            labelTag: {
                "title": "Title",
                "data-content": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum feugiat sodales. In hac habitasse platea dictumst. Nunc blandit suscipit finibus. Donec sit amet venenatis tortor. Pellentesque vel posuere nunc."
            },
        },
        {
            id: 'Deparment',
            label: 'Deparment',
            type: 'string',
            placeholder: 'Tolima',
            validation: {
                format: /^[a-zA-Z]+$/
            },
            field: 'inputDepartment',
            title: "Only letters are allowed" ,
            labelTag: {
                "title": "Title",
                "data-content": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum feugiat sodales. In hac habitasse platea dictumst. Nunc blandit suscipit finibus. Donec sit amet venenatis tortor. Pellentesque vel posuere nunc."
            },
        },
        {
            id: 'Municipality',
            label: 'Municipality',
            type: 'string',
            placeholder: 'Icononzo',
            validation: {
                format: /^[a-zA-Z]+$/
            },
            field: 'inputMunicipality',
            title: "Only letters are allowed" ,
            labelTag: {
                "title": "Title",
                "data-content": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum feugiat sodales. In hac habitasse platea dictumst. Nunc blandit suscipit finibus. Donec sit amet venenatis tortor. Pellentesque vel posuere nunc."
            },
        },
        {
            id: 'Location',
            label: 'Location',
            type: 'string',
            placeholder: 'el Taladro finca la Esperanza',
            validation: {
                format: /^[a-zA-Z0-9]+$/
            },
            field: 'inputLocation',
            title: "Only letters and numbers are allowed" ,
            labelTag: {
                "title": "Title",
                "data-content": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum feugiat sodales. In hac habitasse platea dictumst. Nunc blandit suscipit finibus. Donec sit amet venenatis tortor. Pellentesque vel posuere nunc."
            },
        },
        {
            id: 'Issue',
            label: 'Issue',
            type: 'string',
            input: 'select',
            values: {
                "":"None",
                "no_field":"No field present",
                "multiple_specimens":"Multiple specimens shown",
                "problem_field":"Problematic field"
            },
            field: 'inputIssue',
            labelTag: {
                "title": "Title",
                "data-content": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum feugiat sodales. In hac habitasse platea dictumst. Nunc blandit suscipit finibus. Donec sit amet venenatis tortor. Pellentesque vel posuere nunc."
            },
            operators: ['equal', 'not_equal']
        },
    ]
};
