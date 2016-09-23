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
            operators: ['equal', 'not_equal'],
            label: {
                "title": "Title",
                "data-content": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum feugiat sodales. In hac habitasse platea dictumst. Nunc blandit suscipit finibus. Donec sit amet venenatis tortor. Pellentesque vel posuere nunc."
            },
            name: "inputView",
            onchange: "nextSpecimen()",
            extraHTML: "<hr>"
        },
        {
            id: 'Genus',
            type: 'string',
            placeholder: 'Anthurium',
            validation: {
                format: /^[a-zA-Z]+$/
            },
            name: 'inputGenus',
            title: "Only letters are allowed" ,
            label: {
                "title": "Title",
                "data-content": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum feugiat sodales. In hac habitasse platea dictumst. Nunc blandit suscipit finibus. Donec sit amet venenatis tortor. Pellentesque vel posuere nunc."
            },
        },
        {
            id: 'Section',
            type: 'string',
            placeholder: 'Belolonchium',
            validation: {
                format: /^[a-zA-Z]+$/
            },
            name: 'inputSection',
            title: "Only letters are allowed" ,
            label: {
                "title": "Title",
                "data-content": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum feugiat sodales. In hac habitasse platea dictumst. Nunc blandit suscipit finibus. Donec sit amet venenatis tortor. Pellentesque vel posuere nunc."
            },
        },
        {
            id: 'Species',
            type: 'string',
            placeholder: 'longipoda',
            validation: {
                format: /^[a-zA-Z]+$/
            },
            name: 'inputSpecies',
            title: "Only letters are allowed" ,
            label: {
                "title": "Title",
                "data-content": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum feugiat sodales. In hac habitasse platea dictumst. Nunc blandit suscipit finibus. Donec sit amet venenatis tortor. Pellentesque vel posuere nunc."
            },
        },
        {
            id: 'Collector',
            type: 'string',
            placeholder: 'Betancur',
            validation: {
                format: /^[a-zA-Z]+$/
            },
            name: 'inputCollector',
            title: "Only letters are allowed" ,
            label: {
                "title": "Title",
                "data-content": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum feugiat sodales. In hac habitasse platea dictumst. Nunc blandit suscipit finibus. Donec sit amet venenatis tortor. Pellentesque vel posuere nunc."
            },
        },
        {
            id: 'Number',
            type: 'integer',
            placeholder: '436',
            validation: {
                format: /^[1-9]+$/
            },
            name: 'inputNumber',
            title: "Only numbers are allowed" ,
            label: {
                "title": "Title",
                "data-content": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum feugiat sodales. In hac habitasse platea dictumst. Nunc blandit suscipit finibus. Donec sit amet venenatis tortor. Pellentesque vel posuere nunc."
            },
        },
        {
            id: 'Determiner',
            type: 'string',
            placeholder: 'Croat',
            validation: {
                format: /^[a-zA-Z]+$/
            },
            name: 'inputDeterminer',
            title: "Only letters are allowed" ,
            label: {
                "title": "Title",
                "data-content": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum feugiat sodales. In hac habitasse platea dictumst. Nunc blandit suscipit finibus. Donec sit amet venenatis tortor. Pellentesque vel posuere nunc."
            },
        },
        {
            id: 'Herbarium',
            type: 'string',
            placeholder: 'COL',
            validation: {
                format: /^[a-zA-Z]+$/
            },
            name: 'inputHerbarium',
            title: "Only letters are allowed" ,
            label: {
                "title": "Title",
                "data-content": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum feugiat sodales. In hac habitasse platea dictumst. Nunc blandit suscipit finibus. Donec sit amet venenatis tortor. Pellentesque vel posuere nunc."
            },
        },
        {
            id: 'Country',
            type: 'string',
            placeholder: 'Colombia',
            validation: {
                format: /^[a-zA-Z]+$/
            },
            name: 'inputCountry',
            title: "Only letters are allowed" ,
            label: {
                "title": "Title",
                "data-content": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum feugiat sodales. In hac habitasse platea dictumst. Nunc blandit suscipit finibus. Donec sit amet venenatis tortor. Pellentesque vel posuere nunc."
            },
        },
        {
            id: 'Deparment',
            type: 'string',
            placeholder: 'Betancur',
            validation: {
                format: /^[a-zA-Z]+$/
            },
            name: 'inputDepartment',
            title: "Only letters are allowed" ,
            label: {
                "title": "Title",
                "data-content": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum feugiat sodales. In hac habitasse platea dictumst. Nunc blandit suscipit finibus. Donec sit amet venenatis tortor. Pellentesque vel posuere nunc."
            },
        },
        {
            id: 'Municipality',
            type: 'string',
            placeholder: 'Icononzo',
            validation: {
                format: /^[a-zA-Z]+$/
            },
            name: 'inputMunicipality',
            title: "Only letters are allowed" ,
            label: {
                "title": "Title",
                "data-content": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum feugiat sodales. In hac habitasse platea dictumst. Nunc blandit suscipit finibus. Donec sit amet venenatis tortor. Pellentesque vel posuere nunc."
            },
        },
        {
            id: 'Location',
            type: 'string',
            placeholder: 'el Taladro finca la Esperanza',
            validation: {
                format: /^[a-zA-Z0-9]+$/
            },
            name: 'inputLocation',
            title: "Only letters and numbers are allowed" ,
            label: {
                "title": "Title",
                "data-content": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum feugiat sodales. In hac habitasse platea dictumst. Nunc blandit suscipit finibus. Donec sit amet venenatis tortor. Pellentesque vel posuere nunc."
            },
        },
        {
            id: 'Issue',
            type: 'string',
            input: 'select',
            values: {
                "":"None",
                "no_label":"No label present",
                "multiple_specimens":"Multiple specimens shown",
                "problem_label":"Problematic label"
            },
            name: 'inputIssue',
            label: {
                "title": "Title",
                "data-content": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum feugiat sodales. In hac habitasse platea dictumst. Nunc blandit suscipit finibus. Donec sit amet venenatis tortor. Pellentesque vel posuere nunc."
            },
            operators: ['equal', 'not_equal']
        },
    ]
};
