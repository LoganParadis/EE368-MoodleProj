<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Strings for component 'tool_bulkenrol'.
 *
 * @package    tool_bulkenrol
 * @copyright  2011 Piers Harding
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['allowdeletes'] = 'Allow deletes';
$string['allowdeletes_help'] = 'Whether the delete field is accepted or not.';
$string['allowrenames'] = 'Allow renames';
$string['allowrenames_help'] = 'Whether the rename field is accepted or not.';
$string['allowresets'] = 'Allow resets';
$string['allowresets_help'] = 'Whether the reset field is accepted or not.';
$string['cachedef_helper'] = 'Helper caching';
$string['cannotdeletebulkusernotexist'] = 'Cannot delete a bulk user that does not exist';
$string['cannotforcelang'] = 'No permission to force language for this bulkuser';
$string['cannotgenerateshortnameupdatemode'] = 'Cannot generate a shortname when updates are allowed';
$string['cannotreadbackupfile'] = 'Cannot read the backup file';
$string['cannotrenamebulkusernotexist'] = 'Cannot rename a bulkuser that does not exist';
$string['cannotrenameidnumberconflict'] = 'Cannot rename the bulkuser, the ID number conflicts with an existing bulkuser';
$string['cannotrenameshortnamealreadyinuse'] = 'Cannot rename the bulkuser, the shortname is already used';
$string['cannotupdatefrontpage'] = 'You are not allowed to change the site home.';
$string['canonlyrenameinupdatemode'] = 'Can only rename a bulkuser when update is allowed';
$string['canonlyresetbulkuserinupdatemode'] = 'Can only reset a bulkuser in update mode';
$string['couldnotresolvecatgorybyid'] = 'Could not resolve category by ID';
$string['couldnotresolvecatgorybyidnumber'] = 'Could not resolve category by ID number';
$string['couldnotresolvecatgorybypath'] = 'Could not resolve category by path';
$string['bulkuserenrolled'] = 'User enrolled';
$string['bulkuserdeleted'] = 'bulkuser deleted';
$string['bulkuserdeletionnotallowed'] = 'bulkuser deletion is not allowed';
$string['bulkuserdoesnotexistandcreatenotallowed'] = 'The bulkuser does not exist and creating bulkuser is not allowed';
$string['bulkuserexistsanduploadnotallowed'] = 'The user is enrolled and update is not allowed';
$string['bulkuserfile'] = 'File';
$string['bulkuserfile_help'] = 'This file must be a CSV file.';
$string['bulkuseridnumberincremented'] = 'bulkuser ID number incremented {$a->from} -> {$a->to}';
$string['bulkuserprocess'] = 'bulkuser process';
$string['bulkuserrenamed'] = 'bulkuser renamed';
$string['bulkuserrenamingnotallowed'] = 'user renaming is not allowed';
$string['bulkuserreset'] = 'user reset';
$string['bulkuserresetnotallowed'] = 'user reset now allowed';
$string['bulkuserrestored'] = 'bulkuser restored';
$string['bulkuserstotal'] = 'bulkusers total: {$a}';
$string['bulkusersenrolled'] = 'bulkusers enrolled: {$a}';
$string['bulkuserserrors'] = 'bulkusers errors: {$a}';
$string['bulkusershortnameincremented'] = 'user shortname incremented {$a->from} -> {$a->to}';
$string['bulkusershortnamegenerated'] = 'user shortname generated: {$a}';
$string['bulkusertemplatename'] = 'Restore from this user after upload';
$string['bulkusertemplatename_help'] = 'Enter an existing user shortname to use as a template for the creation of all users.';
$string['bulkusertorestorefromdoesnotexist'] = 'The user to restore from does not exist';
$string['bulkuserupdated'] = 'bulkuser updated';
$string['useremail'] = 'User Email';
$string['userusername'] = 'Username';
$string['useridnumber'] = 'User ID Number';
$string['userid'] = 'User ID';
$string['courseshortname'] = 'Course Shortname';
$string['courseidnumber'] = 'Course ID Number';
$string['courseid'] = 'Course ID';
$string['roleshortname'] = 'Role Shortname';
$string['roleid'] = 'Role ID';
$string['createall'] = 'Create all, increment shortname if needed';
$string['createnew'] = 'Create new users only, skip existing ones';
$string['createorupdate'] = 'Create new users, or update existing ones';
$string['csvdelimiter'] = 'CSV separator';
$string['csvdelimiter_help'] = 'The character separating the series of data in each record.';
$string['csvfileerror'] = 'There is something wrong with the format of the CSV file. Please check the number of headings and columns match, and that the separator and file encoding are correct. {$a}';
$string['csvline'] = 'Line';
$string['defaultvalues'] = 'Default user values';
$string['defaultvaluescustomfieldcategory'] = 'Default values for \'{$a}\'';
$string['downloadcontentnotallowed'] = 'Configuring download of user content not allowed';
$string['encoding'] = 'Encoding';
$string['encoding_help'] = 'Encoding of the CSV file.';
$string['errorcannotcreateorupdateenrolment'] = 'Cannot create or update enrolment method \'{$a}\'';
$string['errorcannotdeleteenrolment'] = 'Cannot delete enrolment method \'{$a}\'';
$string['errorcannotdisableenrolment'] = 'Cannot disable enrolment method \'{$a}\'';
$string['errorwhilerestoringbulkuser'] = 'Error while restoring the user';
$string['errorwhiledeletingbulkuser'] = 'Error while deleting the user';
$string['generatedshortnameinvalid'] = 'The generated shortname is invalid';
$string['generatedshortnamealreadyinuse'] = 'The generated shortname is already in use';
$string['id'] = 'ID';
$string['importoptions'] = 'Import options';
$string['idnumberalreadyinuse'] = 'ID number already used by a user';
$string['invalidbackupfile'] = 'Invalid backup file';
$string['invalidbulkuserformat'] = 'Invalid user format';
$string['invalidcsvfile'] = 'Invalid input CSV file';
$string['invaliddownloadcontent'] = 'Invalid download of user content value';
$string['invalidencoding'] = 'Invalid encoding';
$string['invalidmode'] = 'Invalid mode selected';
$string['invalideupdatemode'] = 'Invalid update mode selected';
$string['invalidvisibilitymode'] = 'Invalid visible mode';
$string['invalidroles'] = 'Invalid role names: {$a}';
$string['invalidshortname'] = 'Invalid shortname';
$string['invalidfullnametoolong'] = 'The fullname field is limited to {$a} characters';
$string['invalidshortnametoolong'] = 'The shortname field is limited to {$a} characters';
$string['missingmandatoryfields'] = 'Missing value for mandatory fields: {$a}';
$string['missingshortnamenotemplate'] = 'Missing shortname and shortname template not set';

