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
- inputSpecies
- inputAuthority
- inputCollector
- inputNumber
- inputDeterminer
- inputHerbarium
- inputLocation (location information)
- inputLat (latitude)
- inputLon (longitude)
- imgs (array of images associated with specimen)
- finished (0 for unfinished, 1 for finished)
- inputIssue (string for issue associated with specimen, e.g. not enough images)
- history (assoc array with timestamp as key and user id as value)
- finished (if key is present, specimen is considered finished, otherwise specimen is not finished)

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

- a specimen is considered 'finished' if ...  An unfinished specimen will not have the key 'finished' specified
