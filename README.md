# BigBlueButton Learning Analytics Dashboard

## Description
- This functionality needs two plugins: local_bbb_lad and bbbext_lad
- It will collect learning analytics dashboard information from BigBlueButton via a callback
- This information can be seen by teachers with the new menu entry "Learning Analytics Dashboard" in any BigBlueButton activity.

## Installation
- put the local_bbb_lad plugin into /local
- put the bbbext_lad plugin into /mod/bigbluebuttonbn/extensions

## BigBlueButton Server-side settings
you have to set this on the server for the plugin to receive any data:
- defaultKeepEvents=true# moodle-bbbext_lad