$string['invalidresolveuser'] = 'Invalid Resolve User By';
$string['invalidresolvecourse'] = 'Invalid Resolve Course By';
$string['invalidresolverole'] = 'Invalid Resolve Role By';

$string['resolveuser'] = 'Resolve User By';
$string['resolvecourse'] = 'Resolve Course By';
$string['resolverole'] = 'Resolve Role By';
$string['resolveuser_help'] = 'This allows you to specify how users should be resolved by.';
$string['resolvecourse_help'] = 'This allows you to specify how courses should be resolved by.';
$string['resolverole_help'] = 'This allows you to specify how roles should be resolved by.';
$string['nochanges'] = 'No changes';
$string['pluginname'] = 'bulkuser upload';
$string['preview'] = 'Preview';
$string['customfieldinvalid'] = 'Custom field \'{$a}\' is empty or contains invalid data';
$string['reset'] = 'Reset user after upload';
$string['reset_help'] = 'Whether to reset the user after creating/updating it.';
$string['result'] = 'Result';
$string['user_display'] = 'User Display';
$string['course_display'] = 'Course Display';
$string['role_display'] = 'Role Display';
$string['couldnotresolveuserbyid'] = 'Could not resolve user by id';
$string['couldnotresolveuserbyidnumber'] = 'Could not resolve user by idnumber';
$string['couldnotresolveuserbyusername'] = 'Could not resolve user by username';
$string['couldnotresolveuserbyemail'] = 'Could not resolve user by email';
$string['couldnotresolvecoursebyid'] = 'Could not resolve course by id';
$string['couldnotresolvecoursebyidnumber'] = 'Could not resolve course by idnumber';
$string['couldnotresolvecoursebyshortname'] = 'Could not resolve course by shortname';
$string['couldnotresolverolebyid'] = 'Could not resolve role by id';
$string['couldnotresolverolebyshortname'] = 'Could not resolve role by shortname';
$string['restoreafterimport'] = 'Restore after import';
$string['rowpreviewnum'] = 'Preview rows';
$string['rowpreviewnum_help'] = 'Number of rows from the CSV file that will be previewed on the following page. This option is for limiting the size of the following page.';
$string['shortnametemplate'] = 'Template to generate a shortname';
$string['shortnametemplate_help'] = 'The short name of the user is displayed in the navigation. You may use template syntax here (%f = fullname, %i = idnumber), or enter an initial value that is incremented.';
$string['templatefile'] = 'Restore from this file after upload';
$string['templatefile_help'] = 'Select a file to use as a template for the creation of all users.';
$string['unknownimportmode'] = 'Unknown import mode';
$string['updatemissing'] = 'Fill in missing items from CSV data and defaults';
$string['updatemode'] = 'Update mode';
$string['updatemode_help'] = 'If you allow users to be updated, you also have to tell the tool what to update the users with.';
$string['updatemodedoessettonothing'] = 'Update mode does not allow anything to be updated';
$string['updateonly'] = 'Only update existing users';
$string['updatewithdataordefaults'] = 'Update with CSV data and defaults';
$string['updatewithdataonly'] = 'Update with CSV data only';
$string['bulkenrols'] = 'Bulk Enrollments';
$string['bulkenrols_help'] = 'Users may be uploaded via text file. The format of the file should be as follows:

* Each line of the file contains one record
* Each record is a series of data separated by the selected separator
* The first record contains a list of fieldnames defining the format of the rest of the file
* Required fieldnames are shortname, fullname, and category';
$string['bulkenrolspreview'] = 'Upload users preview';
$string['bulkenrolsresult'] = 'Upload users results';
$string['privacy:metadata'] = 'The Bulk User Enrol upload plugin does not store any personal data.';
