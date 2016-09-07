# sp-nov

Simple web-app for adding label metadata to a herbarium specimen.

## Algorithm

1. Upload images
2. Categorize images by specimen
  * manually
  * machine learning
  * embedded metadata (e.g. time photo taken)
3. Generate custom post type (Specimen) for each specimen
4. Web interface to update each specimen's data


## Specimen class

A custom post type for specimen (named Specimen) is used to store data.  It can be considered a class with the following attributes (shown are the key values of the WP database):
- inputGenus
- inputSection
- inputSpecies
- inputCollector
- inputNumber
- inputDeterminer
- inputHerbarium
- inputCountry
- inputDepartment
- inputMunicipality
- inputLocation (location information)
- imgs (array of images associated with specimen)
- finished (0 for unfinished, 1 for finished)
- inputIssue (string for issue associated with specimen, e.g. not enough images)
- history (assoc array with timestamp as key and user id as value)
- status (either 'finished' or 'unfinished')

## User roles

Subscriber
- can view only non-issue specimens
- read only access to data

Editor
- can view all specimens
- has access to 'View' dropdown
- can edit all data except for 'imgs' meta key

Administrator
- like editor but with added priveledge of editing the 'imgs' key


## Notes:

- a specimen is considered 'finished' if the specimen has data for both Collector and Number; in this case, the key 'status' will be set to 'finished'
- by default, any newly added specimen will have the status 'unfinished'
