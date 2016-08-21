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

A custom post type for specimen (named Specimen) is used to store data.  It can be considered a class with the following attributes:
- Genus
- Species
- Collector
- Number
- Namer (TODO)
- Location info
- Latitude
- Longitude
- Images (array of IMG url)
- Thumbnails (array of IMG thumbnail url)
- Status (e.g. finished, being edited, new, error, etc)
