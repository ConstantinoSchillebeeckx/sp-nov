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
                "unfinished":"Unlabeled specimens",
                "finished":"Labeled specimens",
                "all":"All specimens",
                "issue":"Specimen with issue"
            },
            operators: ['equal'],
            labelTag: {
                "title": "Title",
                "data-content": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum feugiat sodales. In hac habitasse platea dictumst. Nunc blandit suscipit finibus. Donec sit amet venenatis tortor. Pellentesque vel posuere nunc."
            },
            field: "status",
            label: "View",
            onchange: "viewChange()",
            extraHTML: "<hr>"
        },
        {
            id: 'Genus',
            label: 'Genus',
            type: 'string',
            placeholder: 'Anthurium',
            operators: ['equal','not_equal','begins_with','not_begins_with','contains','not_contains','ends_with','not_ends_with','is_empty','is_not_empty'],
            validation: {
                format: '[a-zA-Z]+'
            },
            field: 'inputGenus',
            title: "Only letters are allowed" ,
            labelTag: {
                "title": "Genus",
                "data-content": "A taxonomic category, below family (like Araceae) and above species. It will have a capitalized name.  If Araceae is car, then Genus is Honda. <code>Anthurium</code> and <code>Philodendron</code> are the two most common <code>Araceae</code> Genera (plural of Genus)"
            },
        },
        {
            id: 'Section',
            label: 'Section',
            type: 'string',
            placeholder: 'Belolonchium',
            operators: ['equal','not_equal','begins_with','not_begins_with','contains','not_contains','ends_with','not_ends_with','is_empty','is_not_empty'],
            validation: {
                format: '[a-zA-Z. ]+'
            },
            field: 'inputSection',
            title: "Only letters, spaces and periods are allowed" ,
            labelTag: {
                "title": "Section",
                "data-content": "If species is not available, sometimes section or subgenus may be listed. Those are both ways of splitting up the Genus. For our example, think Honda sedans. An example section is <code>Sect. Belolonchium</code>"
            },
        },
        {
            id: 'Species',
            label: 'Species',
            type: 'string',
            placeholder: 'longipoda',
            operators: ['equal','not_equal','begins_with','not_begins_with','contains','not_contains','ends_with','not_ends_with','is_empty','is_not_empty'],
            validation: {
                format: '[a-zA-Z ]+'
            },
            field: 'inputSpecies',
            title: "Only letters and spaces are allowed" ,
            labelTag: {
                "title": "Species",
                "data-content": "A species is a group of plants that are capable of breeding. The name is lowercase. Think civic in our example. An example for the genus <code>Philodendron</code> is <code>fragrantissimum</code>; in cases of a new species enter <code>sp. nov</code>"
            },
        },
        {
            id: 'Collector',
            label: 'Collector',
            type: 'string',
            placeholder: 'Betancur',
            operators: ['equal','not_equal','begins_with','not_begins_with','contains','not_contains','ends_with','not_ends_with','is_empty','is_not_empty'],
            validation: {
                format: '[a-zA-Z\- ]+'
            },
            field: 'inputCollector',
            title: "Only letters and spaces are allowed" ,
            labelTag: {
                "title": "Collector",
                "data-content": "The person who (<em>possibly literally</em>) went out on a limb to get a piece of the plant. We are using just the last name. If there are two people we use the two last names. If there are more than two, we use the first last name followed by et al. For example <code>Smith et al.</code>"
            },
        },
        {
            id: 'Number',
            label: 'Number',
            type: 'string',
            placeholder: '436',
            operators: ['equal','not_equal','begins_with','not_begins_with','contains','not_contains','ends_with','not_ends_with','is_empty','is_not_empty'],
            validation: {
                format: '[0-9a-zA-Z\- ]+'
            },
            field: 'inputNumber',
            title: "Only numbers, letters, spaces and dashes are allowed" ,
            labelTag: {
                "title": "Collection number",
                "data-content": "Each plant that is collected gets it very own number. For our Honda civic, think VIN number."
            },
        },
        /*{
            id: 'Determiner',
            label: 'Determiner',
            type: 'string',
            placeholder: 'Croat',
            validation: {
                format: '[a-zA-Z ]+'
            },
            field: 'inputDeterminer',
            title: "Only letters are allowed" ,
            labelTag: {
                "title": "Title",
                "data-content": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum feugiat sodales. In hac habitasse platea dictumst. Nunc blandit suscipit finibus. Donec sit amet venenatis tortor. Pellentesque vel posuere nunc."
            },
        },*/
        {
            id: 'Herbarium',
            label: 'Herbarium',
            type: 'string',
            placeholder: 'COL',
            operators: ['equal','not_equal','begins_with','not_begins_with','contains','not_contains','ends_with','not_ends_with','is_empty','is_not_empty'],
            validation: {
                format: '[A-Z]+'
            },
            field: 'inputHerbarium',
            title: "Only uppercase letters are allowed",
            labelTag: {
                "title": "Title",
                "data-content": "The Collector brought the specimen back to a herbarium, and had it dried and mounted on a sheet. Each herbarium has its own initials. Sadly, they do not always correlate to the name. If you cannot find the herbarium initials on the label, If you cannot find the herbarium initials on the label, try looking it up on <a href='www.tropicos.org'>www.tropicos.org</a>. Use the pull down tab <b>More</b>, then select <b>Institutions</b>. Enter the country and hit enter. You will have a list of all the herbaria in that country. If it’s too long to eyeball, you can use control-F to search on a keyword. Another option is to look at the entire sheet in another picture and see if there is a stamp on it with the initials. If you don’t find it, email Amy (apredfield@hotmail.com)."
            },
        },
        {
            id: 'Country',
            label: 'Country',
            type: 'string',
            placeholder: 'Colombia',
            operators: ['equal','not_equal','begins_with','not_begins_with','contains','not_contains','ends_with','not_ends_with','is_empty','is_not_empty'],
            validation: {
                format: '[a-zA-Z]+'
            },
            field: 'inputCountry',
            title: "Only letters are allowed" ,
            labelTag: {
                "title": "Country",
                "data-content": "The country in which the specimen was collected, for example <code>Columbia</code>."
            },
        },
        {
            id: 'Deparment',
            label: 'Deparment',
            type: 'string',
            placeholder: 'Tolima',
            operators: ['equal','not_equal','begins_with','not_begins_with','contains','not_contains','ends_with','not_ends_with','is_empty','is_not_empty'],
            validation: {
                format: '[a-zA-Z ]+'
            },
            field: 'inputDepartment',
            title: "Only letters and spaces are allowed" ,
            labelTag: {
                "title": "Department",
                "data-content": "The Department, State, or Province the specimen is from."
            },
        },
        {
            id: 'Municipality',
            label: 'Municipality',
            type: 'string',
            operators: ['equal','not_equal','begins_with','not_begins_with','contains','not_contains','ends_with','not_ends_with','is_empty','is_not_empty'],
            placeholder: 'Icononzo',
            validation: {
                format: '[a-zA-Z ]+'
            },
            field: 'inputMunicipality',
            title: "Only letters and spaces are allowed" ,
            labelTag: {
                "title": "Municipality",
                "data-content": "The municipality or town the specimen is from; this will often times be preceeded by the abbreviation <strong>Mun.</strong>."
            },
        },
        {
            id: 'Issue',
            label: 'Issue',
            type: 'string',
            input: 'select',
            onchange: "onChangeIssue()",
            values: {
                "":"None",
                "missing_image": "Missing image",
                "missing_information": "Missing label information",
                "cant_read": "Can't read label",
                "multiple_specimens":"Multiple specimens shown",
                "problem_field":"Problematic field",
                "label_orientation": "Bad label orientation",
                "duplicate_photos": "Duplicate photos",
                "other": "Other issue not listed",
            },
            field: 'inputIssue',
            labelTag: {
                "title": "Issue",
                "data-content": "If some sort of issue arises with the images or the current specimen, please choose the most appropriate issue type."
            },
            operators: ['equal', 'not_equal','is_empty','is_not_empty']
        },
        {
            id: 'Notes',
            label: 'Issue notes',
            type: 'string',
            operators: ['is_empty','is_not_empty'],
            field: 'issueNotes',
            placeholder: 'Please add any issue notes here',
            validation: {
                format: '[a-zA-Z0-9 ,.]+'
            },
            title: "Only letters, numbers, spaces, commas and periods are allowed" ,
        },
        {
            id: 'Downloaded',
            label: 'Has been downloaded',
            type: 'integer',
            input: 'select',
            operators: ['is_empty','is_not_empty'],
            hide: true,
            field: 'downloaded',
            title: "Only letters are allowed" ,
        },
    ]
};
